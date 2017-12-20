<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Input;
use Validator;
use \App\Courses as Courses;
use \App\Subjects as Subjects;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

        
    public function index()
    {
        $csrf = csrf_token();
        $type = \Auth::user()->type;
        $user = \Auth::user();

        return view('index', compact('type', 'user', 'csrf'));
    }

    public function getLogout() 
    {
        \Auth::logout();
        return redirect('/auth/login');
    }

//      public function getLockOut() 
//     {
//         \Auth::logout();
//         return redirect('/auth/lock');
//     }
 }
