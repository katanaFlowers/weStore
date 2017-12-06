<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entify\CategoryClass;


class AdminController extends Controller
{

    public function toLogin()
    {
      return view('admin.login');
    }

    public function checkLogin()
    {
      return redirect('admin/index');
    }

    public function toIndex()
    {
      return view('admin.index');
    }


    public function categoryAdd()
    {
      return view('admin.categoryAdd');
    }

    public function productAdd()
    {
      $categorys = CategoryClass::whereNotNull('parent_id')->get();
      return view('admin.productAdd')->with('categorys',$categorys);
    }
}
