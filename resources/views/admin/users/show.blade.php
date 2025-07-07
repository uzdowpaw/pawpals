<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.users.index') }}" class="admin-text-secondary hover:opacity-75 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold admin-text-primary">User Details</h1>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="admin-btn-primary px-4 py-2 rounded-lg text-sm font-medium">
                    Edit User
                </a>
                @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                    onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Delete User
                    </button>
                </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Profile -->
        <div class="lg:col-span-2">
            <div class="admin-card rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mr-6" style="background-color: #CD5656;">
                            <span class="text-2xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold admin-text-primary">{{ $user->name }}</h2>
                            <p class="admin-text-secondary">{{ $user->email }}</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium admin-text-primary mb-4">Account Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium admin-text-secondary">User ID</dt>
                                    <dd class="text-sm admin-text-primary">{{ $user->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium admin-text-secondary">Email Status</dt>
                                    <dd class="text-sm">
                                        @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Verified
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Unverified
                                        </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium admin-text-secondary">Member Since</dt>
                                    <dd class="text-sm admin-text-primary">{{ $user->created_at->format('F d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium admin-text-secondary">Last Updated</dt>
                                    <dd class="text-sm admin-text-primary">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium admin-text-primary mb-4">Activity Summary</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium admin-text-secondary">Dogs Registered</dt>
                                    <dd class="text-sm admin-text-primary">{{ $user->dogs()->count() ?? 0 }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium admin-text-secondary">Profile Completeness</dt>
                                    <dd class="text-sm admin-text-primary">
                                        @php
                                        $completeness = 0;
                                        if($user->name) $completeness += 25;
                                        if($user->email) $completeness += 25;
                                        if($user->email_verified_at) $completeness += 25;
                                        if($user->dogs()->count() > 0) $completeness += 25;
                                        @endphp
                                        <div class="flex items-center">
                                            <div class="w-full rounded-full h-2 mr-2" style="background-color: #FFF4EA;">
                                                <div class="h-2 rounded-full" style="width: {{ $completeness }}%; background-color: #CD5656;"></div>
                                            </div>
                                            <span class="text-xs">{{ $completeness }}%</span>
                                        </div>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium admin-text-secondary">Account Status</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User's Dogs -->
            @if($user->dogs && $user->dogs->count() > 0)
            <div class="mt-6 admin-card rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium admin-text-primary mb-4">Registered Dogs</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($user->dogs as $dog)
                        <div class="border rounded-lg p-4" style="border-color: #CD5656;">
                            <h4 class="font-medium admin-text-primary">{{ $dog->name }}</h4>
                            <p class="text-sm admin-text-secondary">{{ $dog->breed ?? 'Unknown breed' }}</p>
                            <p class="text-sm admin-text-secondary">Age: {{ $dog->age ?? 'Unknown' }}</p>
                            <p class="text-xs admin-text-neutral mt-2">Added {{ $dog->created_at->format('M d, Y') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <div class="admin-card rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium admin-text-primary mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="w-full flex items-center justify-center px-4 py-2 border rounded-md text-sm font-medium admin-text-secondary hover:opacity-75" style="border-color: #CD5656; background-color: #FFF4EA;">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>

                        @if(!$user->email_verified_at)
                        <button class="w-full flex items-center justify-center px-4 py-2 border rounded-md text-sm font-medium admin-text-secondary hover:opacity-75" style="border-color: #CD5656; background-color: #FFF4EA;"
                            onclick="alert('Email verification functionality would be implemented here')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Verification Email
                        </button>
                        @endif

                        <button class="w-full flex items-center justify-center px-4 py-2 border rounded-md text-sm font-medium admin-text-secondary hover:opacity-75" style="border-color: #CD5656; background-color: #FFF4EA;"
                            onclick="alert('Password reset functionality would be implemented here')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2L4.257 10.257a6 6 0 0111.486-3.486L16 6.5a2 2 0 012 2v2a2 2 0 01-2 2h-1m-6 4v1a2 2 0 002 2h2a2 2 0 002-2v-1m-6 0V9a2 2 0 012-2h2a2 2 0 012 2v8.1"></path>
                            </svg>
                            Reset Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="admin-card rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium admin-text-primary mb-4">Account Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm admin-text-secondary">Days since registration</span>
                            <span class="text-sm font-medium admin-text-primary">{{ $user->created_at->diffInDays(now()) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm admin-text-secondary">Profile updates</span>
                            <span class="text-sm font-medium admin-text-primary">{{ $user->created_at->eq($user->updated_at) ? 0 : 1 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm admin-text-secondary">Dogs registered</span>
                            <span class="text-sm font-medium admin-text-primary">{{ $user->dogs()->count() ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>