<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Contracts\ExamRepositoryInterface as ExamRepository;

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
        ExamRepository $examRepository
        ) {
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
        $this->viewData['exams'] = $this->examRepository->paginate();

        return view('admin.exam.index', $this->viewData);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exam = $this->examRepository->find($id);
        if ($exam->status == config('exam.status.start') || $exam->status == config('exam.status.testing')) {
            return redirect()->action('Admin\ExamsController@index')
                ->withErrors(trans('admin/exams.not-yet-done'));
        }

        $this->viewData['data'] = $this->examRepository->showExam($id);

        return view('admin.exam.detail', $this->viewData);
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
