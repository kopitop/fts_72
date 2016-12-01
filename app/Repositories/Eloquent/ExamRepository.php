<?php  

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\ExamRepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\Subject;
use App\Models\Result;
use App\Models\Question;
use DB;

class ExamRepository extends BaseRepository implements ExamRepositoryInterface
{
    /**
     * @var
     */
    protected $auth;

    /**
     * Create contracts instance.
     *
     * @param  Auth  $auth
     * @return void
     */
    public function __construct(App $app, Auth $auth)
    {   
        parent::__construct($app);
        $this->auth = $auth;
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Exam';
    }

    /**
     * Store all data of a exam
     *
     * @param array $input
     *
     * @return mixed
     */
    public function storeExam($input)
    {   
        $data['subject'] = Subject::findOrFail($input['subject']);

        $data['exam'] = [
            'subject_id' => $data['subject']->id,
            'user_id' => $this->auth->user()->id,
            'time_spent' => config('exam.time.begin'),
            'status' => config('exam.status.start')
        ];

        $quantity = $data['subject']->number_of_question;

        for ($i = 0; $i < $quantity; $i++) { 
            $data['results'][] = [
                'question_id' => $data['subject']->questions()
                    ->inRandomOrder()->first()->id
            ];
        }

        return $this->model->create($data['exam'])
            ->results()->createMany($data['results']);

    }

    /**
     * Get all data exams of a user
     *
     * @return mixed
     */
    public function getExamsOfUser()
    {
        return $this->model
            ->where('user_id', '=', $this->auth->user()->id)->get();
    }

    /**
     * Get data of a exam
     *
     * @param int $id
     *
     * @return mixed
     */
    public function showExam($id)
    {
        $data['exam'] = $this->model->findOrFail($id);

        //Update status
        if ($data['exam']->status == config('exam.status.start')) {
            $data['exam']->fill(['status' => config('exam.status.testing')]);
            $data['exam']->save();
        }

        //Get all results associate with exam
        $results = Result::with('question')
            ->where('exam_id', '=', $data['exam']->id)->get();

        //Get all questions associate with result
        foreach ($results as $key => $result) {
            $data['questions'][$key]['result'] = $result;
            $data['questions'][$key]['content'] = $result->question;

            //Get all answers associate with question
            foreach ($data['questions'][$key]['content']->systemAnswers as $answer) {
                $data['questions'][$key]['answers'][] = $answer;
            }
        }

        return $data;
    }

    /**
     * Save data of a exam
     *
     * @param int $id, array $data
     *
     * @return mixed
     */
    public function saveExam($input, $id)
    {
        $exam = $this->model->findOrFail($id);

        //Can update?
        if ($exam->status != config('exam.status.testing')) {
            return false;
        }

        //Init data of exam
        $data = [];

        //Finish or save?
        if ($input['commit'] == config('exam.commit.finish')) {
            $data['exam']['status'] = config('exam.status.unchecked');
        }

        //Update exam time_spent
        $data['exam']['time_spent'] = $input['time_spent'];

        //Fill DB
        $exam->fill($data['exam']);
        $exam->save();

        //First, initerate exam input
        foreach ($input['exam'] as $item) {

            //Get result row for each input item
            $result = Result::findOrFail($item['result']);

            //Delete old answers
            $result->examAnswers()->forceDelete();

            //Update new exam answers for each result row
            if ($result->question->type != config('question.type.text') && isset($item['answer'])) {
                $data['answer'] = [];
                foreach ($item['answer'] as $value) {
                    $data['answer'][] = [
                        'system_answer_id' => $value,
                    ];
                }

                $result->examAnswers()->createMany($data['answer']);
            } elseif ($result->question->type == config('question.type.text') && isset($item['answer'])) {
                $result->examAnswers()->create([
                    'content' => $item['answer'],
                ]);
            }
        }

        return $this;
    }

    /**
     * Check result of a exam
     *
     * @param int $id, array $data
     *
     * @return mixed
     */
    public function checkExam($input, $id)
    {
        $exam = $this->model->findOrFail($id);

        //Map results input
        $inputResult = [];
        foreach ($input['exam'] as $key => $item) {
            if (isset($item['result']['correct'])) {
                $inputResult[$item['result']['id']] = $item['result']['correct'];
            }
        }

        //Update results for choices questions
        foreach ($exam->results as $result) {
            $question = $result->question;
            if ($question->type == config('question.type.single-choice')) {
                $result->fill([
                    'is_correct' => $result->examAnswers()->first() ? 
                        $result->examAnswers()->first()
                            ->systemAnswer()->first()->is_correct : config('answer.correct.false')
                    ])
                    ->save();

            } elseif ($question->type == config('question.type.multiple-choice')) {
                //Compare exam answers with true answers
                $trueAnswers = $question->systemAnswers()
                    ->where('is_correct', config('answer.correct.true'))->get(['id'])->toArray();
                $examAnswers = $result->examAnswers()->get(['system_answer_id'])->toArray();
                $trueAnswersArray = [];
                foreach ($trueAnswers as $answer) {
                    $trueAnswersArray[] = $answer['id'];
                }
                $examAnswersArray = [];
                foreach ($examAnswers as $answer) {
                    $examAnswersArray[] = $answer['system_answer_id'];
                }
                if (array_diff($trueAnswersArray, $examAnswersArray)) {
                    $result->fill(['is_correct' => config('answer.correct.false')])->save();
                } else {
                    $result->fill(['is_correct' => config('answer.correct.true')])->save();
                }
            } else {
                $result->fill(['is_correct' => $inputResult[$result->id]])->save();
            }
        }

        //Update status
        $exam->fill([
            'status' => config('exam.status.checked'),
            'score' => $exam->results()->where('is_correct', config('answer.correct.true'))->count(),
        ])->save();

        return $exam;
    }
}
