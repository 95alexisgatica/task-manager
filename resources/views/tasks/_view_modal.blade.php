<div id="view-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl max-h-screen overflow-y-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h3 id="view-modal-title" class="text-xl font-bold text-gray-900"></h3>
            <div class="flex gap-2 items-center">
                <button id="btn-edit-mode" onclick="enableEditMode()"
                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                    Edit
                </button>
                <button id="btn-save-mode"
                    class="hidden bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-1 px-3 rounded">
                    Save
                </button>
                <button onclick="closeViewModal()"
                    class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
            </div>
        </div>

        {{-- Status y metadata --}}
        <div class="flex gap-3 mb-4 flex-wrap">
            <span id="view-modal-status" class="px-2 py-1 text-xs rounded-full"></span>
            <span id="view-modal-category" class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600"></span>
            <span id="view-modal-due" class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600"></span>
        </div>

        {{-- Modo vista --}}
        <div id="view-mode-content">
            <div id="view-modal-description" class="text-gray-700 mb-6"></div>
            <div id="view-modal-images" class="grid grid-cols-3 gap-2"></div>
        </div>

        {{-- Modo edición (oculto por defecto) --}}
        <div id="edit-mode-content" class="hidden">
            <form id="view-task-form" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="view-task-id">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" id="view-input-title" name="title"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea id="view-input-description" name="description" rows="3"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select id="view-input-status" name="status"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select id="view-input-category" name="category_id"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">No category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                    <input type="date" id="view-input-due-date" name="due_date"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                {{-- Imágenes existentes --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Images</label>
                    <div id="view-existing-images" class="flex gap-2 flex-wrap mb-2"></div>
                    <input type="file" id="view-input-images" multiple accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700">
                    <p class="text-xs text-gray-400 mt-1">Max 10 images (2MB each)</p>
                    <div id="view-image-preview" class="flex gap-2 mt-2 flex-wrap"></div>
                </div>
            </form>
        </div>

    </div>
</div>
