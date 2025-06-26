<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Adoption Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Adoption #{{ $adoption->id ?? 'N/A' }}</h3>
                        <a href="{{ route('admin.adoptions.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Adoptions
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Adoption Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-4">Adoption Information</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium">Status:</span>
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if(isset($adoption->status))
                                            @if($adoption->status === 'approved') bg-green-100 text-green-800
                                            @elseif($adoption->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($adoption->status ?? 'pending') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium">Application Date:</span>
                                    <span class="ml-2">{{ isset($adoption->created_at) ? $adoption->created_at->format('M d, Y H:i') : 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Last Updated:</span>
                                    <span class="ml-2">{{ isset($adoption->updated_at) ? $adoption->updated_at->format('M d, Y H:i') : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-4">Applicant Information</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium">Name:</span>
                                    <span class="ml-2">{{ $adoption->user->name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Email:</span>
                                    <span class="ml-2">{{ $adoption->user->email ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Phone:</span>
                                    <span class="ml-2">{{ $adoption->user->phone ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pet Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-4">Pet Information</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium">Name:</span>
                                    <span class="ml-2">{{ $adoption->pet->name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Breed:</span>
                                    <span class="ml-2">{{ $adoption->pet->breed ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Age:</span>
                                    <span class="ml-2">{{ $adoption->pet->age ?? 'N/A' }} years</span>
                                </div>
                            </div>
                        </div>

                        <!-- Application Details -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-4">Application Details</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium">Reason for Adoption:</span>
                                    <p class="mt-1 text-sm">{{ $adoption->reason ?? 'No reason provided' }}</p>
                                </div>
                                <div>
                                    <span class="font-medium">Experience with Pets:</span>
                                    <p class="mt-1 text-sm">{{ $adoption->experience ?? 'No experience details provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex space-x-4">
                        @if(isset($adoption->status) && $adoption->status === 'pending')
                            <form action="{{ route('admin.adoptions.update', $adoption->id ?? 1) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Are you sure you want to approve this adoption?')">
                                    Approve Adoption
                                </button>
                            </form>

                            <form action="{{ route('admin.adoptions.update', $adoption->id ?? 1) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Are you sure you want to reject this adoption?')">
                                    Reject Adoption
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.adoptions.destroy', $adoption->id ?? 1) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('Are you sure you want to delete this adoption record?')">
                                Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>