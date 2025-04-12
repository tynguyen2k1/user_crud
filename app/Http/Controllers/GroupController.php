<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\User;

class GroupController extends Controller
{
    /**
     * Hiển thị danh sách group
     */
    public function index()
    {
        $groups = Group::withCount('users')->get();
        return view('groups.index', compact('groups'));
    }

    /**
     * Hiển thị form tạo group mới
     */
    public function create()
    {
        $users = User::all();
        return view('groups.create', compact('users'));
    }

    /**
     * Lưu group mới vào database
     */
    public function store(GroupRequest $request)
    {
        // Đã validate trong request
        $group = Group::create($request->validated());

        // Thêm các user vào group nếu có
        if ($request->has('user_ids')) {
            $group->users()->attach($request->user_ids);
        }

        return redirect()->route('groups.index')
            ->with('success', 'Tạo group thành công');
    }

    /**
     * Hiển thị thông tin chi tiết group
     */
    public function show(Group $group)
    {
        // Eager load users
        $group->load('users');
        return view('groups.show', compact('group'));
    }

    /**
     * Hiển thị form chỉnh sửa group
     */
    public function edit(Group $group)
    {
        $users = User::all();
        return view('groups.edit', compact('group', 'users'));
    }

    /**
     * Cập nhật thông tin group
     */
    public function update(GroupRequest $request, Group $group)
    {
        // Đã validate trong request
        $group->update($request->validated());

        // Cập nhật quan hệ users
        if ($request->has('user_ids')) {
            $group->users()->sync($request->user_ids);
        } else {
            $group->users()->detach();
        }

        return redirect()->route('groups.index')
            ->with('success', 'Cập nhật group thành công');
    }

    /**
     * Xóa group
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')
            ->with('success', 'Xóa group thành công');
    }
}
