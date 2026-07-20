<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
                    {{ __('Create New Admin User') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Add a new administrator to manage website content and messages.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mt-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Photo -->
                <div class="mb-6">
                    <label for="profile_photo" class="block text-sm font-semibold text-gray-700 mb-2">Profile Photo (Optional)</label>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#E07B2A]/10 file:text-[#E07B2A] hover:file:bg-[#E07B2A]/20 cursor-pointer">
                    @error('profile_photo')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Username / Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#E07B2A] focus:ring-1 focus:ring-[#E07B2A] transition-all text-sm @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#E07B2A] focus:ring-1 focus:ring-[#E07B2A] transition-all text-sm @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#E07B2A] focus:ring-1 focus:ring-[#E07B2A] transition-all text-sm @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#E07B2A] focus:ring-1 focus:ring-[#E07B2A] transition-all text-sm">
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium text-sm transition-all">Cancel</a>
                    <button type="submit" class="bg-[#E07B2A] text-white px-4 py-2 rounded-lg shadow-sm hover:bg-orange-600 font-medium text-sm transition-all duration-200">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
