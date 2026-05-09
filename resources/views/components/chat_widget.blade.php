<div class="chat-widget-container" id="chatWidget">
    <!-- Floating Button -->
    <button class="chat-toggle-btn" id="chatToggleBtn" onclick="toggleChat()" title="AI Assistant">
        <svg class="chat-icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/>
            <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
            <line x1="12" y1="19" x2="12" y2="23"/>
            <line x1="8" y1="23" x2="16" y2="23"/>
        </svg>
        <svg class="chat-icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>

    <!-- Chat Panel -->
    <div class="chat-panel" id="chatPanel">
        <!-- Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px">
                        <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/>
                        <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                        <line x1="12" y1="19" x2="12" y2="23"/>
                        <line x1="8" y1="23" x2="16" y2="23"/>
                    </svg>
                </div>
                <div>
                    <div class="chat-title">مساعد EPG الذكي</div>
                    <div class="chat-status">
                        <span class="status-dot"></span>
                        متصل
                    </div>
                </div>
            </div>
            <button class="chat-close" onclick="toggleChat()" title="إغلاق">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="chat-messages" id="chatMessages">
            <div class="chat-message ai-message">
                <div class="message-bubble">
                    مرحباً! أنا مساعدك الذكي في EPG Kanban. يمكنني مساعدتك في:
                    <ul style="margin:0.5rem 0 0 0;padding-right:1.2rem">
                        <li>إدارة المهام والأعمدة</li>
                        <li>الإجابة على استفساراتك</li>
                        <li>تحليل بيانات اللوحة</li>
                    </ul>
                </div>
                <span class="message-time">الآن</span>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="chat-typing" id="chatTyping" style="display:none">
            <div class="typing-bubble">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Input Area -->
        <div class="chat-input-area">
            <form class="chat-form" id="chatForm" onsubmit="sendChatMessage(event)">
                <input
                    type="text"
                    id="chatInput"
                    class="chat-input"
                    placeholder="اكتب رسالتك هنا..."
                    autocomplete="off"
                    dir="rtl"
                >
                <button type="submit" class="chat-send-btn" id="chatSendBtn" disabled>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
(function() {
    const chatWidget = document.getElementById('chatWidget');
    const chatPanel = document.getElementById('chatPanel');
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');
    const chatSendBtn = document.getElementById('chatSendBtn');
    const chatTyping = document.getElementById('chatTyping');
    const chatForm = document.getElementById('chatForm');

    let isOpen = false;
    let isTyping = false;

    // Toggle chat panel
    window.toggleChat = function() {
        isOpen = !isOpen;
        chatWidget.classList.toggle('open', isOpen);
        if (isOpen) {
            setTimeout(() => chatInput.focus(), 300);
        }
    };

    // Enable/disable send button
    chatInput.addEventListener('input', function() {
        chatSendBtn.disabled = !this.value.trim();
    });

    // Send message
    window.sendChatMessage = function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text || isTyping) return;

        // Add user message
        addMessage(text, 'user');
        chatInput.value = '';
        chatSendBtn.disabled = true;

        // Show typing
        showTyping();

        // Send to backend
        fetchChatResponse(text);
    };

    function addMessage(text, sender) {
        const div = document.createElement('div');
        div.className = 'chat-message ' + (sender === 'user' ? 'user-message' : 'ai-message');
        const time = new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' });
        div.innerHTML = `
            <div class="message-bubble">${escapeHtml(text)}</div>
            <span class="message-time">${time}</span>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
    }

    function showTyping() {
        isTyping = true;
        chatTyping.style.display = 'block';
        scrollToBottom();
    }

    function hideTyping() {
        isTyping = false;
        chatTyping.style.display = 'none';
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Fetch AI response
    async function fetchChatResponse(message) {
        try {
            const response = await fetch('{{ route("chat.ask") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ message: message })
            });

            hideTyping();

            if (!response.ok) throw new Error('Network error');

            const data = await response.json();
            addMessage(data.reply || 'عذراً، لم أفهم سؤالك. هل يمكنك إعادة صياغته؟', 'ai');
        } catch (err) {
            hideTyping();
            addMessage('عذراً، حدث خطأ في الاتصال. يرجى المحاولة لاحقاً.', 'ai');
            console.error('Chat error:', err);
        }
    }

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) toggleChat();
    });
})();
</script>
