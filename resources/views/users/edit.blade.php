<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chỉnh sửa User</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div class="p-40 bg-amber-50 min-h-screen">
        <h1 class="text-2xl font-bold">Chỉnh sửa User: {{ $user->name }}</h1>
        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
        </div>

        <div class="mt-4 bg-white p-6 rounded-md">
            <form action="{{ route('users.update', $user) }}" method="post">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block mb-2 font-medium">Tên</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block mb-2 font-medium">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block mb-2 font-medium">Mật khẩu mới (để trống nếu không thay đổi)</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2 font-medium">Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Chọn group</label>
                    <div class="max-h-60 overflow-y-auto border border-gray-300 rounded-md p-2">
                        @forelse ($groups as $group)
                            <div class="p-2 hover:bg-gray-100">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="group_ids[]" value="{{ $group->id }}"
                                        {{ in_array($group->id, old('group_ids', $user->groups->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="rounded">
                                    <span>{{ $group->name }}</span>
                                </label>
                            </div>
                        @empty
                            <p class="p-2 text-gray-500">Không có group nào</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Cập nhật User</button>
            </form>
        </div>
    </div>
</body>

</html>