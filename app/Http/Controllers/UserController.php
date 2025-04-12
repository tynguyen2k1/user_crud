<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách user
     */
    public function index()
    {
        $users = User::with('groups')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Hiển thị form tạo user mới
     */
    public function create()
    {
        $groups = Group::all();
        return view('users.create', compact('groups'));
    }

    /**
     * Lưu user mới vào database
     */
    public function store(UserRequest $request)
    {
        // Get validated data
        $validated = $request->validated();

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Create user
        $user = User::create($validated);

        // Thêm user vào các group được chọn
        if ($request->has('group_ids')) {
            $user->groups()->attach($request->group_ids);
        }

        return redirect()->route('users.index')
            ->with('success', 'Tạo user thành công');
    }

    /**
     * Hiển thị thông tin chi tiết user
     */
    public function show(User $user)
    {
        // Eager load groups
        $user->load('groups');
        return view('users.show', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa user
     */
    public function edit(User $user)
    {
        $groups = Group::all();
        return view('users.edit', compact('user', 'groups'));
    }

    /**
     * Cập nhật thông tin user
     */
    public function update(UserRequest $request, User $user)
    {
        // Get validated data
        $validated = $request->validated();

        // Only hash password if it was provided
        if (isset($validated['password']) && $validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Update user
        $user->update($validated);

        // Cập nhật quan hệ groups
        if ($request->has('group_ids')) {
            $user->groups()->sync($request->group_ids);
        } else {
            $user->groups()->detach();
        }

        return redirect()->route('users.index')
            ->with('success', 'Cập nhật user thành công');
    }

    /**
     * Xóa user
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Xóa user thành công');
    }
}
