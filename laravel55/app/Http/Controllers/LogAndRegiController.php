<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogAndRegiController extends Controller
{
    public function login(Request $request)
    {
      $return_url = isset($_GET['return_url']) ? $_GET['return_url'] : '';
      //$return_url = $request->input('return_url','');
      return view('loginandregister.login')->with('return_url',urldecode($return_url));
    }

    public function register()
    {
      return view('loginandregister.register');
    }
}
