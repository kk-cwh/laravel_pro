<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use \Validator;
use \DB;

class UserController extends Controller
{
    function loginView(Request $request)
    {
        return view('back_login');
    }
    function login(Request $request)
    {

        $code = $request->get('code');

        return \Session::get('captcha_code');


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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = User::paginate(2);
//        return response()->json(['success' => true, 'data' => $userList]);
        return view('user', ['data' => ['title' => '用户列表', 'userList' => $userList]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleList = DB::table('role')->select('id', 'name', 'status')->where('status', '=', 1)->get();
//        return response()->json( ['data' => ['title' => '新增用户', 'roles' => $roleList]]);
        return view('user_add', ['data' => ['title' => '新增用户', 'roles' => $roleList]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roleIds = $request->get('roleId');
        $input = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'is_admin' => 1,
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $request->get('roleId');
        $rules = ['name' => 'required|string', 'email' => 'required|email',];
        $messages = [
            'required' => ':attribute  field is required . ',
            'string' => ':attribute  field is required string . ',
            'email' => ':attribute  field is required email . ',
        ];
        $attributes = ['name' => '姓名', 'email' => '邮箱'];

        $validator = Validator::make($input, $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }

        $isAlready = DB::table('user')->where('name', $input['name'])->first();
        if ($isAlready) {
            return response()->json(['success' => false, 'reason' => '用户名称已存在']);
        }
        DB::beginTransaction();
        try {
            $userId = DB::table('user')->insertGetId($input);
            if (is_array($roleIds) && count($roleIds)) {
                $roleIds = array_unique($roleIds);
                foreach ($roleIds as $rId) {
                    $role = DB::table('role')->where('id', $rId)->where('status', 1)->first();
                    if ($role) {
                        DB::table('user_role')->insert(['user_id' => $userId, 'role_id' => $rId, 'created_at' => time(), 'updated_at' => time()]);
                    }
                }

            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'reason' => 'sorry,系统繁忙!']);
        }
        DB::commit();

        return response()->json(['success' => true, 'data' => ['userId' => $userId]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $userId =2;
        $method = 'GET';
        $res = DB::table('user')
            ->join('user_role', 'user.id', '=', 'user_role.user_id')
            ->join('role_access', 'user_role.role_id', '=', 'role_access.role_id')
            ->join('access', 'access.id', '=', 'role_access.access_id')
            ->select('access.id', 'access.urls', 'access.method')
            ->where('user.id','=',$userId)
            ->where('access.method','=',$method)
            ->get();
        $path = $request->path();
        $canFanwen = false;
        foreach ($res as $url){
            $m = $this->urlMatch($url->urls,$path);
            if ($m){
                $canFanwen = 'yes';
                break;
            }
        }

        return response()->json(['success' => true, 'data' => $res,'url'=>$canFanwen]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userId = $id;
        $userInfo = User::find($userId);
        $roleList = DB::table('role')->select('id', 'name', 'status')->where('status', '=', 1)->get();
        $userRoleIds = DB::table('user_role')->select('role_id')->where('user_id', '=', $userId)->get()->toArray();
        $userRoleIds = array_column($userRoleIds, 'role_id');
        return view('user_edit', ['data' => ['title' => '编辑用户', 'roles' => $roleList, 'userInfo' => $userInfo, 'userRoleIds' => $userRoleIds, 'roleList' => $roleList]]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId)
    {

        $userInfo = User::find($userId);
        $roleIds = $request->get('roleId');

        $name = $request->get('name');
        $email = $request->get('email');

        $rules = ['name' => 'required|string', 'email' => 'required|email',];
        $messages = [
            'required' => ':attribute  field is required . ',
            'string' => ':attribute  field is required string . ',
            'email' => ':attribute  field is required email . ',
        ];
        $attributes = ['name' => '姓名', 'email' => '邮箱'];

        $validator = Validator::make(['name' => $name, 'email' => $email], $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }

        if (!$userInfo) {
            return response()->json(['success' => false, 'reason' => '用户id有误']);

        } else {
            $existRole = DB::table('user')->where('name', $name)->first();
            if ($existRole && ($existRole->id != $userId)) {
                return response()->json(['success' => false, 'reason' => '用户名已存在']);

            }
            DB::beginTransaction();
            try {
                if (is_array($roleIds) && count($roleIds)) {
                    $roleIds = array_unique($roleIds);
                    $userRoleIds = DB::table('user_role')->select('role_id')->where('user_id', '=', $userId)->get()->toArray();
                    $userRoleIds = array_column($userRoleIds, 'role_id');
                    $delUserRoleIds = array_diff($userRoleIds, $roleIds);
                    foreach ($delUserRoleIds as $rId) {
                        $role = DB::table('role')->where('id', $rId)->where('status', 1)->first();
                        if ($role) {
                            DB::table('user_role')->where('role_id', $rId)->where('user_id', $userId)->delete();
                        }
                    }
                    $addUserRoleIds = array_diff($roleIds, $userRoleIds);
                    foreach ($addUserRoleIds as $rId) {
                        $role = DB::table('role')->where('id', $rId)->where('status', 1)->first();
                        if ($role) {
                            DB::table('user_role')->insert(['user_id' => $userId, 'role_id' => $rId, 'created_at' => time(), 'updated_at' => time()]);
                        }
                    }
                }else{
                    DB::table('user_role')->where('user_id', $userId)->delete();
                }

                $res = DB::table('user')->where('id', $userId)->update(['name' => $name, 'email' => $email, 'updated_at' => time()]);
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

    function urlMatch($reqUrl,$userUrl){
        $reqPathArray = explode('/',$reqUrl);
        $userUrlArray = explode('/',$userUrl);
        if ( count($reqPathArray)!= count($userUrlArray) ){
            return false;
        }
        for ( $i=0 ; $i < count($reqPathArray) ; $i++){
            if ($reqPathArray[$i]==$userUrlArray[$i]){
                continue;
            }
            if ($reqPathArray[$i].startsWith('{') && $reqPathArray[$i].endsWith("}")){
                continue;
            }
            return false;
        }
        return true;

    }
}