<style>
.chat-widget-container {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 999;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.chat-toggle-btn {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    color: white;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(0,85,179,0.35), 0 0 0 4px rgba(0,85,179,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    position: relative;
}

.chat-toggle-btn:hover {
    transform: scale(1.08) rotate(-5deg);
    box-shadow: 0 6px 28px rgba(0,85,179,0.45), 0 0 0 6px rgba(0,85,179,0.12);
}

.chat-toggle-btn:active { transform: scale(0.95); }

.chat-icon-open,
.chat-icon-close {
    width: 26px;
    height: 26px;
    position: absolute;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
}

.chat-icon-open  { opacity: 1; transform: rotate(0deg) scale(1); }
.chat-icon-close { opacity: 0; transform: rotate(-90deg) scale(0.5); }

.chat-widget-container.open .chat-icon-open  { opacity: 0; transform: rotate(90deg) scale(0.5); }
.chat-widget-container.open .chat-icon-close { opacity: 1; transform: rotate(0deg) scale(1); }

.chat-toggle-btn::after {
    content: '';
    position: absolute;
    top: 3px;
    right: 3px;
    width: 12px;
    height: 12px;
    background: #10b981;
    border-radius: 50%;
    border: 2px solid var(--accent);
    animation: chatPulse 2s infinite;
}

@keyframes chatPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.5); }
    50% { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
}

.chat-widget-container.open .chat-toggle-btn::after { display: none; }

.chat-panel {
    position: absolute;
    bottom: 72px;
    right: 0;
    width: 380px;
    max-width: calc(100vw - 2rem);
    height: 520px;
    max-height: calc(100vh - 140px);
    background: var(--surface);
    border: 1px solid var(--border2);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 0 0 1px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    opacity: 0;
    transform: translateY(20px) scale(0.92);
    pointer-events: none;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
}

.chat-widget-container.open .chat-panel {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}

[data-theme="dark"] .chat-panel {
    box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.03);
}

.chat-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.chat-header-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.chat-avatar {
    width: 38px;
    height: 38px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
    border: 2px solid rgba(255,255,255,0.3);
}

.chat-title {
    font-size: 0.88rem;
    font-weight: 700;
    line-height: 1.2;
}

.chat-status {
    font-size: 0.68rem;
    opacity: 0.85;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    margin-top: 0.1rem;
}

.status-dot {
    width: 7px;
    height: 7px;
    background: #4ade80;
    border-radius: 50%;
    box-shadow: 0 0 6px rgba(74,222,128,0.5);
    animation: statusBlink 2s infinite;
}

@keyframes statusBlink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.chat-close {
    background: rgba(255,255,255,0.15);
    border: none;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}

.chat-close:hover { background: rgba(255,255,255,0.25); }

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    background: var(--bg);
}

.chat-message {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    max-width: 85%;
    animation: messageIn 0.3s ease;
}

@keyframes messageIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.ai-message  { align-self: flex-start; }
.user-message { align-self: flex-end; }

.message-bubble {
    padding: 0.75rem 1rem;
    border-radius: 16px;
    font-size: 0.82rem;
    line-height: 1.65;
    word-wrap: break-word;
}

.ai-message .message-bubble {
    background: var(--surface);
    color: var(--text);
    border: 1px solid var(--border);
    border-bottom-left-radius: 4px;
}

.user-message .message-bubble {
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    color: white;
    border-bottom-right-radius: 4px;
}

.message-time {
    font-size: 0.65rem;
    color: var(--text3);
    padding: 0 0.3rem;
}

.user-message .message-time { text-align: left; }
.ai-message .message-time   { text-align: right; }

.chat-typing {
    padding: 0 1rem 0.5rem;
    align-self: flex-start;
}

.typing-bubble {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    border-bottom-left-radius: 4px;
    padding: 0.85rem 1.1rem;
    display: flex;
    gap: 0.35rem;
    align-items: center;
    width: fit-content;
}

.typing-bubble span {
    width: 7px;
    height: 7px;
    background: var(--text3);
    border-radius: 50%;
    animation: typingBounce 1.4s infinite ease-in-out both;
}

.typing-bubble span:nth-child(1) { animation-delay: -0.32s; }
.typing-bubble span:nth-child(2) { animation-delay: -0.16s; }

@keyframes typingBounce {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

.chat-input-area {
    padding: 0.75rem 1rem;
    background: var(--surface);
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}

.chat-form {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.chat-input {
    flex: 1;
    padding: 0.65rem 1rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    color: var(--text);
    font-size: 0.85rem;
    font-family: inherit;
    outline: none;
    transition: all 0.2s;
}

.chat-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-bg);
}

.chat-input::placeholder { color: var(--text3); }

.chat-send-btn {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: var(--accent);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}

.chat-send-btn:hover:not(:disabled) {
    background: var(--accent2);
    transform: scale(1.05);
}

.chat-send-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.chat-messages::-webkit-scrollbar { width: 4px; }
.chat-messages::-webkit-scrollbar-track { background: transparent; }
.chat-messages::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 10px; }

@media (max-width: 480px) {
    .chat-widget-container {
        bottom: 1rem;
        right: 1rem;
    }
    .chat-panel {
        width: calc(100vw - 2rem);
        right: -0.5rem;
        height: calc(100vh - 100px);
        border-radius: 16px;
    }
    .chat-toggle-btn {
        width: 50px;
        height: 50px;
    }
}
</style>

<div class="chat-widget-container" id="chatWidget">
    <button class="chat-toggle-btn" id="chatToggleBtn" onclick="toggleChat()" title="Assistant IA">
        <svg class="chat-icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="10" rx="2"/>
            <circle cx="12" cy="5" r="2"/>
            <path d="M12 7v4"/>
            <line x1="8" y1="16" x2="8" y2="16"/>
            <line x1="16" y1="16" x2="16" y2="16"/>
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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px">
                        <rect x="3" y="11" width="18" height="10" rx="2"/>
                        <circle cx="12" cy="5" r="2"/>
                        <path d="M12 7v4"/>
                        <line x1="8" y1="16" x2="8" y2="16"/>
                        <line x1="16" y1="16" x2="16" y2="16"/>
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
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');
    const chatSendBtn = document.getElementById('chatSendBtn');
    const chatTyping = document.getElementById('chatTyping');

    let isOpen = false;
    let isTyping = false;

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) return meta.content;
        const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        if (match) {
            try {
                return decodeURIComponent(atob(match[1]));
            } catch(e) { return ''; }
        }
        return '';
    }

    window.toggleChat = function() {
        isOpen = !isOpen;
        chatWidget.classList.toggle('open', isOpen);
        if (isOpen) setTimeout(() => chatInput.focus(), 300);
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
        div.innerHTML = '<div class="message-bubble">' + escapeHtml(text) + '</div><span class="message-time">' + time + '</span>';
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
        const csrfToken = getCsrfToken();
        const chatUrl = '{{ route("chat.ask") }}';

        try {
            const response = await fetch(chatUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message: message })
            });

            hideTyping();

            if (!response.ok) {
                const errorText = await response.text();
                addMessage('Erreur serveur: ' + response.status + ' - ' + errorText.substring(0, 100), 'ai');
                return;
            }

            const data = await response.json();
            if (data.reply) {
                addMessage(data.reply, 'ai');
            } else {
                addMessage('Desole, je n ai pas pu traiter votre demande.', 'ai');
            }
        } catch (err) {
            hideTyping();
            addMessage('Erreur de connexion: ' + err.message, 'ai');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) toggleChat();
    });
})();
</script>
