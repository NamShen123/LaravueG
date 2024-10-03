<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function show($id)
    {
        $user = User::where('id', $id)->with(['department', 'status'])->firstOrFail();
        return response()->json([
            'id' => $user->id,
            'avatar' => $user->avatar,
            'username' => $user->username,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'department' => $user->department?->name,
            'status' => $user->status?->name,
        ]);
    }

    function index(Request $request)
    {
        $userData = [];
        $users = User::with(['department', 'status'])->get();
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->id,
                'avatar' => $user->avatar,
                'username' => $user->username,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'department' => $user->department?->name,
                'status' => $user->status?->name,
            ];
        }
        return response()->json($userData);
    }

    function getConstraint()
    {
        $departments = Departments::get();
        $userStatus = UserStatus::get();

        return response()->json([
            "user_status" => $userStatus,
            "departments" => $departments
        ]);
    }

    function store(Request $request)
    {

        $validated = Validator::make(
            $request->all(),
            [
                "status_id" => "required|exists:user_status,id",
                "username" => "required|unique:users,username",
                "name" => "required",
                "email" => "required|unique:users,email",
                "departments_id" => "required|exists:departments,id",
                "password" => "required",
                "password_confirmation" => "same:password",
            ],
            [
                "status_id.required" => "Chọn tình trạng",
                "username.required" => "Nhập tên đăng nhập",
                "name.required" => "Nhập họ và tên",
                "email.required" => "Nhập email",
                "email.unique" => "Email đã tồn tại",
                "departments_id.required" => "Chọn vai trò",
                "password.required" => "Nhập mật khẩu",

                "password_confirmation.same" => "Mật khẩu không trùng khớp",

                "username.unique" => "Tên đăng nhập đã tồn tại",

                "status_id.exists" => "Trạng thái không tồn tại",
                "departments_id.exists" => "Vai trò không tồn tại",
            ],
        );

        if ($validated->fails()) {
            return response()->json($validated->errors(), Response::HTTP_BAD_REQUEST);
        }


        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_id' => $request->status_id,
            'departments_id' => $request->departments_id,
        ]);

        return response()->json([
            "message" => "Tạo tài khoản thành công!"
        ], JSON_UNESCAPED_UNICODE);
    }

    function edit($id)
    {
        $user =  User::where('id', $id)->with(['status', 'department'])->firstOrfail();

        return response()->json($user);
    }

    function update(Request $request, $id)
    {
        $validated = Validator::make(
            $request->all(),
            [
                "status_id" => "required|exists:user_status,id",
                "name" => "required",
                "email" => 'required|unique:users,email,' . $id,
                "departments_id" => "required|exists:departments,id",
            ],
            [
                "status_id.required" => "Chọn tình trạng",
                "name.required" => "Nhập họ và tên",
                "email.required" => "Nhập email",
                "departments_id.required" => "Chọn vai trò",

                "email.unique" => "Email đã tồn tại",

                "status_id.exists" => "Trạng thái không tồn tại",
                "departments_id.exists" => "Vai trò không tồn tại",
            ],
        );

        if ($validated->fails()) {
            return response()->json($validated->errors(), Response::HTTP_BAD_REQUEST);
        }

        $currentUser = User::findOrFail($id);

        $currentUser->name = $request["name"];
        $currentUser->status_id = $request["status_id"];
        $currentUser->email = $request["email"];
        $currentUser->departments_id = $request["departments_id"];

        if ($request->isChangePassword) {
            $validator = Validator::make(
                $request->all(),
                [
                    "password" => "required",
                    "password_confirmation" => "same:password",
                ],
                [
                    "password.required" => "Nhập mật khẩu",
                    "password_confirmation.same" => "Mật khẩu không trùng khớp",
                ]
            );

            if ($validator->fails()) {
                return response()->json($validated->errors(), Response::HTTP_BAD_REQUEST);
            }

            $currentUser->password = Hash::make($request['password']);
        }

        $currentUser->save();

        return response()->json([
            'message' => 'Cập nhật tài thành công'
        ]);
    }

    function destroy($id)
    {
        User::find($id)->delete();

        return response()->json([
            "message" => "Xóa thành công",
        ]);
    }

    function userRegister(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                "username" => "required|unique:users,username",
                "name" => "required",
                "email" => "required|unique:users,email",
                "password" => "required",
                "password_confirmation" => "same:password",
            ],
            [
                "username.required" => "Nhập tên đăng nhập",
                "name.required" => "Nhập họ và tên",
                "email.required" => "Nhập email",
                "password.required" => "Nhập mật khẩu",
                
                "password_confirmation.same" => "Mật khẩu không trùng khớp",
                
                "username.unique" => "Tên đăng nhập đã tồn tại",
                "email.unique" => "Email đã tồn tại",

            ],
        );

        if ($validated->fails()) {
            return response()->json($validated->errors(), Response::HTTP_BAD_REQUEST);
        }

        $userRole = Departments::where('name', Departments::USER)->first();
        $activeStatus = UserStatus::where('name', UserStatus::ACTIVE)->first();

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_id' => $activeStatus->id,
            'departments_id' => $userRole->id,
        ]);

        return response()->json([
            "message" => "Tạo tài khoản thành công!"
        ], JSON_UNESCAPED_UNICODE);
    }
}
