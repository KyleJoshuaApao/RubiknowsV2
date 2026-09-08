<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-gray-100  transition-colors text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    {{ __('Create New Admin User') }}
                </h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Add a new administrator to manage website content and messages.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mt-6">
        <div class="bg-white  shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Photo -->
                <div class="mb-6">
                    <label for="profile_photo" class="block text-sm font-semibold text-gray-700 mb-2">Profile Photo (Optional)</label>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file: file:border-0 file:text-sm file:font-semibold file:bg-brand-500/10 file:text-brand-500 hover:file:bg-brand-500/20 cursor-pointer">
                    @error('profile_photo')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Username / Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-bold uppercase tracking-widest text-xs transition-colors">Cancel</a>
                    <button type="submit" class="bg-brand-500 text-white px-6 py-3 shadow-sm hover:bg-brand-600 font-bold uppercase tracking-widest text-xs transition-colors">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

