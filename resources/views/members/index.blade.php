<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Member Management</h1>
                <p class="text-sm md:text-base text-gray-500">Manage church member records</p>
            </div>
            @php
                try {
                    $addMemberUrl = route('members.create');
                } catch (\Exception $e) {
                    $addMemberUrl = url('/members/create');
                }
            @endphp
            <a href="{{ $addMemberUrl }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Add Member
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Member List</h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('members.index') }}" id="filter-form">
                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                        <div class="flex-1 relative">
                            <svg class="absolute left-3 top-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by name or email..."
                                class="w-full pl-10 pr-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                id="search-input"
                            />
                        </div>
                        <select name="status" class="w-full sm:w-48 h-9 px-3 py-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm" id="status-filter">
                            <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="transferred" {{ request('status') === 'transferred' ? 'selected' : '' }}>Transferred</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                </form>

                <div class="border rounded-lg overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">Age</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px] hidden sm:table-cell">Contact</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px] hidden xl:table-cell">Membership Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px] hidden md:table-cell">Role</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px] hidden lg:table-cell">Baptismal Status</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($members ?? [] as $member)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $member->full_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $member->family_name ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $member->age ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                                        <div>
                                            <p class="text-sm text-gray-900">{{ $member->phone ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-500 truncate max-w-[150px]">{{ $member->email ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden xl:table-cell">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if(($member->membership_type ?? 'community') === 'community') bg-indigo-100 text-indigo-800
                                            @else bg-teal-100 text-teal-800 @endif">
                                            {{ ucfirst($member->membership_type ?? 'community') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if(($member->membership_category ?? 'adult') === 'adult') bg-blue-100 text-blue-800
                                            @elseif(($member->membership_category ?? 'adult') === 'youth') bg-purple-100 text-purple-800
                                            @elseif(($member->membership_category ?? 'adult') === 'child') bg-pink-100 text-pink-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ $member->membership_category === 'university-student' ? 'student' : ucfirst($member->membership_category ?? 'adult') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                        {{ $member->role_in_church ?? 'Member' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if(($member->membership_status ?? 'active') === 'active') bg-green-100 text-green-800
                                            @elseif(($member->membership_status ?? 'active') === 'inactive') bg-gray-100 text-gray-800
                                            @elseif(($member->membership_status ?? 'active') === 'transferred') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($member->membership_status ?? 'active') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if(($member->baptism_status ?? 'not-baptized') === 'baptized') bg-green-100 text-green-800
                                            @elseif(($member->baptism_status ?? 'not-baptized') === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-orange-100 text-orange-800 @endif">
                                            @if(($member->baptism_status ?? 'not-baptized') === 'baptized') Baptized
                                            @elseif(($member->baptism_status ?? 'not-baptized') === 'not-baptized') Not Baptized
                                            @else Pending @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-1 md:gap-2">
                                            @php
                                                try {
                                                    $viewUrl = route('members.show', $member->member_id);
                                                } catch (\Exception $e) {
                                                    $viewUrl = url('/members/' . $member->member_id);
                                                }
                                            @endphp
                                            <a href="{{ $viewUrl }}" class="text-blue-600 hover:text-blue-900 p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if(auth()->user()->role === 'clerk' || auth()->user()->role === 'ict')
                                                @php
                                                    try {
                                                        $editUrl = route('members.edit', $member->member_id);
                                                    } catch (\Exception $e) {
                                                        $editUrl = url('/members/' . $member->member_id . '/edit');
                                                    }
                                                @endphp
                                                <a href="{{ $editUrl }}" class="text-gray-600 hover:text-gray-900 p-1 hidden sm:inline">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                        No members found. <a href="{{ $addMemberUrl }}" class="text-blue-600 hover:text-blue-900">Add your first member</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <p class="text-sm text-gray-500">
                        Showing {{ $members ? $members->count() : 0 }} members
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const filterForm = document.getElementById('filter-form');

    // Submit form when search input changes (with debounce)
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterForm.submit();
        }, 500);
    });

    // Submit form when status filter changes
    statusFilter.addEventListener('change', function() {
        filterForm.submit();
    });
});
</script>