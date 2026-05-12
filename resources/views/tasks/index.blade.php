<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Tasks
            </h2>
            <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + New Task
            </button>
        </div>
    </x-slot>

    @include('tasks._modal')
    @include('tasks._category_modal')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Pestañas de categorías --}}
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium">
                    <li class="mr-2">
                        <a href="{{ route('tasks.index') }}"
                            class="inline-block p-4 {{ !$currentCategory ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            All
                        </a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="mr-2">
                            <a href="{{ route('tasks.index', ['category' => $category->id]) }}"
                                class="inline-block p-4 {{ $currentCategory == $category->id ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                    <li class="mr-2">
                        <button onclick="openCategoryModal()"
                            class="inline-block p-4 text-gray-500 hover:text-gray-700">
                            + Add Category
                        </button>
                    </li>
                </ul>
            </div>

            @if ($tasks->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-500">
                    No tasks yet. Click "+ New Task" to create your first one!
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $task->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $task->description }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $colors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 text-xs rounded-full {{ $colors[$task->status] }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $task->due_date ? $task->due_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <button
                                            onclick="openEditModal(
                                            {{ $task->id }},
                                            '{{ addslashes($task->title) }}',
                                            '{{ addslashes($task->description) }}',
                                            '{{ $task->status }}',
                                            '{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}',
                                            '{{ $task->category_id ?? '' }}'
                                        )"
                                            class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this task?')"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
