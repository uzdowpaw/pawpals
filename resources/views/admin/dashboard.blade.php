<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold admin-text-primary">Admin Dashboard</h1>
    </x-slot>

    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #DA6C6C;">
                    <svg class="w-6 h-6 admin-text-neutral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium admin-text-secondary">Total Users</p>
                    <p class="text-2xl font-semibold admin-text-primary">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Active Dogs -->
        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #CD5656;">
                    <svg class="w-6 h-6 admin-text-neutral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium admin-text-secondary">Active Dogs</p>
                    <p class="text-2xl font-semibold admin-text-primary">{{ $activeDogs ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- New Registrations -->
        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #AF3E3E;">
                    <svg class="w-6 h-6 admin-text-neutral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium admin-text-secondary">New This Month</p>
                    <p class="text-2xl font-semibold admin-text-primary">{{ $newUsers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Matches -->
        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #DA6C6C;">
                    <svg class="w-6 h-6 admin-text-neutral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium admin-text-secondary">Total Matches</p>
                    <p class="text-2xl font-semibold admin-text-primary">{{ $totalMatches ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="admin-card">
            <div class="p-6 border-b" style="border-color: #CD5656;">
                <h3 class="text-lg font-medium admin-text-primary">Recent Users</h3>
            </div>
            <div class="p-6">
                @if(isset($recentUsers) && count($recentUsers) > 0)
                <div class="space-y-4">
                    @foreach($recentUsers as $user)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #CD5656;">
                                <span class="text-sm font-medium admin-text-neutral">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium admin-text-primary">{{ $user->name }}</p>
                                <p class="text-sm admin-text-secondary">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: #DA6C6C;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="admin-text-secondary text-center py-4">No recent users found.</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.users.index') }}" class="admin-text-primary hover:opacity-80 text-sm font-medium">
                        View all users →
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="admin-card">
            <div class="p-6 border-b" style="border-color: #CD5656;">
                <h3 class="text-lg font-medium admin-text-primary">System Status</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium admin-text-primary">Database</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: #DA6C6C;">
                            Online
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium admin-text-primary">Cache</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: #CD5656;">
                            Active
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium admin-text-primary">Queue</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: #DA6C6C;">
                            Running
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium admin-text-primary">Storage</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: #AF3E3E;">
                            75% Used
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <div class="admin-card">
            <div class="p-6 border-b" style="border-color: #CD5656;">
                <h3 class="text-lg font-medium admin-text-primary">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 border rounded-lg hover:opacity-80" style="border-color: #CD5656; background-color: #EAEBD0;">
                        <svg class="w-8 h-8 mr-3" style="color: #DA6C6C;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium admin-text-primary">Add New User</p>
                            <p class="text-sm admin-text-secondary">Create a new user account</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 border rounded-lg hover:opacity-80" style="border-color: #CD5656; background-color: #EAEBD0;">
                        <svg class="w-8 h-8 mr-3" style="color: #CD5656;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium admin-text-primary">Manage Users</p>
                            <p class="text-sm admin-text-secondary">View and edit user accounts</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center p-4 border rounded-lg hover:opacity-80" style="border-color: #CD5656; background-color: #EAEBD0;">
                        <svg class="w-8 h-8 mr-3" style="color: #AF3E3E;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium admin-text-primary">View Reports</p>
                            <p class="text-sm admin-text-secondary">Generate system reports</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Components -->
    <div id="chat-sidebar"></div>
    <div id="chat-windows"></div>
    <div class="chat-toggle-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </div>
</x-admin-layout>