<h1>タスク一覧</h1>
<ul>
    @foreach ($tasks as $task)
    <li>
        @if ($task->is_completed)
        ✅
        @endif
        {{ $task->title }} <a href="/tasks/{{ $task->id }}/edit">編集</a>
            <form method="POST" action="/tasks/{{ $task->id }}/toggle">
                @csrf
                @method('PATCH')
                <button type="submit">切り替え</button>
            </form>
            <form method="POST" action="/tasks/{{ $task->id }}">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button>
            </form>
    </li>
    @endforeach
</ul>