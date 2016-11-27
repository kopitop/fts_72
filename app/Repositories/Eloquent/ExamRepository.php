<?php  

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\ExamRepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\Subject;
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

        $data['results'] = $data['exam']->results;

        foreach ($data['results'] as $key => $result) {
            $data['questions'][$key]['result'] = $result;
            $data['questions'][$key]['content'] = $result->question;

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
        DB::beginTransaction();
        $exam = $this->model->findOrFail($id);

        $data['exam'] = $input['exam']['time_spent'];
        $exam->fill($input['exam']);
        $exam->save();

        foreach ($input['exam'] as $exam) {
            $result = Result::findOrFail($exam['result']);

            $result->examAnswers()->delete();

            foreach ($exam['answer'] as $answer) {
                $data['answer'] = [
                    'content'
                ]
            }

            $result->examAnswers()->create([
                    'content' => $exam['answer']['text'];
                    'content' => $exam['answer']['text'];
                ]);
        }

        DB::rollback();

    }
}
