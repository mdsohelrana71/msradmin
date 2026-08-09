<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\AccountService;

class AccountController extends Controller
{
    protected AccountService $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $user = $this->service->getUserInfo(Auth::id());

        return view('admin.Account.index', compact('user'));
    }

    public function edit(User $account)
    {
        if ($account->id !== Auth::id()) {
            abort(403);
        }

        $user = $this->service->getUserInfo($account->id);

        return view('admin.Account.edit', compact('user'));
    }

    public function update(Request $request, User $account)
    {
        if ($account->id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:40',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $this->service->updateUser($data);

        return redirect()->route('admin.accounts.index')->with('success', 'Profile updated successfully.');
    }
}
