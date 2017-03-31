<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{

    public function page1(){

        return view('page',['data'=>['title'=>'page1','content'=>'这里是page1了啊芭芭拉。。。']]);

    }
    public function page2(){

        return view('page',['data'=>['title'=>'page2','content'=>'这里是page2了啊芭芭拉。。。']]);

    }
    public function page3(){

        return view('page',['data'=>['title'=>'page3','content'=>'这里是page3了啊芭芭拉。。。']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    $image = new \App\Lib\Captcha();
         response('',200,['Content-Type'=>'image/gif']);
        $content = $image->create();
        return response($content, 200, [
            'Content-Type' => 'image/png',
        ]);
//        return view('home',['data'=>['title'=>'主页','content'=>'这里是主页了啊芭芭拉。。。']]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back_login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
