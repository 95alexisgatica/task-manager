<div id="category-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">New Category</h3>
            <button onclick="closeCategoryModal()"
                class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" class="shadow border rounded w-full py-2 px-3 text-gray-700"
                    placeholder="e.g. Work, Study, Personal">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Category
                </button>
                <button type="button" onclick="closeCategoryModal()"
                    class="text-gray-600 hover:text-gray-900">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.openCategoryModal = function() {
            document.getElementById('category-modal').classList.remove('hidden');
        }
        window.closeCategoryModal = function() {
            document.getElementById('category-modal').classList.add('hidden');
        }
    });
</script>
