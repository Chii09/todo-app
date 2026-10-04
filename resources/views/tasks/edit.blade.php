<h1>タスクを編集</h1>
<form method="POST" action="/tasks/{{ $task->id }}">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $task->title }}">
    @error('title')
        <p>{{ $message }}</p>
    @enderror
    <button type="submit">更新</button>
</form>