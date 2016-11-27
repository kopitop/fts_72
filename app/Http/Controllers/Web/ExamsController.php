<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Repositories\Contracts\QuestionRepositoryInterface as QuestionRepository;
use App\Repositories\Contracts\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\Contracts\ExamRepositoryInterface as ExamRepository;
use Log;
use DB;

class ExamsController extends BaseController
{
    /**
     * @var questionRepository
     *
     * @var subjectRepository
     */
    private $questionRepository;
    private $subjectRepository;
 
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|in:' . $this->subjectRepository->lists('id')->implode(','),
        ]);

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
        $this->viewData['data'] = $this->examRepository->showExam($id);
        //can update lai status exam

        return view('web/exam.detail', $this->viewData);
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
        $data = $request->only('exam');

        if ($request->input('commit') == config('exam.commit.save')) {
            $this->examRepository->saveExam($data, $id);
        } elseif ($request->input('commit') == config('exam.commit.finish')) {
            $this->examRepository->finishExam($data);
        }
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
