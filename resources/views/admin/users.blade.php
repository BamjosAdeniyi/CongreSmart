<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900 dark:text-gray-100">User Management</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">Manage system users and their roles</p>
            </div>
            <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add User
            </button>
        </div>

        {{-- Users Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">System Users</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse(\App\Models\User::orderBy('first_name')->get() as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                        @if($user->role === 'pastor') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @elseif($user->role === 'clerk') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($user->role === 'superintendent') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($user->role === 'coordinator') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($user->role === 'financial') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($user->role === 'ict') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($user->active) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                        {{ $user->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button data-user-id="{{ $user->id }}"
                                            data-user-first-name="{{ addslashes($user->first_name) }}"
                                            data-user-last-name="{{ addslashes($user->last_name) }}"
                                            data-user-email="{{ $user->email }}"
                                            data-user-role="{{ $user->role }}"
                                            data-user-active="{{ $user->active ? 'true' : 'false' }}"
                                            onclick="openEditModal(this.dataset.userId, this.dataset.userFirstName, this.dataset.userLastName, this.dataset.userEmail, this.dataset.userRole, this.dataset.userActive)"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button data-user-id="{{ $user->id }}"
                                                data-user-name="{{ addslashes($user->name) }}"
                                                onclick="confirmDelete(this.dataset.userId, this.dataset.userName)"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create User Modal --}}
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 @if($errors->any() && !request()->has('_method')) block @else hidden @endif">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl max-w-2xl w-full flex flex-col max-h-[90vh]">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Create User</h2>
                    <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto flex-1">
                    <form id="createForm" method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="create_first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name *</label>
                                <input type="text" id="create_first_name" name="first_name" value="{{ old('first_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="create_last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name *</label>
                                <input type="text" id="create_last_name" name="last_name" value="{{ old('last_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="create_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                                <input type="text" id="create_email" name="email" value="{{ old('email') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="create_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                                <input type="password" id="create_password" name="password"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="create_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password *</label>
                                <input type="password" id="create_password_confirmation" name="password_confirmation"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>

                            <div>
                                <label for="create_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role *</label>
                                <select id="create_role" name="role"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="">Select Role</option>
                                    <option value="pastor" {{ old('role') == 'pastor' ? 'selected' : '' }}>Pastor</option>
                                    <option value="clerk" {{ old('role') == 'clerk' ? 'selected' : '' }}>Clerk</option>
                                    <option value="superintendent" {{ old('role') == 'superintendent' ? 'selected' : '' }}>Superintendent</option>
                                    <option value="coordinator" {{ old('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                                    <option value="financial" {{ old('role') == 'financial' ? 'selected' : '' }}>Financial Secretary</option>
                                    <option value="ict" {{ old('role') == 'ict' ? 'selected' : '' }}>ICT Administrator</option>
                                    <option value="welfare" {{ old('role') == 'welfare' ? 'selected' : '' }}>Welfare Lead</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center mt-8">
                                <input type="checkbox" id="create_active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                                <label for="create_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                    Active User
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-xl">
                    <div class="flex gap-3 justify-end">
                        <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" form="createForm" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Create User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit User Modal --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 @if($errors->any() && request()->has('_method') && request()->input('_method') == 'PUT') block @else hidden @endif">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl max-w-2xl w-full flex flex-col max-h-[90vh]">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Edit User</h2>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto flex-1">
                    <form id="editForm" method="POST" class="space-y-6" action="{{ old('_method') == 'PUT' ? url()->current() : '' }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="edit_first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name *</label>
                                <input type="text" id="edit_first_name" name="first_name" value="{{ old('first_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="edit_last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name *</label>
                                <input type="text" id="edit_last_name" name="last_name" value="{{ old('last_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="edit_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                                <input type="text" id="edit_email" name="email" value="{{ old('email') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="edit_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role *</label>
                                <select id="edit_role" name="role"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="">Select Role</option>
                                    <option value="pastor" {{ old('role') == 'pastor' ? 'selected' : '' }}>Pastor</option>
                                    <option value="clerk" {{ old('role') == 'clerk' ? 'selected' : '' }}>Clerk</option>
                                    <option value="superintendent" {{ old('role') == 'superintendent' ? 'selected' : '' }}>Superintendent</option>
                                    <option value="coordinator" {{ old('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                                    <option value="financial" {{ old('role') == 'financial' ? 'selected' : '' }}>Financial Secretary</option>
                                    <option value="ict" {{ old('role') == 'ict' ? 'selected' : '' }}>ICT Administrator</option>
                                    <option value="welfare" {{ old('role') == 'welfare' ? 'selected' : '' }}>Welfare Lead</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center mt-8">
                                <input type="checkbox" id="edit_active" name="active" value="1" {{ old('active') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                                <label for="edit_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                    Active User
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-xl">
                    <div class="flex gap-3 justify-end">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" form="editForm" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Update User
                        </button>
                    </div>
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
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete User</h3>
                            <p id="deleteMessage" class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete this user?</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button id="confirmDeleteBtn" onclick="deleteUser()" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Delete
                        </button>
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

            // Clear form fields
            const form = document.getElementById('createForm');
            if (form) {
                form.reset();
                // Clear error messages
                form.querySelectorAll('.error-message').forEach(el => el.remove());

                // Manually clear inputs because reset() restores to 'value' attribute which might be old()
                const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="checkbox"]), select');
                inputs.forEach(input => input.value = '');

                // Reset checkbox to default (checked)
                const activeCheckbox = document.getElementById('create_active');
                if (activeCheckbox) activeCheckbox.checked = true;
            }
        }

        function openEditModal(id, firstName, lastName, email, role, active) {
            // Only populate if we don't have old input (to avoid overwriting validation corrections)
            @if(!$errors->any())
                document.getElementById('edit_first_name').value = firstName;
                document.getElementById('edit_last_name').value = lastName;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_role').value = role;
                document.getElementById('edit_active').checked = active === 'true';
                document.getElementById('editForm').action = `/admin/users/${id}`;
            @endif

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');

            // Clear error messages
            const form = document.getElementById('editForm');
            if (form) {
                form.querySelectorAll('.error-message').forEach(el => el.remove());
            }
        }

        function confirmDelete(id, name) {
            document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
            document.getElementById('confirmDeleteBtn').onclick = () => deleteUser(id);
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function deleteUser(id) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${id}`;

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfField);

            document.body.appendChild(form);
            form.submit();
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
