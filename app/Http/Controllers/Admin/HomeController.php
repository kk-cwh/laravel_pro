<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        return view('home',['data'=>['title'=>'主页','content'=>'这里是主页了啊芭芭拉。。。']]);

    }
    public function page1(){

        return view('home',['data'=>['title'=>'page1','content'=>'这里是page1了啊芭芭拉。。。']]);

    }
    public function page2(){

        return view('home',['data'=>['title'=>'page2','content'=>'这里是page2了啊芭芭拉。。。']]);

    }
    public function page3(){

        return view('home',['data'=>['title'=>'page3','content'=>'这里是page3了啊芭芭拉。。。']]);

    }
}
