@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">🔔 Notifications</h1>
            <a href="{{ route('user.dog-tinder.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                Back to Browse
            </a>
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="notification-item bg-white rounded-lg shadow-md p-6 border-l-4 {{ $notification->read_at ? 'border-gray-300' : 'border-blue-500' }} {{ $notification->read_at ? 'opacity-75' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                @if($notification->type === 'match')
                                    <div class="flex items-center mb-2">
                                        <span class="text-2xl mr-2">💕</span>
                                        <h3 class="text-lg font-semibold text-gray-900">New Match!</h3>
                                        @if(!$notification->read_at)
                                            <span class="ml-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-700 mb-2">{{ $notification->data['message'] }}</p>
                                    
                                    @if(isset($notification->data['dog_name']))
                                        <p class="text-sm text-gray-500">
                                            Dog: <span class="font-medium">{{ $notification->data['dog_name'] }}</span>
                                        </p>
                                    @endif
                                @else
                                    <div class="flex items-center mb-2">
                                        <span class="text-2xl mr-2">📢</span>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ ucfirst($notification->type) }}</h3>
                                        @if(!$notification->read_at)
                                            <span class="ml-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-700">{{ $notification->data['message'] ?? 'You have a new notification' }}</p>
                                @endif
                                
                                <p class="text-xs text-gray-400 mt-3">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            <div class="ml-4 flex flex-col space-y-2">
                                @if(!$notification->read_at)
                                    <button onclick="markAsRead({{ $notification->id }})" 
                                            class="text-blue-500 hover:text-blue-700 text-sm transition-colors">
                                        Mark as Read
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No notifications yet</h2>
                <p class="text-gray-700 mb-6">Start browsing dogs to get notifications about matches!</p>
                <a href="{{ route('user.dog-tinder.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
                    Start Browsing
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function markAsRead(notificationId) {
    fetch(`/user/dog-tinder/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload the page to update the notification status
            window.location.reload();
        } else {
            alert('Error marking notification as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}
</script>
@endpush
@endsection