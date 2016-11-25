<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Contracts\QuestionRepositoryInterface as QuestionRepository;
use App\Repositories\Contracts\SubjectRepositoryInterface as SubjectRepository;
use App\Http\Requests\StoreQuestion;
use Log;
use DB;


class QuestionsController extends BaseController
{
    /**
     * @var Subject
     */
    private $questionRepository;
 
    public function __construct(
        QuestionRepository $questionRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->questionRepository = $questionRepository;
        $this->subjectRepository = $subjectRepository;
        $this->viewData['title'] = trans('admin/question.title');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['questions'] = $this->questionRepository
            ->with('subject', 'user')->paginate();

        return view('admin.question.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->viewData['subjectsList'] = $this->subjectRepository
            ->lists('name', 'id');

        return view('admin.question.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestion $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->only('subject', 'content', 'active', 'type', 'answer');
            if ($this->questionRepository->storeQuestion($input)) {
                DB::commit();

                return redirect()->action('Admin\QuestionsController@index')
                    ->with('status', trans('common/messages.success.create'));
            }
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollback();
        }

        return redirect()->action('Admin\QuestionsController@index')
                ->withErrors(trans('common/messages.falied.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->viewData['question'] = $this->questionRepository->find($id);

        return view('admin.question.detail', $this->viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
