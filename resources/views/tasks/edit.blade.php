<x-layout>
    <h1 class="text-2xl font-bold mb-4">タスクを編集</h1>
    <form class="flex flex-col gap-2 items-start" method="POST" action="/tasks/{{ $task->id }}">
        @csrf
        @method('PUT')
        <input class="border border-gray-300 rounded px-3 py-1" type="text" name="title" value="{{ $task->title }}">
        @error('title')
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600" type="submit">更新</button>
    </form>
</x-layout>