<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Access;
use Illuminate\Http\Request;
use \Validator;
use \DB;

class AccessController extends Controller
{
    /**
     * 查询所有权限列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $accessList = Access::all(['id','title','urls']);
        return response()->json(['success' => true, 'data' => $accessList]);

    }

    /**
     * 添加权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function save(Request $request)
    {
        $input = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $rules = ['title' => 'required|string|min:2|max:12'];
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
     * 编辑权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modify(Request $request)
    {
        $accessId = $request->get('id', 0);
        $accessInfo = Access::find($accessId);

        $title = $request->get('title');
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
            $res = DB::table('access')->where('id', $accessId)->update(['title' => $title, 'description' => $description, 'updated_at' => time()]);
            return response()->json(['data' => $res]);
        }
    }

    /**
     * 删除权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delAccess(Request $request)
    {
        return response()->json(['success' => true]);
    }
}