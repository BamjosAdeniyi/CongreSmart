<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Permissions Management</h1>
                <p class="text-sm md:text-base text-gray-500">Manage role-based permissions and access control</p>
            </div>
        </div>

        {{-- Permissions Table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Role Permissions</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sabbath School</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Finance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reports</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Settings</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\RolePermission::all() as $permission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 capitalize">{{ $permission->role }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500">
                                        View: {{ $permission->members_view ? '✓' : '✗' }}<br>
                                        Add: {{ $permission->members_add ? '✓' : '✗' }}<br>
                                        Edit: {{ $permission->members_edit ? '✓' : '✗' }}<br>
                                        Delete: {{ $permission->members_delete ? '✓' : '✗' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500">
                                        View: {{ $permission->sabbath_school_view ? '✓' : '✗' }}<br>
                                        Manage: {{ $permission->sabbath_school_manage ? '✓' : '✗' }}<br>
                                        Attendance: {{ $permission->sabbath_school_mark_attendance ? '✓' : '✗' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500">
                                        View: {{ $permission->finance_view ? '✓' : '✗' }}<br>
                                        Record: {{ $permission->finance_record ? '✓' : '✗' }}<br>
                                        Reports: {{ $permission->finance_reports ? '✓' : '✗' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500">
                                        View: {{ $permission->reports_view ? '✓' : '✗' }}<br>
                                        Export: {{ $permission->reports_export ? '✓' : '✗' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500">
                                        View: {{ $permission->settings_view ? '✓' : '✗' }}<br>
                                        Edit: {{ $permission->settings_edit ? '✓' : '✗' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-500">
                                        View: {{ $permission->users_view ? '✓' : '✗' }}<br>
                                        Manage: {{ $permission->users_manage ? '✓' : '✗' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="editPermissions('{{ $permission->role }}')"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Edit Permissions Modal --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Edit Permissions - <span id="roleName"></span></h2>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form id="editForm" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Members Permissions --}}
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Members Management</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="members_view" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">View Members</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="members_add" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Add Members</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="members_edit" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Edit Members</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="members_delete" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Delete Members</span>
                                </label>
                            </div>
                        </div>

                        {{-- Sabbath School Permissions --}}
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Sabbath School</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="sabbath_school_view" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">View Classes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sabbath_school_manage" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Manage Classes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sabbath_school_mark_attendance" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Mark Attendance</span>
                                </label>
                            </div>
                        </div>

                        {{-- Finance Permissions --}}
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Finance</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="finance_view" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">View Finances</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="finance_record" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Record Transactions</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="finance_reports" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Finance Reports</span>
                                </label>
                            </div>
                        </div>

                        {{-- Reports Permissions --}}
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Reports</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="reports_view" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">View Reports</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="reports_export" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Export Reports</span>
                                </label>
                            </div>
                        </div>

                        {{-- Settings Permissions --}}
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Settings</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="settings_view" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">View Settings</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="settings_edit" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Edit Settings</span>
                                </label>
                            </div>
                        </div>

                        {{-- Users Permissions --}}
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">User Management</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="users_view" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">View Users</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="users_manage" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Manage Users</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Update Permissions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editPermissions(role) {
            document.getElementById('roleName').textContent = role.charAt(0).toUpperCase() + role.slice(1);
            document.getElementById('editForm').action = `/admin/permissions/${role}`;

            // Load current permissions (this would need AJAX in a real implementation)
            // For now, just open the modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.id === 'editModal') {
                closeEditModal();
            }
        });
    </script>
</x-app-layout>