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
     * 设置角色权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setRoleAccess(Request $request)
    {
        return response()->json(['success' => true]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleList = Role::all(['id', 'name']);
//        return response()->json(['success' => true, 'data' => $roleList]);
        return view('role', ['data' => ['title' => '角色列表', 'roleList' => $roleList]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accessList = DB::table('access')->select('id', 'title', 'status')->where('status', '=', 1)->get();
        return view('role_add', ['data' => ['title' => '新增角色', 'accessList' => $accessList]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accessIds = $request->get('accessId');
        $input = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $rules = ['name' => 'required|string|min:2|max:12'];
        $messages = [
            'required' => ':attribute field is required.',
            'min' => ':attribute 最小长度为:min.',
            'max' => ':attribute 最大长度为:max.',
        ];
        $attributes = [
            'name' => '角色名称'
        ];

        $validator = Validator::make($input, $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }
        $isAlready = DB::table('role')->where('name', $input['name'])->first();
        if ($isAlready) {
            return response()->json(['success' => false, 'reason' => '角色名称已存在']);
        }


        $roleId = DB::table('role')->insertGetId($input);
        if (is_array($accessIds) && count($accessIds)) {
            $accessIds = array_unique($accessIds);
            foreach ($accessIds as $accessId) {
                $accessInfo = DB::table('access')->where('id', $accessId)->first();
                if ($accessInfo) {
                    DB::table('role_access')->insert(['role_id' => $roleId, 'access_id' => $accessId, 'created_at' => time(), 'updated_at' => time()]);
                }
            }
        }
        return response()->json(['success' => true, 'data' => ['roleId' => $roleId]]);
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
        $roleInfo = DB::table('role')->select('id', 'name', 'description')->where('id', '=', $id)->first();
        $accessList = DB::table('access')->select('id', 'title', 'status')->where('status', '=', 1)->get();
        $roleAccessIds = DB::table('role_access')->select('access_id')->where('role_id', '=', $id)->get()->toArray();
        $roleAccessIds = array_column($roleAccessIds, 'access_id');
        return view('role_edit', ['data' => ['title' => '编辑角色', 'roleInfo' => $roleInfo, 'accessList' => $accessList
            , 'roleAccessIds' => $roleAccessIds]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $roleId)
    {
        $accessIds = $request->get('accessId');
        $roleInfo = Role::find($roleId);

        $name = $request->get('name');
        $description = $request->get('description');

        $rules = ['name' => 'required|string|min:2|max:12'];
        $messages = [
            'required' => ':attribute field is required.',
            'min' => ':attribute 最小长度为:min.',
            'max' => ':attribute 最大长度为:max.',
        ];
        $attributes = [
            'name' => '角色名称'
        ];

        $validator = Validator::make([
            'name' => $name,
            'description' => $description,
        ], $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }

        if (!$roleInfo) {
            return response()->json(['success' => false, 'reason' => '角色id有误']);

        } else {
            $existRole = DB::table('role')->where('name', $name)->first();
            if ($existRole && ($existRole->id != $roleId)) {

                return response()->json(['success' => false, 'reason' => '角色名称已存在']);

            }
            DB::beginTransaction();
            try {
                if (is_array($accessIds) && count($accessIds)) {
                    $accessIds = array_unique($accessIds);
                    $roleAccessIds = DB::table('role_access')->select('access_id')->where('role_id', '=', $roleId)->get()->toArray();
                    $roleAccessIds = array_column($roleAccessIds, 'access_id');
                    $delRoleAccessIds = array_diff($roleAccessIds, $accessIds);
                    foreach ($delRoleAccessIds as $acessId) {
                        DB::table('role_access')->where('role_id', $roleId)->where('access_id', $acessId)->delete();
                    }
                    $addRoleAccessIds = array_diff($accessIds, $roleAccessIds);
                    foreach ($addRoleAccessIds as $accessId) {
                        $access = DB::table('access')->where('id', $accessId)->where('status', 1)->first();
                        if ($access) {
                            DB::table('role_access')->insert(['access_id' => $accessId, 'role_id' => $roleId, 'created_at' => time(), 'updated_at' => time()]);
                        }
                    }
                }else{
                    DB::table('role_access')->where('role_id', $roleId)->delete();
                }

                $res = DB::table('role')->where('id', $roleId)->update(['name' => $name, 'description' => $description, 'updated_at' => time()]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'reason' => 'sorry,系统繁忙!']);
            }
            DB::commit();

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