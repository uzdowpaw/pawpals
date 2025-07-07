<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.users.index') }}" class="admin-text-secondary hover:opacity-80 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold admin-text-primary">Create New User</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="admin-card rounded-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium admin-text-primary mb-2">
                            Full Name
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-primary @error('name') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                        @error('name')
                        <p class="mt-1 text-sm" style="color: #CD5656;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium admin-text-primary mb-2">
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-primary @error('email') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                        @error('email')
                        <p class="mt-1 text-sm" style="color: #CD5656;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium admin-text-primary mb-2">
                            Role
                        </label>
                        <select id="role" name="role" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-primary @error('role') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                            <option value="">Select a role</option>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="shelter" {{ old('role') === 'shelter' ? 'selected' : '' }}>Shelter</option>
                        </select>
                        @error('role')
                        <p class="mt-1 text-sm" style="color: #CD5656;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium admin-text-primary mb-2">
                            Password
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-primary @error('password') border-red-500 @enderror" style="border-color: #CD5656; background-color: #FFF4EA;">
                        @error('password')
                        <p class="mt-1 text-sm" style="color: #CD5656;">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm admin-text-secondary">Password must be at least 8 characters long.</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium admin-text-primary mb-2">
                            Confirm Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-primary" style="border-color: #CD5656; background-color: #FFF4EA;">
                    </div>

                    <!-- Email Verification -->
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="email_verified" name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }}
                                class="h-4 w-4 rounded" style="color: #CD5656; border-color: #CD5656;">
                            <label for="email_verified" class="ml-2 block text-sm admin-text-primary">
                                Mark email as verified
                            </label>
                        </div>
                        <p class="mt-1 text-sm admin-text-secondary">If unchecked, the user will need to verify their email address.</p>
                    </div>

                    <!-- Send Welcome Email -->
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="send_welcome_email" name="send_welcome_email" value="1" {{ old('send_welcome_email', true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded" style="color: #CD5656; border-color: #CD5656;">
                            <label for="send_welcome_email" class="ml-2 block text-sm admin-text-primary">
                                Send welcome email to user
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t" style="border-color: #CD5656;">
                        <a href="{{ route('admin.users.index') }}"
                            class="admin-btn-secondary px-6 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit"
                            class="admin-btn-primary px-6 py-2 rounded-md text-sm font-medium">
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-6 rounded-lg p-4" style="background-color: #FFF4EA; border: 1px solid #CD5656;">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5" style="color: #CD5656;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium admin-text-primary">
                        User Creation Guidelines
                    </h3>
                    <div class="mt-2 text-sm admin-text-secondary">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Admin users have full access to the admin dashboard and user management features</li>
                            <li>Regular users can only access their own profile and the main application features</li>
                            <li>Email verification is recommended for security purposes</li>
                            <li>Welcome emails help new users get started with the platform</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>