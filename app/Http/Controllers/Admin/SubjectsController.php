<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Subject\SubjectRepositoryInterface as Subject;
use App\Http\Requests\StoreSubject;

class SubjectsController extends BaseController
{
    /**
     * @var Subject
     */
    private $subject;
 
    public function __construct(Subject $subject) {
 
        $this->subject = $subject;
        $this->viewData['title'] = trans('admin/subject.title');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['subjects'] = $this->subject->all();

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
            $this->subject->create($input);
        } catch (Exception $e) {

            return back()->withError(trans('messages.create.error'));
        }

        return redirect()->action('Admin\SubjectsController@index')->with('message', trans('messages.success.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->viewData['subject'] = $this->subject->find($id);

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
