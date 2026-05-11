<div id="modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modal-title" class="text-lg font-bold text-gray-900">Create New Task</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
        </div>

        <form id="task-form" method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div id="method-field"></div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" id="input-title" name="title" value="{{ old('title') }}"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea id="input-description" name="description" rows="3"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select id="input-status" name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                <input type="date" id="input-due-date" name="due_date" value="{{ old('due_date') }}"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Task
                </button>
                <button type="button" onclick="closeModal()" class="text-gray-600 hover:text-gray-900">Cancel</button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
    <script>
        document.getElementById('modal').classList.remove('hidden');
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.openModal = function() {
            document.getElementById('modal-title').innerText = 'Create New Task';
            document.getElementById('task-form').action = '{{ route('tasks.store') }}';
            document.getElementById('method-field').innerHTML = '';
            document.getElementById('input-title').value = '';
            document.getElementById('input-description').value = '';
            document.getElementById('input-status').value = 'pending';
            document.getElementById('input-due-date').value = '';
            document.getElementById('modal').classList.remove('hidden');
        }

        window.openEditModal = function(id, title, description, status, dueDate) {
            document.getElementById('modal-title').innerText = 'Edit Task';
            document.getElementById('task-form').action = '/tasks/' + id;
            document.getElementById('method-field').innerHTML =
                '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('input-title').value = title;
            document.getElementById('input-description').value = description;
            document.getElementById('input-status').value = status;
            document.getElementById('input-due-date').value = dueDate;
            document.getElementById('modal').classList.remove('hidden');
        }

        window.closeModal = function() {
            document.getElementById('modal').classList.add('hidden');
        }
    });
</script>
