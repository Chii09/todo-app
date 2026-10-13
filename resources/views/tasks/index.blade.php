<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>タスク一覧</title>
    @vite(['resources/css/app.css'])
</head>

<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">タスク一覧</h1>
    <ul class="flex flex-col gap-2">
        @foreach ($tasks as $task)
        <li class="flex items-center gap-2">
            @if ($task->is_completed)
            ✅
            @endif
            {{ $task->title }} <a href="/tasks/{{ $task->id }}/edit">編集</a>
            <form method="POST" action="/tasks/{{ $task->id }}/toggle">
                @csrf
                @method('PATCH')
                <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600" type="submit">切り替え</button>
            </form>
            <form onsubmit="return confirm('本当に削除しますか？')" method="POST" action="/tasks/{{ $task->id }}">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" type="submit">削除</button>
            </form>
        </li>
        @endforeach
    </ul>
</body>

</html>