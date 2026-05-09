<style>
/* ═══════════════════════════════════════════════
   CHAT WIDGET — AI Assistant
   ═══════════════════════════════════════════════ */

.chat-widget-container {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 999;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── Toggle Button ── */
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
    width: 24px;
    height: 24px;
    position: absolute;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
}

.chat-icon-open  { opacity: 1; transform: rotate(0deg) scale(1); }
.chat-icon-close { opacity: 0; transform: rotate(-90deg) scale(0.5); }

.chat-widget-container.open .chat-icon-open  { opacity: 0; transform: rotate(90deg) scale(0.5); }
.chat-widget-container.open .chat-icon-close { opacity: 1; transform: rotate(0deg) scale(1); }

/* Notification dot */
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

/* ── Chat Panel ── */
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

/* ── Header ── */
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
.chat-close svg { width: 16px; height: 16px; }

/* ── Messages ── */
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

/* ── Typing Indicator ── */
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

/* ── Input Area ── */
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

.chat-send-btn svg { width: 18px; height: 18px; }

/* ── Scrollbar ── */
.chat-messages::-webkit-scrollbar { width: 4px; }
.chat-messages::-webkit-scrollbar-track { background: transparent; }
.chat-messages::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 10px; }

/* ── Responsive ── */
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
