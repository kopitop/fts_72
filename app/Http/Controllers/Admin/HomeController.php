<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * Assign title to view data
     *
     * @return void
     */
    public function __construct() {
        $this->viewData['title'] = trans('admin/home.dialog-title.dashboard');
    }

    /**
     * Display dashboard UI
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return view('admin.home', $this->viewData);
    }
}
