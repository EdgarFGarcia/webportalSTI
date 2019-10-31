<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pageController extends Controller
{
    //
    public function index(){
    	return view('main');
    }

    // registration page
    public function register(){
        return view('register');
    }

    public function verifyhome(){
        return view('verifyhome');
    }

    public function announcement(){
        return view('announcement');
    }
}
