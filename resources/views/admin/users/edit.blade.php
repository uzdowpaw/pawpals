<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.users.index') }}" class="admin-text-secondary hover:opacity-75 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold admin-text-primary">Edit User: {{ $user->name }}</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="admin-card rounded-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PATCH')

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium admin-text-primary mb-2">
                            Full Name
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-secondary @error('name') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium admin-text-primary mb-2">
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-secondary @error('email') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium admin-text-primary mb-2">
                            Role
                        </label>
                        <select id="role" name="role" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-secondary @error('role') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="shelter" {{ old('role', $user->role) === 'shelter' ? 'selected' : '' }}>Shelter</option>
                        </select>
                        @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium admin-text-primary mb-2">
                            New Password (leave blank to keep current)
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-secondary @error('password') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium admin-text-primary mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-secondary" style="border-color: #CD5656; background-color: #FFF4EA;">
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t" style="border-color: #CD5656;">
                        <a href="{{ route('admin.users.index') }}"
                            class="admin-btn-secondary px-6 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit"
                            class="admin-btn-primary px-6 py-2 rounded-md text-sm font-medium">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Information -->
        <div class="mt-6 rounded-lg p-4" style="background-color: #FFF4EA; border: 1px solid #CD5656;">
            <h3 class="text-sm font-medium admin-text-primary mb-2">User Information</h3>
            <div class="text-sm admin-text-secondary space-y-1">
                <p><strong>User ID:</strong> {{ $user->id }}</p>
                <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y \a\t g:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y \a\t g:i A') }}</p>
                <p><strong>Email Verified:</strong>
                    @if($user->email_verified_at)
                    <span class="text-green-600">Yes ({{ $user->email_verified_at->format('M d, Y') }})</span>
                    @else
                    <span class="text-red-600">No</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</x-admin-layout>