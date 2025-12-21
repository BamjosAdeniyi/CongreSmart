<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
            @php
                try {
                    $backUrl = route('members.index');
                } catch (\Exception $e) {
                    $backUrl = url('/members');
                }
            @endphp
            <a href="{{ $backUrl }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 w-fit px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
            <div>
                <h1 class="text-xl md:text-2xl text-gray-900">Add New Member</h1>
                <p class="text-sm md:text-base text-gray-500">Register a new church member</p>
            </div>
        </div>

        <form method="POST" action="{{ route('members.store') }}" class="space-y-6">
            @csrf

            {{-- Personal Information --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Personal Information</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label for="first_name" class="text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                            <input
                                id="first_name"
                                name="first_name"
                                type="text"
                                value="{{ old('first_name') }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            />
                            @error('first_name')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="last_name" class="text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                            <input
                                id="last_name"
                                name="last_name"
                                type="text"
                                value="{{ old('last_name') }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            />
                            @error('last_name')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="family_name" class="text-sm font-medium">Family Name <span class="text-red-500">*</span></label>
                            <input
                                id="family_name"
                                name="family_name"
                                type="text"
                                value="{{ old('family_name') }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            />
                            @error('family_name')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="gender" class="text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                            <select
                                id="gender"
                                name="gender"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            >
                                <option value="">Select gender</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="date_of_birth" class="text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                            <input
                                id="date_of_birth"
                                name="date_of_birth"
                                type="date"
                                value="{{ old('date_of_birth') }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            />
                            @error('date_of_birth')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-medium">Phone Number <span class="text-red-500">*</span></label>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                value="{{ old('phone') }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            />
                            @error('phone')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium">Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                            />
                            @error('email')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="address" class="text-sm font-medium">Address <span class="text-red-500">*</span></label>
                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                            required
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Membership Details --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Membership Details</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="membership_type" class="text-sm font-medium">Membership Type <span class="text-red-500">*</span></label>
                            <select
                                id="membership_type"
                                name="membership_type"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            >
                                <option value="">Select type</option>
                                <option value="community" {{ old('membership_type') === 'community' ? 'selected' : '' }}>Community Member</option>
                                <option value="student" {{ old('membership_type') === 'student' ? 'selected' : '' }}>Student Member</option>
                            </select>
                            @error('membership_type')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="membership_category" class="text-sm font-medium">Membership Category <span class="text-red-500">*</span></label>
                            <select
                                id="membership_category"
                                name="membership_category"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            >
                                <option value="">Select category</option>
                                <option value="adult" {{ old('membership_category') === 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="youth" {{ old('membership_category') === 'youth' ? 'selected' : '' }}>Youth</option>
                                <option value="child" {{ old('membership_category') === 'child' ? 'selected' : '' }}>Child</option>
                                <option value="university-student" {{ old('membership_category') === 'university-student' ? 'selected' : '' }}>University Student</option>
                            </select>
                            @error('membership_category')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="role_in_church" class="text-sm font-medium">Role in Church</label>
                        <input
                            id="role_in_church"
                            name="role_in_church"
                            type="text"
                            value="{{ old('role_in_church') }}"
                            placeholder="e.g., Elder, Deacon, Member"
                            class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                        />
                        @error('role_in_church')
                            <p class="text-red-600 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="baptism_status" class="text-sm font-medium">Baptism Status <span class="text-red-500">*</span></label>
                            <select
                                id="baptism_status"
                                name="baptism_status"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                                required
                            >
                                <option value="">Select status</option>
                                <option value="baptized" {{ old('baptism_status') === 'baptized' ? 'selected' : '' }}>Baptized</option>
                                <option value="not-baptized" {{ old('baptism_status') === 'not-baptized' ? 'selected' : '' }}>Not Baptized</option>
                                <option value="pending" {{ old('baptism_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('baptism_status')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="date_of_baptism" class="text-sm font-medium">Date of Baptism</label>
                            <input
                                id="date_of_baptism"
                                name="date_of_baptism"
                                type="date"
                                value="{{ old('date_of_baptism') }}"
                                class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                            />
                            @error('date_of_baptism')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="membership_date" class="text-sm font-medium">Membership Date <span class="text-red-500">*</span></label>
                        <input
                            id="membership_date"
                            name="membership_date"
                            type="date"
                            value="{{ old('membership_date') }}"
                            class="w-full px-3 py-2 h-9 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm"
                            required
                        />
                        @error('membership_date')
                            <p class="text-red-600 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
                <a href="{{ $backUrl }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg font-medium transition-colors text-center w-full sm:w-auto">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors w-full sm:w-auto">
                    Add Member
                </button>
            </div>
        </form>
    </div>
</x-app-layout>