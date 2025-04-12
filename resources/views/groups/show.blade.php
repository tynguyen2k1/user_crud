<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chi tiết Group</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div class="p-40 bg-amber-50 min-h-screen">
        <h1 class="text-2xl font-bold">Chi tiết Group: {{ $group->name }}</h1>
        <div class="mt-4">
            <a href="{{ route('groups.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
        </div>
        <div class="mt-4 flex space-x-2">
            <a href="{{ route('groups.edit', $group) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Chỉnh sửa</a>
            <form action="{{ route('groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Xóa</button>
            </form>
        </div>

        <div class="mt-4 bg-white p-6 rounded-md">
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-2">Thông tin Group</h2>
                <p><span class="font-medium">ID:</span> {{ $group->id }}</p>
                <p><span class="font-medium">Tên:</span> {{ $group->name }}</p>
                <p><span class="font-medium">Ngày tạo:</span> {{ $group->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-2">Danh sách thành viên ({{ $group->users->count() }})</h2>
                <div class="border rounded-md">
                    @forelse ($group->users as $user)
                        <div class="border-b last:border-b-0 p-3">
                            <p class="font-medium">{{ $user->name }}</p>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    @empty
                        <p class="p-3 text-gray-500">Group này chưa có thành viên nào</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>

</html>