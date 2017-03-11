<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Validator;

class AccessController extends Controller
{
    /**
     * 查询所有权限列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $accessList = Access::all();
        return response()->json(['success' => true, 'data' => $accessList]);

    }

    /**
     * 添加角色
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
        $accessInfo = Access::find($roleId);

        $title = $request->get('title');
        $description = $request->get('description');


        if (!$accessInfo) {
            return response()->json(['success' => false, 'reason' => '权限id有误']);

        } else {
            $existAccess = DB::table('access')->where('title', $title)->first();
            if ($existAccess && ($existAccess->id != $roleId)) {

                return response()->json(['success' => false, 'reason' => '角色名称已存在']);

            }
            $res = DB::table('title')->where('id', $roleId)->update(['title' => $title, 'description' => $description, 'updated_at' => time()]);
            return response()->json(['data' => $res]);
        }
    }

    /**
     * 删除权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delAccess(Request $request){
        return response()->json(['success'=>true]);
    }
}