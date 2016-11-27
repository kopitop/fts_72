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
}
