<h1>タスク一覧</h1>
<ul>
    @foreach ($tasks as $task)
        <li>{{ $task->title }}</li>
    @endforeach
</ul>