<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:users.view', only: ['index', 'show']),
            new Middleware('permission:users.create', only: ['create', 'store']),
            new Middleware('permission:users.edit', only: ['edit', 'update']),
            new Middleware('permission:users.delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $users = $this->service->paginate($request->all());
        $roles = Role::all();

        if ($request->ajax()) {
            $html = view('admin.User.partials.table', compact('users'))->render();

            return response()->json(['html' => $html]);
        }

        return view('admin.User.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.User.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'nullable|integer|exists:roles,id',
            'phone' => 'nullable|string|max:40',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $this->service->create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.User.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.User.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'nullable|integer|exists:roles,id',
            'phone' => 'nullable|string|max:40',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $this->service->update($user, $data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->service->delete($user);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
