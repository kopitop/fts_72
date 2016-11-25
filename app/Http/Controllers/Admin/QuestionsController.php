<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Contracts\QuestionRepositoryInterface as QuestionRepository;
use App\Repositories\Contracts\SubjectRepositoryInterface as SubjectRepository;
use App\Http\Requests\StoreQuestion;
use App\Http\Requests\UpdateQuestion;
use Log;
use DB;
use Exception;

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
                ->withErrors(trans('common/messages.failed.create'));
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
        $this->viewData['question'] = $this->questionRepository->find($id);
        $this->viewData['subjectsList'] = $this->subjectRepository
            ->lists('name', 'id');

        return view('admin.question.edit', $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestion $request, $id)
    {
        DB::beginTransaction();
        try{
            $input = $request->only('subject', 'content', 'active', 'type', 'answer');

            if ($this->questionRepository->updateQuestion($input, $id)) {
                return redirect()->action('Admin\QuestionsController@show', ['id' => $id])
                    ->with('status', trans('messages.success.update'));
            }
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e);
        }

        return redirect()->action('Admin\QuestionsController@index')
            ->withErrors(trans('messages.failed.update'));
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
