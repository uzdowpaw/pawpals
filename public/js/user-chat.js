// User Chat Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Find all chat buttons
    const chatButtons = document.querySelectorAll('.open-chat-btn');
    
    // Add click event listener to each button
    chatButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            
            // Call the openChat method from the chatModule
            if (window.chatModule) {
                window.chatModule.openChat(userId);
            } else {
                console.error('Chat module not found');
            }
        });
    });
});