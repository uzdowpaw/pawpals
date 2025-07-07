<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold admin-text-primary">User Management</h1>
            <a href="{{ route('admin.users.create') }}" class="admin-btn-primary px-4 py-2 rounded-lg text-sm font-medium">
                Add New User
            </a>
        </div>
    </x-slot>

    <!-- Search and Filters -->
    <div class="admin-card mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users by name or email..."
                        class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-primary" style="border-color: #CD5656; background-color: #FFF4EA;">
                </div>
                <div class="w-full md:w-48">
                    <select name="role" class="w-full px-3 py-2 border rounded-md focus:outline-none admin-text-primary" style="border-color: #CD5656; background-color: #FFF4EA;">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="admin-btn-primary px-4 py-2 rounded-md text-sm font-medium">
                        Search
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="admin-btn-secondary px-4 py-2 rounded-md text-sm font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y" style="border-color: #CD5656;">
                <thead style="background-color: #EAEBD0;">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">
                            Joined
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium admin-text-primary uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium admin-text-primary uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="admin-card divide-y" style="border-color: #CD5656;">
                    @forelse($users as $user)
                    <tr class="hover:opacity-80">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #CD5656;">
                                    <span class="text-sm font-medium admin-text-neutral">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium admin-text-primary">{{ $user->name }}</div>
                                    <div class="text-sm admin-text-secondary">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: {{ $user->role === 'admin' ? '#DA6C6C' : '#CD5656' }};">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-secondary">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->email_verified_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: #DA6C6C;">
                                Verified
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium admin-text-neutral" style="background-color: #AF3E3E;">
                                Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="admin-text-primary hover:opacity-80">
                                    View
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="admin-text-primary hover:opacity-80">
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-text-primary hover:opacity-80">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center admin-text-secondary">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="admin-card px-4 py-3 border-t sm:px-6" style="border-color: #CD5656;">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Bulk Actions -->
    <div class="mt-6 admin-card">
        <div class="p-6">
            <h3 class="text-lg font-medium admin-text-primary mb-4">Bulk Actions</h3>
            <div class="flex flex-wrap gap-4">
                <button class="admin-btn-primary px-4 py-2 rounded-md text-sm font-medium"
                    onclick="alert('Export functionality would be implemented here')">
                    Export Users
                </button>
                <button class="admin-btn-secondary px-4 py-2 rounded-md text-sm font-medium"
                    onclick="alert('Email functionality would be implemented here')">
                    Send Bulk Email
                </button>
                <button class="admin-btn-secondary px-4 py-2 rounded-md text-sm font-medium"
                    onclick="alert('Import functionality would be implemented here')">
                    Import Users
                </button>
            </div>
        </div>
    </div>
</x-admin-layout>