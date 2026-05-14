<?php

namespace App\Http\Controllers;

use App\Services\UserRoleService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private UserRoleService $userRoleService){}

    public function index(Request $request)
    {
        return view('pages.dashboard', ['title' => 'Dashboard']);
    }

    public function auth()
    {
        $userList = $this->userRoleService->userList();
        return view('pages.auth', ['users' => $userList->success ? $userList->data : []]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'role' => 'required',
            'role_name' => 'required'
        ]);

        session([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'role_name' => $request->input('role_name')
        ]);

        return response()->json(['success' => true, 'redirect' => route('home')]);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('auth');
    }
}
