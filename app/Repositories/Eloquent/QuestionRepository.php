<?php  

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Auth\Factory as Auth;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
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
        return 'App\Models\Question';
    }
    
    /**
     * Store a new question in repository
     *
     * @throws Exception
     *
     * @param array $input
     *
     * @return mixed
     */
    public function storeQuestion(array $input)
    {   
        $data['question'] = [
            'user_id' => $this->auth->user()->id,
            'subject_id' => $input['subject'],
            'content' => $input['content'],
            'status' => $input['active'],
            'type' => $input['type'],
        ];

        return $this->model->create($data['question'])
            ->systemAnswers()->createMany($input['answer']);
    }
}
