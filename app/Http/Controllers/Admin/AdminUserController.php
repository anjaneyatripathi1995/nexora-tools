<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->orderBy('is_master', 'desc')->orderBy('name')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'access_tools' => 'boolean',
            'access_projects' => 'boolean',
            'access_apps' => 'boolean',
            'access_templates' => 'boolean',
        ]);
        $rules = [];
        if (!empty($data['access_tools'])) {
            $rules[] = 'tools';
        }
        if (!empty($data['access_projects'])) {
            $rules[] = 'projects';
        }
        if (!empty($data['access_apps'])) {
            $rules[] = 'apps';
        }
        if (!empty($data['access_templates'])) {
            $rules[] = 'templates';
        }
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
            'access_rules' => empty($rules) ? null : $rules,
            'is_master' => false,
        ]);
        return redirect()->route('admin.admins.index')->with('success', 'Sub-admin created successfully.');
    }
}
