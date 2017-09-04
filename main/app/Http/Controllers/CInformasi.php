<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class CInformasi extends Controller
{
    public function index(){
        return view('index');
    }
    public function home(){

            return view('index');

    }
    public function dashboardadmin(){
        if (session()->has('ID')) {
            return view('authenticated.dashboardadmin');
        }else{
            return view('index');
        }
    }
    public function login(){
        return view('loginpage');
    }
}
