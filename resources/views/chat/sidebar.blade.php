<div class="h-full flex flex-col">
    <h3 class="text-xl font-semibold text-white mb-6">Available for Chat</h3>
    <div id="chat-user-list" class="chat-user-list flex flex-col items-center justify-center flex-grow overflow-y-auto space-y-3 pr-2">
        {{-- User items will be dynamically loaded here by chat.js --}}
        {{-- Placeholder for when no users are available --}}
        <div id="no-chat-users" class="text-center py-10">
            <svg class="mx-auto h-12 w-12 text-white-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-white">No users online</h3>
            <p class="mt-1 text-xs text-white">Check back later to chat with other users.</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Custom scrollbar for chat user list */
    .chat-user-list::-webkit-scrollbar {
        width: 6px;
    }

    .chat-user-list::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }
    
    .chat-user-list::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .chat-user-list::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .chat-user-item {
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    .chat-user-item:hover {
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateX(2px);
    }

    .chat-user-avatar {
        min-width: 32px;
        /* Ensure avatar doesn't shrink */
    }

    .chat-user-status {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-left: auto;
    }

    .chat-user-status.online {
        background-color: #4ade80;
        /* Tailwind green-400 */
    }

    .chat-user-status.offline {
        background-color: #9ca3af;
        /* Tailwind gray-400 */
    }
</style>
@endpush