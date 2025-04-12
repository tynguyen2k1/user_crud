<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tạo Group</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div class="p-40 bg-amber-50 min-h-screen">
        <h1 class="text-2xl font-bold">Tạo Group mới</h1>
        <div class="mt-4">
            <a href="{{ route('groups.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
        </div>
        <div class="mt-4 bg-white p-6 rounded-md">
            <form action="{{ route('groups.store') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-2 font-medium">Tên Group</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Chọn thành viên</label>
                    <div class="max-h-60 overflow-y-auto border border-gray-300 rounded-md p-2">
                        @forelse ($users as $user)
                            <div class="p-2 hover:bg-gray-100">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="rounded">
                                    <span>{{ $user->name }} ({{ $user->email }})</span>
                                </label>
                            </div>
                        @empty
                            <p class="p-2 text-gray-500">Không có user nào</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md cursor-pointer">Tạo Group</button>
            </form>
        </div>
    </div>
</body>

</html>
