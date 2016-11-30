<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Repositories\Contracts\QuestionRepositoryInterface as QuestionRepository;
use App\Repositories\Contracts\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\Contracts\ExamRepositoryInterface as ExamRepository;
use App\Http\Requests\StoreExam;
use Log;
use DB;
use Gate;

class ExamsController extends BaseController
{
    /**
     * @var questionRepository
     *
     * @var subjectRepository
     *
     * @var examRepository
     */
    private $questionRepository;
    private $subjectRepository;
    private $examRepository;
 
    public function __construct(
        QuestionRepository $questionRepository,
        SubjectRepository $subjectRepository,
        ExamRepository $examRepository
        ) {
 
        $this->questionRepository = $questionRepository;
        $this->subjectRepository = $subjectRepository;
        $this->examRepository = $examRepository;
        $this->viewData['title'] = trans('admin/question.title');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['subjectList'] = $this->subjectRepository->lists('name', 'id');
        $this->viewData['examsOfUser'] = $this->examRepository->getExamsOfUser();

        return view('web.exam.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExam $request)
    {
        DB::beginTransaction();

        try {
            if ($this->examRepository->storeExam($request->only('subject'))) {
                DB::commit();

                return redirect()->action('Web\ExamsController@index')
                    ->with('status', trans('messages.success.create-exam'));
            }
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollback();
        }

        return redirect()->action('Web\ExamsController@index')
            ->withErrors(trans('messages.failed.create-exam'));
    }

    /**
     * Do the specified exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exam = $this->examRepository->find($id);

        if ($exam->isOwnExam()) {
            $this->viewData['data'] = $this->examRepository->showExam($id);

            return view('web/exam.detail', $this->viewData);
        }

        if (Gate::allows('access-admin')) {
            return redirect()->action('Admin\ExamsController@show', ['id' => $id])
                ->with('status', trans('admin/exams.admin-check'));
        }

        return redirect()->action('Web\ExamsController@index')
            ->withErrors(trans('common/errors.forbidden'));
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
        DB::beginTransaction();
        try {
            $data = $request->only('exam', 'time_spent', 'commit');

            if ($this->examRepository->saveExam($data, $id)) {
                DB::commit();

                return redirect()->action('Web\ExamsController@index')
                    ->with('status', trans('messages.success.save-exam'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e);
        }

        return redirect()->action('Web\ExamsController@index')
            ->withErrors(trans('messages.failed.save-exam'));
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
