<x-layout>
    <h1 class="text-2xl font-bold mb-4">タスク一覧</h1>
    <a class="inline-block mb-4 bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" href="/tasks/create">タスクを追加</a>
    <ul class="flex flex-col gap-2">
        @foreach ($tasks as $task)
        <li class="flex items-center gap-2">
            @if ($task->is_completed)
            ✅
            @endif
            <span @class(['line-through text-gray-400'=> $task->is_completed])>{{ $task->title }}</span> <a class="text-blue-500 underline hover:text-blue-800" href="/tasks/{{ $task->id }}/edit">編集</a>
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
</x-layout>