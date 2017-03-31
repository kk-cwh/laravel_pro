<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cateList = Cate::paginate(2);
//        return $cateList;
        return view('cate', ['data' => ['title' => '分类列表', 'cateList' => $cateList]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cate_add', ['data' => ['title' => '添加分类']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->has('name') ? trim($request->get('name')) : null;
        if (isset($name) && $name != '') {
            $isAlready = DB::table('cate')->where('name', $name)->first();
            if ($isAlready) {
                return response()->json(['success' => false, 'reason' => '分类名称已存在']);
            }
            DB::table('cate')->insert(['name' => $name, 'created_at' => time(), 'updated_at' => time()]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'reason' => '分类名称参数有误']);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cate = Cate::find($id);
        return view('cate_edit', ['data' => ['title' => '分类', 'cate' => $cate]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = Cate::find($id);
        return view('cate_edit', ['data' => ['title' => '分类', 'cate' => $cate]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->has('name') ? trim($request->get('name')) : null;

        $cate = Cate::find($id);
        if (!$cate) {
            return response()->json(['success' => false, 'reason' => 'id有误']);

        } else if (isset($name) && $name != '') {
            $isAlready = DB::table('cate')->where('name', $name)->first();
            if ($isAlready && $isAlready->id != $id) {
                return response()->json(['success' => false, 'reason' => '分类名称已存在']);
            }

            DB::table('cate')->where('id', $id)->update(['name' => $name, 'updated_at' => time()]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'reason' => '分类名称参数有误']);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
