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
    @include('tasks._view_modal')

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
                        <li class="mr-2 flex items-center group">
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

            <div class="flex items-center gap-3 mb-4">
                <h1 class="text-2xl font-bold">
                    {{ $currentCategory ? $categories->where('id', $currentCategory)->first()->name : 'All Tasks' }}
                </h1>
                @if ($currentCategory)
                    @php $cat = $categories->where('id', $currentCategory)->first(); @endphp
                    <button onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                        class="text-gray-400 hover:text-blue-500">
                        <x-heroicon-o-pencil class="w-5 h-5" />
                    </button>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this category?')"
                            class="text-gray-400 hover:text-red-500">
                            <x-heroicon-o-trash class="w-5 h-5" />
                        </button>
                    </form>
                @endif
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Images</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900 cursor-pointer hover:text-blue-600"
                                            data-task-id="{{ $task->id }}"
                                            data-task-title="{{ addslashes($task->title) }}"
                                            data-task-description="{{ addslashes($task->description) }}"
                                            data-task-status="{{ $task->status }}"
                                            data-task-category="{{ $task->category ? addslashes($task->category->name) : '' }}"
                                            data-task-due="{{ $task->due_date ? $task->due_date->format('d/m/Y') : '' }}"
                                            data-task-category-id="{{ $task->category_id ?? '' }}"
                                            data-task-images='@json($task->images)'
                                            onclick="openViewModal(this)">
                                            {{ $task->title }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($task->description, 50) }}
                                        </div>
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
                                    <td class="px-6 py-4">
                                        @if ($task->images->count() > 0)
                                            <div class="flex gap-1 flex-wrap">
                                                @foreach ($task->images as $image)
                                                    <a href="{{ asset('storage/' . $image->path) }}" class="glightbox"
                                                        data-gallery="task-{{ $task->id }}">
                                                        <img src="{{ asset('storage/' . $image->path) }}"
                                                            class="w-12 h-12 object-cover rounded cursor-pointer hover:opacity-80 {{ $image->is_cover ? 'ring-2 ring-blue-500' : '' }}">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">No images</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            GLightbox({
                selector: '.glightbox'
            });

            let currentTask = null;

            window.openViewModal = function(el) {
                const id = el.dataset.taskId;
                const title = el.dataset.taskTitle;
                const description = el.dataset.taskDescription;
                const status = el.dataset.taskStatus;
                const category = el.dataset.taskCategory;
                const dueDate = el.dataset.taskDue;
                const categoryId = el.dataset.taskCategoryId;
                const images = JSON.parse(el.dataset.taskImages || '[]');

                currentTask = {
                    id,
                    title,
                    description,
                    status,
                    category,
                    dueDate,
                    categoryId,
                    images
                };

                // Reset a modo vista
                document.getElementById('view-mode-content').classList.remove('hidden');
                document.getElementById('edit-mode-content').classList.add('hidden');
                document.getElementById('btn-edit-mode').classList.remove('hidden');
                document.getElementById('btn-save-mode').classList.add('hidden');

                // Título
                document.getElementById('view-modal-title').innerText = title;

                // Status con color
                const colors = {
                    'pending': 'bg-yellow-100 text-yellow-800',
                    'in_progress': 'bg-blue-100 text-blue-800',
                    'completed': 'bg-green-100 text-green-800',
                };
                const statusEl = document.getElementById('view-modal-status');
                statusEl.className = 'px-2 py-1 text-xs rounded-full ' + (colors[status] || '');
                statusEl.innerText = status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());

                // Categoría
                const catEl = document.getElementById('view-modal-category');
                catEl.innerText = category || '';
                catEl.style.display = category ? 'inline' : 'none';

                // Fecha
                const dueEl = document.getElementById('view-modal-due');
                dueEl.innerText = dueDate ? '📅 ' + dueDate : '';
                dueEl.style.display = dueDate ? 'inline' : 'none';

                // Descripción
                document.getElementById('view-modal-description').innerHTML = description ||
                    '<em class="text-gray-400">No description</em>';

                // Imágenes
                const container = document.getElementById('view-modal-images');
                container.innerHTML = '';
                if (images && images.length > 0) {
                    images.forEach(img => {
                        const a = document.createElement('a');
                        a.href = '/storage/' + img.path;
                        a.className = 'glightbox-view';
                        a.dataset.gallery = 'view-gallery';
                        const image = document.createElement('img');
                        image.src = '/storage/' + img.path;
                        image.className =
                            'w-full h-32 object-cover rounded cursor-pointer hover:opacity-90' + (img
                                .is_cover ? ' ring-2 ring-blue-500' : '');
                        a.appendChild(image);
                        container.appendChild(a);
                    });
                    GLightbox({
                        selector: '.glightbox-view'
                    });
                }

                document.getElementById('view-modal').classList.remove('hidden');
            }

            window.enableEditMode = function() {
                if (typeof currentTask.images === 'string') currentTask.images = JSON.parse(currentTask.images);
                const t = currentTask;

                document.getElementById('view-mode-content').classList.add('hidden');
                document.getElementById('edit-mode-content').classList.remove('hidden');
                document.getElementById('btn-edit-mode').classList.add('hidden');
                document.getElementById('btn-save-mode').classList.remove('hidden');

                document.getElementById('view-task-id').value = t.id;
                document.getElementById('view-task-form').action = `/tasks/${t.id}`;
                document.getElementById('view-input-title').value = t.title;
                document.getElementById('view-input-description').value = t.description;
                document.getElementById('view-input-status').value = t.status;
                document.getElementById('view-input-due-date').value = t.dueDate;
                const cat = document.getElementById('view-input-category');
                if (cat) cat.value = t.categoryId;

                const existingContainer = document.getElementById('view-existing-images');
                existingContainer.innerHTML = '';
                if (t.images && t.images.length > 0) {
                    t.images.forEach(img => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'relative';
                        const image = document.createElement('img');
                        image.src = '/storage/' + img.path;
                        image.className = 'w-16 h-16 object-cover rounded' + (img.is_cover ?
                            ' ring-2 ring-blue-500' : '');
                        const deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.innerHTML = '×';
                        deleteBtn.className =
                            'absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center';
                        deleteBtn.onclick = async function() {
                            const token = document.querySelector('meta[name="csrf-token"]')
                                .content;
                            await fetch(`/images/${img.id}`, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                body: (() => {
                                    const f = new FormData();
                                    f.append('_token', token);
                                    f.append('_method', 'DELETE');
                                    return f;
                                })()
                            });
                            wrapper.remove();
                        };
                        wrapper.appendChild(image);
                        wrapper.appendChild(deleteBtn);
                        existingContainer.appendChild(wrapper);
                    });
                }
            }

            window.closeViewModal = function() {
                document.getElementById('view-modal').classList.add('hidden');
            }

            document.getElementById('view-modal').addEventListener('click', function(e) {
                if (e.target === this) closeViewModal();
            });

            document.getElementById('btn-save-mode').addEventListener('click', async function() {
                const token = document.querySelector('meta[name="csrf-token"]').content;
                const taskId = document.getElementById('view-task-id').value;

                const taskData = new FormData();
                taskData.append('_token', token);
                taskData.append('_method', 'PUT');
                taskData.append('title', document.getElementById('view-input-title').value);
                taskData.append('description', document.getElementById('view-input-description').value);
                taskData.append('status', document.getElementById('view-input-status').value);
                taskData.append('due_date', document.getElementById('view-input-due-date').value);
                const cat = document.getElementById('view-input-category');
                if (cat) taskData.append('category_id', cat.value);

                const res = await fetch(`/tasks/${taskId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: taskData,
                });

                const json = await res.json();
                if (!json.success) {
                    alert('Error saving');
                    return;
                }

                const imageInput = document.getElementById('view-input-images');
                if (imageInput.files.length > 0) {
                    const imageData = new FormData();
                    imageData.append('_token', token);
                    Array.from(imageInput.files).forEach(file => imageData.append('images[]', file));
                    await fetch(`/tasks/${json.task_id}/images`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: imageData,
                    });
                }

                window.location.reload();
            });

        });
    </script>
</x-app-layout>
