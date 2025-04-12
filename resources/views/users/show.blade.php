<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chi tiết User</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div class="p-40 bg-amber-50 min-h-screen">
        <h1 class="text-2xl font-bold">Chi tiết User: {{ $user->name }}</h1>
        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
        </div>

        <div class="mt-4 flex space-x-2">
            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Chỉnh sửa</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Xóa</button>
            </form>
        </div>

        <div class="mt-4 bg-white p-6 rounded-md">
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Thông tin User</h2>
                <p class="py-1"><span class="font-medium">ID:</span> {{ $user->id }}</p>
                <p class="py-1"><span class="font-medium">Tên:</span> {{ $user->name }}</p>
                <p class="py-1"><span class="font-medium">Email:</span> {{ $user->email }}</p>
                <p class="py-1"><span class="font-medium">Ngày tạo:</span> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p class="py-1"><span class="font-medium">Cập nhật lần cuối:</span> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-2">Danh sách group ({{ $user->groups->count() }})</h2>
                <div class="border rounded-md">
                    @forelse ($user->groups as $group)
                        <div class="border-b last:border-b-0 p-3">
                            <div class="flex justify-between items-center">
                                <p class="font-medium">{{ $group->name }}</p>
                                <a href="{{ route('groups.show', $group) }}" class="text-blue-500 hover:underline">Xem chi tiết</a>
                            </div>
                        </div>
                    @empty
                        <p class="p-3 text-gray-500">user này chưa tham gia group nào</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>

</html>
