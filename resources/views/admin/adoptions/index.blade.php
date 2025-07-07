<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl admin-text-primary leading-tight">
            {{ __('Adoptions Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-card overflow-hidden sm:rounded-lg">
                <div class="p-6 admin-text-primary">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium admin-text-primary">All Adoptions</h3>
                    </div>

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(count($adoptions) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y" style="border-color: #CD5656;">
                            <thead style="background-color: #FFF4EA;">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium admin-text-secondary uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium admin-text-secondary uppercase tracking-wider">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium admin-text-secondary uppercase tracking-wider">
                                        Pet
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium admin-text-secondary uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium admin-text-secondary uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium admin-text-secondary uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="admin-card divide-y" style="border-color: #CD5656;">
                                @foreach($adoptions as $adoption)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-primary">
                                        {{ $adoption->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-primary">
                                        {{ $adoption->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-primary">
                                        {{ $adoption->pet->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($adoption->status === 'approved') bg-green-100 text-green-800
                                                    @elseif($adoption->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($adoption->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm admin-text-primary">
                                        {{ $adoption->created_at ? $adoption->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.adoptions.show', $adoption->id) }}"
                                            class="admin-text-secondary hover:underline mr-3">
                                            View
                                        </a>
                                        <form action="{{ route('admin.adoptions.destroy', $adoption->id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this adoption?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="admin-text-secondary hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="admin-text-secondary">
                            <svg class="mx-auto h-12 w-12 admin-text-neutral" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium admin-text-primary">No adoptions</h3>
                            <p class="mt-1 text-sm admin-text-secondary">No adoption applications have been submitted yet.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>