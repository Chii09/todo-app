<h1>タスクを追加</h1>
<form method="POST" action="/tasks">
    @csrf
    <input type="text" name="title">
    <button type="submit">追加</button>
</form>