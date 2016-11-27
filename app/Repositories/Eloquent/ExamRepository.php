<?php  

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\ExamRepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\Subject;
use App\Models\Result;
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

        for ($i=0; $i < $quantity; $i++) { 
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
        $data['results'] = Result::with('question')
            ->where('exam_id', '=', $data['exam']->id)->get();

        //Get all questions associate with result
        foreach ($data['results'] as $key => $result) {
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
    public function saveExam($input, $id, $isFinished = false)
    {
        $exam = $this->model->findOrFail($id);

        //Can update?
        if ($exam->status != config('exam.status.testing')) {
            return false;
        }

        //Finish or save?
        if ($isFinished) {
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

            //Update exam answers for each result row
            if ($result->question->type != config('question.type.text') && isset($item['answer'])) {
                $data['answer'] = [];
                foreach ($item['answer'] as $value) {
                    $data['answer'][] = array(
                            'system_answer_id' => $value,
                        );
                }

                $result->examAnswers()->createMany($data['answer']);
            } elseif($result->question->type == config('question.type.text') && isset($item['answer'])) {
                $result->examAnswers()->create([
                        'content' => $item['answer'],
                    ]);
            }
        }

        return $this;
    }
}
