<x-layout>
    <h1 class="text-2xl font-bold mb-4">タスクを追加</h1>
    <form class="flex flex-col gap-2 items-start" method="POST" action="/tasks">
        @csrf
        <input class="border border-gray-300 rounded px-3 py-1" type="text" name="title">
        @error('title')
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" type="submit">追加</button>
    </form>
</x-layout>