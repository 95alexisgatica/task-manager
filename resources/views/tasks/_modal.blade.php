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

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <select id="input-category" name="category_id"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">No category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                <input type="date" id="input-due-date" name="due_date" value="{{ old('due_date') }}"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Images</label>

                {{-- Imágenes existentes --}}
                <div id="existing-images" class="flex gap-2 flex-wrap mb-2"></div>

                <input type="file" id="input-images" name="images[]" multiple accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-400 mt-1">Max 10 images (2MB each)</p>
                <div id="image-preview" class="flex gap-2 mt-2 flex-wrap"></div>
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
            document.getElementById('task-form').dataset.taskId = '';
            document.getElementById('task-form').dataset.mode = 'create';
            document.getElementById('method-field').innerHTML = '';
            document.getElementById('input-title').value = '';
            document.getElementById('input-description').value = '';
            document.getElementById('input-status').value = 'pending';
            document.getElementById('input-due-date').value = '';
            const cat = document.getElementById('input-category');
            if (cat) cat.value = '';
            document.getElementById('image-preview').innerHTML = '';
            document.getElementById('modal').classList.remove('hidden');
        }

        window.openEditModal = function(id, title, description, status, dueDate, categoryId, images) {
            document.getElementById('modal-title').innerText = 'Edit Task';
            document.getElementById('task-form').dataset.taskId = id;
            document.getElementById('task-form').dataset.mode = 'edit';
            document.getElementById('method-field').innerHTML = '';
            document.getElementById('input-title').value = title;
            document.getElementById('input-description').value = description;
            document.getElementById('input-status').value = status;
            document.getElementById('input-due-date').value = dueDate;
            const cat = document.getElementById('input-category');
            if (cat) cat.value = categoryId;
            document.getElementById('image-preview').innerHTML = '';

            // Mostrar imágenes existentes
            const existingContainer = document.getElementById('existing-images');
            existingContainer.innerHTML = '';
            if (images && images.length > 0) {
                images.forEach(img => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative';

                    const image = document.createElement('img');
                    image.src = '/storage/' + img.path;
                    image.className = 'w-16 h-16 object-cover rounded cursor-pointer' + (img
                        .is_cover ? ' ring-2 ring-blue-500' : '');

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

            document.getElementById('modal').classList.remove('hidden');
        }

        // Límite de 10 imágenes
        document.getElementById('input-images').addEventListener('change', function() {
            const preview = document.getElementById('image-preview');
            const existingCount = document.getElementById('existing-images').children.length;
            const maxNew = 10 - existingCount;

            if (this.files.length > maxNew) {
                alert(`You can only upload ${maxNew} more image(s). Max total is 10.`);
                this.value = '';
                preview.innerHTML = '';
                return;
            }

            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-16 h-16 object-cover rounded';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });

        window.closeModal = function() {
            document.getElementById('modal').classList.add('hidden');
        }

        document.getElementById('input-images').addEventListener('change', function() {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-16 h-16 object-cover rounded';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });

        document.getElementById('task-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = this;
            const mode = form.dataset.mode;
            const taskId = form.dataset.taskId;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            const taskData = new FormData();
            taskData.append('_token', token);
            taskData.append('title', document.getElementById('input-title').value);
            taskData.append('description', document.getElementById('input-description').value);
            taskData.append('status', document.getElementById('input-status').value);
            taskData.append('due_date', document.getElementById('input-due-date').value);
            const cat = document.getElementById('input-category');
            if (cat) taskData.append('category_id', cat.value);
            if (mode === 'edit') taskData.append('_method', 'PUT');

            const url = mode === 'edit' ? `/tasks/${taskId}` : '/tasks';

            const taskRes = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: taskData,
            });

            const taskJson = await taskRes.json();

            if (!taskJson.success) {
                alert('Error saving task');
                return;
            }

            const imageInput = document.getElementById('input-images');
            if (imageInput.files.length > 0) {
                const imageData = new FormData();
                imageData.append('_token', token);
                Array.from(imageInput.files).forEach(file => {
                    imageData.append('images[]', file);
                });

                await fetch(`/tasks/${taskJson.task_id}/images`, {
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
