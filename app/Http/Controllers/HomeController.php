<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     
    public function traer()
    {
        $per=persona::all();
        $per=persona::paginate(5);
        return view ('home', compact('per'));
    }
*/

     
}
