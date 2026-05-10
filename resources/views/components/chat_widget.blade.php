<div class="chat-widget-container" id="chatWidget">
    <button class="chat-toggle-btn" id="chatToggleBtn" onclick="toggleChat()" title="Assistant IA">
        <svg class="chat-icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="6" width="18" height="13" rx="2"/>
            <circle cx="8.5" cy="12" r="1.5"/>
            <circle cx="15.5" cy="12" r="1.5"/>
            <path d="M9 16h6"/>
            <path d="M9 3h6"/>
            <line x1="12" y1="3" x2="12" y2="6"/>
        </svg>
        <svg class="chat-icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>

    <div class="chat-panel" id="chatPanel">
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px">
                        <rect x="3" y="6" width="18" height="13" rx="2"/>
                        <circle cx="8.5" cy="12" r="1.5"/>
                        <circle cx="15.5" cy="12" r="1.5"/>
                        <path d="M9 16h6"/>
                        <path d="M9 3h6"/>
                        <line x1="12" y1="3" x2="12" y2="6"/>
                    </svg>
                </div>
                <div>
                    <div class="chat-title">Assistant EPG</div>
                    <div class="chat-status">
                        <span class="status-dot"></span>
                        En ligne
                    </div>
                </div>
            </div>
            <button class="chat-close" onclick="toggleChat()" title="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="chat-message ai-message">
                <div class="message-bubble">
                    Bonjour! Je suis votre assistant intelligent EPG Kanban. Je peux vous aider avec:
                    <ul style="margin:0.5rem 0 0 0;padding-left:1.2rem">
                        <li>Gestion des taches et colonnes</li>
                        <li>Reponses a vos questions</li>
                        <li>Analyse des donnees du tableau</li>
                    </ul>
                </div>
                <span class="message-time">Maintenant</span>
            </div>
        </div>

        <div class="chat-typing" id="chatTyping" style="display:none">
            <div class="typing-bubble">
                <span></span><span></span><span></span>
            </div>
        </div>

        <div class="chat-input-area">
            <form class="chat-form" id="chatForm" onsubmit="sendChatMessage(event)">
                <input
                    type="text"
                    id="chatInput"
                    class="chat-input"
                    placeholder="Ecrivez votre message..."
                    autocomplete="off"
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

    window.toggleChat = function() {
        isOpen = !isOpen;
        chatWidget.classList.toggle('open', isOpen);
        if (isOpen) {
            setTimeout(() => chatInput.focus(), 300);
        }
    };

    chatInput.addEventListener('input', function() {
        chatSendBtn.disabled = !this.value.trim();
    });

    window.sendChatMessage = function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text || isTyping) return;

        addMessage(text, 'user');
        chatInput.value = '';
        chatSendBtn.disabled = true;

        showTyping();

        fetchChatResponse(text);
    };

    function addMessage(text, sender) {
        const div = document.createElement('div');
        div.className = 'chat-message ' + (sender === 'user' ? 'user-message' : 'ai-message');
        const time = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
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
            addMessage(data.reply || 'Desole, je n ai pas compris votre question. Pouvez-vous la reformuler?', 'ai');
        } catch (err) {
            hideTyping();
            addMessage('Desole, une erreur de connexion s est produite. Veuillez reessayer plus tard.', 'ai');
            console.error('Chat error:', err);
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) toggleChat();
    });
})();
</script>
