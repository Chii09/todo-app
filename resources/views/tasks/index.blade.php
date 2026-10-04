<h1>タスク一覧</h1>
<ul>
    @foreach ($tasks as $task)
    <li>{{ $task->title }} <a href="/tasks/{{ $task->id }}/edit">編集</a></li>
    @endforeach
</ul>