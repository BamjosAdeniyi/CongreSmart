<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('finance.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">Financial Categories</h1>
                    <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Manage contribution types and categories</p>
                </div>
            </div>
            <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Category
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold dark:text-gray-200">Categories</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($categories as $category)
                        <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-medium dark:text-gray-200">{{ $category->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($category->category_type === 'income') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                        @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                        {{ ucfirst($category->category_type) }}
                                    </span>
                                    @if(!$category->active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                                @if($category->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $category->description }}</p>
                                @endif
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    {{ $category->contributions_count ?? 0 }} contributions
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button data-category-id="{{ $category->id }}"
                                        data-category-name="{{ $category->name }}"
                                        data-category-description="{{ $category->description }}"
                                        data-category-type="{{ $category->category_type }}"
                                        data-category-active="{{ $category->active ? 'true' : 'false' }}"
                                        onclick="openEditModal(this.dataset.categoryId, this.dataset.categoryName, this.dataset.categoryDescription, this.dataset.categoryType, this.dataset.categoryActive)"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                @if($category->contributions_count == 0)
                                    <button onclick="confirmDelete('{{ $category->id }}', '{{ addslashes($category->name) }}')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 p-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p>No categories found.</p>
                            <p class="text-sm mt-1">Create your first financial category.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Create Category Modal --}}
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Create Category</h3>
                    <form method="POST" action="{{ route('finance.categories.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="create_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" id="create_name" name="name" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="create_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea id="create_description" name="description" rows="3"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div>
                                <label for="create_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                <select id="create_type" name="category_type" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="closeCreateModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Edit Category</h3>
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="edit_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" id="edit_name" name="name" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="edit_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea id="edit_description" name="description" rows="3"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div>
                                <label for="edit_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                <select id="edit_type" name="category_type" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="edit_active" name="active" value="1"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                                <label for="edit_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                    Active
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="closeEditModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete Category</h3>
                            <p id="deleteMessage" class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete this category?</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEditModal(id, name, description, type, active) {
            document.getElementById('editForm').action = `/finance/categories/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_type').value = type;
            document.getElementById('edit_active').checked = active === 'true';
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(id, name) {
            document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
            document.getElementById('deleteForm').action = `/finance/categories/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.id === 'createModal') {
                closeCreateModal();
            }
            if (event.target.id === 'editModal') {
                closeEditModal();
            }
            if (event.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
