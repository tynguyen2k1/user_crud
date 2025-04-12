<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh sách Groups</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div class="p-40 bg-amber-50 min-h-screen">
        <h1 class="text-2xl font-bold">Danh sách Group</h1>
        @if(session('success'))
        <div id="success-alert" class="mt-4 bg-green-500 border border-green-400 text-white px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('success-alert').style.display = 'none';
            }, 3000);
        </script>
    @endif
        <div class="mt-10 flex justify-between">
            <a href="{{ route('groups.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Thêm Group</a>
            <a href="{{ route('users.index') }}" class="bg-green-500 text-white px-4 py-2 rounded-md">Quản lý Users</a>
        </div>
        <div class="mt-4 bg-white p-4 rounded-md">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Tên</th>
                        <th class="px-6 py-3 text-left">Số lượng thành viên</th>
                        <th class="px-6 py-3 text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($groups as $group)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $group->id }}</td>
                            <td class="px-6 py-4">{{ $group->name }}</td>
                            <td class="px-6 py-4">{{ $group->users_count }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('groups.show', $group) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded">Chi tiết</a>
                                <a href="{{ route('groups.edit', $group) }}" class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded">Sửa</a>
                                <form action="{{ route('groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>