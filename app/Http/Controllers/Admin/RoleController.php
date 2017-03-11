<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Validator;

class RoleController extends Controller
{
    /**
     * 查询所有角色列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $roleList = Role::all();
        return response()->json(['success' => true, 'data' => $roleList]);

    }

    /**
     * 添加角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function save(Request $request)
    {
        $input = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $rules = ['name' => 'required|numeric'];
        $messages = [
            'required' => 'The  field is required.',

        ];

        $validator = Validator::make($input, $rules, $messages);
        $isAlready = DB::table('role')->where('name', $input['name'])->first();
        if ($isAlready) {
            return response()->json(['success' => false, 'reason' => '角色名称已存在']);
        }
        $roleId = DB::table('role')->insertGetId($input);
        return response()->json(['success' => true, 'data' => ['roleId' => $roleId]]);
    }

    /**
     * 编辑角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modify(Request $request)
    {
        $roleId = $request->get('id', 0);
        $roleInfo = Role::find($roleId);

        $name = $request->get('name');
        $description = $request->get('description');


        if (!$roleInfo) {
            return response()->json(['success' => false, 'reason' => '角色id有误']);

        } else {
            $existRole = DB::table('role')->where('name', $name)->first();
            if ($existRole && ($existRole->id != $roleId)) {

                return response()->json(['success' => false, 'reason' => '角色名称已存在']);

            }
            $res = DB::table('role')->where('id', $roleId)->update(['name' => $name, 'description' => $description, 'updated_at' => time()]);
            return response()->json(['data' => $res]);
        }
    }

    /**
     * 设置角色权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setRoleAccess(Request $request){
        return response()->json(['success'=>true]);
    }
}