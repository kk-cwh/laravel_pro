<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Access;
use Illuminate\Http\Request;
use \Validator;
use \DB;

class AccesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accessList = Access::paginate(5);
//        return response()->json(['success' => true, 'data' => $accessList]);
        return view('access', ['data' => ['title' => '权限列表', 'accessList' => $accessList]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('access_add', ['data' => ['title' => '新增权限']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'urls' => $request->get('urls'),
            'method' => $request->get('method'),
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $rules = ['title' => 'required|string|min:2|max:12', 'urls' =>'required|string' ,'method'=>'required'];
        $messages = [
            'required' => ':attribute field is required.',
            'min' => ':attribute 最小长度为:min.',
            'max' => ':attribute 最大长度为:max.',
        ];
        $attributes = [
            'title' => '权限名称'
        ];

        $validator = Validator::make($input, $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }
        $isAlready = DB::table('access')->where('title', $input['title'])->first();
        if ($isAlready) {
            return response()->json(['success' => false, 'reason' => '权限名称已存在']);
        }
        $accessId = DB::table('access')->insertGetId($input);
        return response()->json(['success' => true, 'data' => ['accessId' => $accessId]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $accessInfo = Access::find($id);
        return view('access_edit', ['data' => ['title' => '编辑用户', 'accessInfo' => $accessInfo]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $accessId)
    {
//        $accessId = $request->get('id', 0);
        $accessInfo = Access::find($accessId);

        $title = $request->get('title');
        $urls = $request->get('urls');
        $description = $request->get('description');

        $rules = ['title' => 'required|string',];
        $messages = [
            'required' => ':attribute  field is required . ',
            'string' => ':attribute  field is required string . ',

        ];
        $attributes = ['title' => '权限名称'];

        $validator = Validator::make(['title' => $title], $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }

        if (!$accessInfo) {
            return response()->json(['success' => false, 'reason' => '权限id有误']);

        } else {
            $existAccess = DB::table('access')->where('title', $title)->first();
            if ($existAccess && ($existAccess->id != $accessId)) {
                return response()->json(['success' => false, 'reason' => '权限名称已存在']);

            }
            $res = DB::table('access')->where('id', $accessId)->update(['title' => $title, 'urls' => $urls, 'description' => $description, 'updated_at' => time()]);
            return response()->json(['data' => $res]);
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