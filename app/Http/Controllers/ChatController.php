<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Get all users available for chat.
     */
    public function getUsers()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return response()->json($users);
    }

    /**
     * Get all conversations for the authenticated user.
     */
    public function getConversations()
    {
        $conversations = Auth::user()->conversations()
            ->with(['users' => function ($query) {
                $query->where('users.id', '!=', Auth::id());
            }, 'latestMessage'])
            ->get()
            ->map(function ($conversation) {
                $otherUser = $conversation->users->first();
                return [
                    'id' => $conversation->id,
                    'name' => $conversation->is_group ? $conversation->name : $otherUser->name,
                    'is_group' => $conversation->is_group,
                    'last_message' => $conversation->latestMessage ? [
                        'body' => $conversation->latestMessage->body,
                        'created_at' => $conversation->latestMessage->created_at,
                    ] : null,
                    'users' => $conversation->users,
                ];
            });

        return response()->json($conversations);
    }

    /**
     * Get or create a conversation between the authenticated user and another user.
     */
    public function getOrCreateConversation(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->input('user_id');
        $authUser = Auth::user();

        // Check if a conversation already exists between these users
        $conversation = $authUser->conversations()
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->first();

        // If no conversation exists, create one
        if (!$conversation) {
            $conversation = Conversation::create([
                'is_group' => false,
            ]);

            // Attach both users to the conversation
            $conversation->users()->attach([$authUser->id, $userId]);

            // Load the users relationship
            $conversation->load(['users' => function ($query) use ($authUser) {
                $query->where('users.id', '!=', $authUser->id);
            }]);
        }

        $otherUser = $conversation->users->first();
        $response = [
            'id' => $conversation->id,
            'name' => $otherUser->name,
            'is_group' => false,
            'users' => $conversation->users,
        ];

        return response()->json($response);
    }

    /**
     * Get messages for a specific conversation.
     */
    public function getMessages(Conversation $conversation): JsonResponse
    {
        // Check if the authenticated user is part of this conversation
        if (!$conversation->users->contains(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'body' => $message->body,
                    'user_id' => $message->user_id,
                    'user_name' => $message->user->name,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at,
                ];
            });

        return response()->json($messages);
    }

    /**
     * Send a message in a conversation.
     */
    public function sendMessage(Request $request, Conversation $conversation): JsonResponse
    {
        // Check if the authenticated user is part of this conversation
        if (!$conversation->users->contains(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'body' => 'required|string',
        ]);

        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        $message->load('user');

        $formattedMessage = [
            'id' => $message->id,
            'body' => $message->body,
            'user_id' => $message->user_id,
            'user_name' => $message->user->name,
            'is_read' => $message->is_read,
            'created_at' => $message->created_at,
        ];

        return response()->json($formattedMessage);
    }

    /**
     * Mark all messages in a conversation as read.
     */
    public function markAsRead(Conversation $conversation): JsonResponse
    {
        // Check if the authenticated user is part of this conversation
        if (!$conversation->users->contains(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update the last_read_at timestamp for the user in this conversation
        $conversation->users()->updateExistingPivot(Auth::id(), [
            'last_read_at' => now(),
        ]);

        // Mark all unread messages as read
        $conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
