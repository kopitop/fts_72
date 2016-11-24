<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Contracts\SubjectRepositoryInterface as SubjectRepository;
use App\Http\Requests\StoreSubject;
use App\Http\Requests\UpdateSubject;
use Exception;
use Log;

class SubjectsController extends BaseController
{
    /**
     * @var Subject
     */
    private $subjectRepository;
 
    public function __construct(SubjectRepository $subjectRepository) {
 
        $this->subjectRepository = $subjectRepository;
        $this->viewData['title'] = trans('admin/subject.title');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['subjects'] = $this->subjectRepository->paginate();

        return view('admin.subject.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subject.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubject $request)
    {   
        try {
            $input = $request->only('name', 'duration', 'number_of_question');
            $this->subjectRepository->create($input);
        } catch (Exception $e) {
            Log::debug($e);

            return back()->withErrors(trans('messages.errors.create'));
        }

        return redirect()->action('Admin\SubjectsController@index')
            ->with('status', trans('messages.success.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->viewData['subject'] = $this->subjectRepository->find($id);
        
        return view('admin.subject.detail', $this->viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->viewData['subject'] = $this->subjectRepository->find($id);

        return view('admin.subject.edit', $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubject $request, $id)
    {
        try {
            $input = $request->only('name', 'duration', 'number_question');
            foreach ($input as $key => $value) {
                if (empty($value)) {
                    unset($input[$key]);
                }
            }

            $this->subjectRepository->update($input, $id);
        } catch (Exception $e) {
            Log::debug($e);

            return back()->withErrors(trans('messages.errors.update'));
        }

        return redirect()->action('Admin\SubjectsController@show', ['id' => $id])
            ->with('status', trans('messages.success.update'));
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
