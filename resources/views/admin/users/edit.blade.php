<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-gray-100  transition-colors text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight">
                    {{ __('Edit User / Change Password') }}
                </h2>
                <p class="text-sm font-bold uppercase tracking-widest text-gray-500 mt-2">Update details or change password for {{ $user->name }}.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mt-6">
        <div class="bg-white  shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Photo -->
                <div class="mb-6">
                    <label for="profile_photo" class="block text-sm font-semibold text-gray-700 mb-2">Profile Photo</label>
                    <div class="flex items-center space-x-5 mt-2">
                        <div class="h-16 w-16  overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center flex-shrink-0">
                            @if($user->profile_photo_url)
                                <img src="{{ Storage::url($user->profile_photo_url) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-xl text-brand-500 font-bold">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file: file:border-0 file:text-sm file:font-semibold file:bg-brand-500/10 file:text-brand-500 hover:file:bg-brand-500/20 cursor-pointer">
                    </div>
                    @error('profile_photo')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Username / Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Information Alert -->
                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-amber-800 font-medium">Leave password fields blank if you do not want to change the user's password.</p>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">New Password (Optional)</label>
                    <input type="password" name="password" id="password"
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors">
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-bold uppercase tracking-widest text-xs transition-colors">Cancel</a>
                    <button type="submit" class="bg-brand-500 text-white px-6 py-3 shadow-sm hover:bg-brand-600 font-bold uppercase tracking-widest text-xs transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

