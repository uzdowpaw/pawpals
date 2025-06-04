// Chat functionality
const chatModule = {
    init() {
        this.chatSidebar = document.getElementById('chat-sidebar');
        this.chatWindows = document.getElementById('chat-windows');
        this.activeChats = new Map(); // Store active chat windows
        
        this.loadUsers();
        this.setupEventListeners();
        this.pollForNewMessages();
    },
    
    setupEventListeners() {
        // Global event delegation for chat actions
        document.addEventListener('click', (e) => {
            // Handle user click in sidebar
            if (e.target.closest('.chat-user-item')) {
                const userId = e.target.closest('.chat-user-item').dataset.userId;
                this.openChat(userId);
            }
            
            // Handle chat header click (minimize/maximize)
            if (e.target.closest('.chat-header')) {
                const chatWindow = e.target.closest('.chat-window');
                this.toggleChatWindow(chatWindow);
            }
            
            // Handle close chat button
            if (e.target.closest('.close-chat')) {
                e.preventDefault();
                const chatWindow = e.target.closest('.chat-window');
                this.closeChat(chatWindow);
            }
        });
        
        // Handle message submission
        document.addEventListener('submit', (e) => {
            if (e.target.classList.contains('chat-message-form')) {
                e.preventDefault();
                const form = e.target;
                const conversationId = form.dataset.conversationId;
                const input = form.querySelector('.chat-message-input');
                const message = input.value.trim();
                
                if (message) {
                    this.sendMessage(conversationId, message);
                    input.value = '';
                }
            }
        });
    },
    
    async loadUsers() {
        try {
            const response = await fetch('/chat/users');
            const users = await response.json();
            
            this.renderUserList(users);
        } catch (error) {
            console.error('Error loading users:', error);
        }
    },
    
    renderUserList(users) {
        if (!this.chatSidebar) return;
        
        const userList = document.createElement('div');
        userList.className = 'chat-user-list';
        
        users.forEach(user => {
            const userItem = document.createElement('div');
            userItem.className = 'chat-user-item';
            userItem.dataset.userId = user.id;
            
            userItem.innerHTML = `
                <div class="flex items-center p-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold mr-3">
                        ${user.name.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <div class="font-medium">${user.name}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Click to chat</div>
                    </div>
                </div>
            `;
            
            userList.appendChild(userItem);
        });
        
        this.chatSidebar.innerHTML = '';
        this.chatSidebar.appendChild(userList);
    },
    
    async openChat(userId) {
        try {
            // Get or create conversation
            const response = await fetch('/chat/conversations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            });
            
            const conversation = await response.json();
            
            // Check if chat is already open
            if (this.activeChats.has(conversation.id)) {
                // Focus on existing chat
                const existingChat = document.querySelector(`.chat-window[data-conversation-id="${conversation.id}"]`);
                if (existingChat.classList.contains('chat-minimized')) {
                    this.toggleChatWindow(existingChat);
                }
                return;
            }
            
            // Create new chat window
            this.createChatWindow(conversation);
            
            // Load messages
            this.loadMessages(conversation.id);
            
            // Add to active chats
            this.activeChats.set(conversation.id, conversation);
            
        } catch (error) {
            console.error('Error opening chat:', error);
        }
    },
    
    createChatWindow(conversation) {
        const chatWindow = document.createElement('div');
        chatWindow.className = 'chat-window';
        chatWindow.dataset.conversationId = conversation.id;
        
        chatWindow.innerHTML = `
            <div class="chat-header">
                <div class="chat-header-title">${conversation.name}</div>
                <button class="close-chat">&times;</button>
            </div>
            <div class="chat-messages"></div>
            <form class="chat-message-form" data-conversation-id="${conversation.id}">
                <input type="text" class="chat-message-input" placeholder="Type a message...">
                <button type="submit" class="chat-send-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </form>
        `;
        
        if (!this.chatWindows) {
            // Create chat windows container if it doesn't exist
            this.chatWindows = document.createElement('div');
            this.chatWindows.id = 'chat-windows';
            document.body.appendChild(this.chatWindows);
        }
        
        this.chatWindows.appendChild(chatWindow);
    },
    
    async loadMessages(conversationId) {
        try {
            const response = await fetch(`/chat/conversations/${conversationId}/messages`);
            const messages = await response.json();
            
            const chatWindow = document.querySelector(`.chat-window[data-conversation-id="${conversationId}"]`);
            const messagesContainer = chatWindow.querySelector('.chat-messages');
            
            messagesContainer.innerHTML = '';
            
            messages.forEach(message => {
                this.addMessageToChat(conversationId, message);
            });
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            // Mark messages as read
            this.markMessagesAsRead(conversationId);
            
        } catch (error) {
            console.error('Error loading messages:', error);
        }
    },
    
    async sendMessage(conversationId, message) {
        try {
            const response = await fetch(`/chat/conversations/${conversationId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ body: message })
            });
            
            const newMessage = await response.json();
            this.addMessageToChat(conversationId, newMessage);
            
            // Scroll to bottom
            const chatWindow = document.querySelector(`.chat-window[data-conversation-id="${conversationId}"]`);
            const messagesContainer = chatWindow.querySelector('.chat-messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
        } catch (error) {
            console.error('Error sending message:', error);
        }
    },
    
    addMessageToChat(conversationId, message) {
        const chatWindow = document.querySelector(`.chat-window[data-conversation-id="${conversationId}"]`);
        if (!chatWindow) return;
        
        const messagesContainer = chatWindow.querySelector('.chat-messages');
        const messageElement = document.createElement('div');
        
        // Check if message is from current user
        const isCurrentUser = message.user_id === parseInt(document.body.dataset.userId);
        messageElement.className = `chat-message ${isCurrentUser ? 'chat-message-self' : 'chat-message-other'}`;
        
        const time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        messageElement.innerHTML = `
            <div class="chat-message-content">
                ${message.body}
            </div>
            <div class="chat-message-time">${time}</div>
        `;
        
        messagesContainer.appendChild(messageElement);
    },
    
    toggleChatWindow(chatWindow) {
        chatWindow.classList.toggle('chat-minimized');
    },
    
    closeChat(chatWindow) {
        const conversationId = chatWindow.dataset.conversationId;
        this.activeChats.delete(parseInt(conversationId));
        chatWindow.remove();
    },
    
    async markMessagesAsRead(conversationId) {
        try {
            await fetch(`/chat/conversations/${conversationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        } catch (error) {
            console.error('Error marking messages as read:', error);
        }
    },
    
    pollForNewMessages() {
        // Poll for new messages every 5 seconds
        setInterval(async () => {
            // Only poll for active conversations
            for (const conversationId of this.activeChats.keys()) {
                await this.loadMessages(conversationId);
            }
        }, 5000);
    }
};

// Initialize chat when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    chatModule.init();
});

export default chatModule;