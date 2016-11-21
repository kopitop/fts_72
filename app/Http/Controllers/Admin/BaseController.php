<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Subject\SubjectRepositoryInterface as Subject;

class BaseController extends Controller
{
    /**
     * @var viewData
     */
    private $viewData;
}
