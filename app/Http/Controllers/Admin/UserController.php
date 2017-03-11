<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        return view('home');

    }


    function login(Request $request)
    {
//        $u = new User();
//        $u->name = '张三';
//        $u->email = 'zhangsan@126.com';
//        $u->is_admin =1;
//        $u->status = 1;
//        $u->created_at = 0;
//        $u->updated_at = 0;
//        $u->save();
        $userId = $request->get('uid', 0);
        if (!$userId) {
            return response()->json(['success' => false, 'reason' => '账号id有误']);

        }
        $userInfo = User::find($userId);
        if (!$userInfo) {
            return response()->json(['success' => false, 'reason' => '用户不存在']);
        }

        return response()->json(['success' => true, 'data' => $userInfo]);;
    }


    /**
     * 查询所有用户列表分页
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $userList = User::all();
        return response()->json(['success' => true, 'data' => $userList]);

    }

    /**
     * 添加用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function save(Request $request)
    {
        $input = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
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
            return response()->json(['success' => false, 'reason' => '用户名称已存在']);
        }
        $userId = DB::table('user')->insertGetId($input);
        return response()->json(['success' => true, 'data' => ['userId' => $userId]]);
    }

    /**
     * 编辑用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modify(Request $request)
    {
        $userId = $request->get('id', 0);
        $userInfo = User::find($userId);

        $name = $request->get('name');
        $email = $request->get('email');


        if (!$userInfo) {
            return response()->json(['success' => false, 'reason' => '用户id有误']);

        } else {
            $existRole = DB::table('user')->where('name', $name)->first();
            if ($existRole && ($existRole->id != $userId)) {
                return response()->json(['success' => false, 'reason' => '角色名称已存在']);

            }
            $res = DB::table('user')->where('id', $userId)->update(['name' => $name, 'email' => $email, 'updated_at' => time()]);
            return response()->json(['data' => $res]);
        }
    }

    /**
     * 设置用户角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setUserRole(Request $request)
    {
        return response()->json(['success' => true]);
    }
}