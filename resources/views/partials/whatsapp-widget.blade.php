{{-- WhatsApp Chat Widget --}}
@php
    $enabled = setting('whatsapp_enabled') === '1' || setting('whatsapp_enabled') === 'true';
    $number = setting('whatsapp_number', '256772464686');
    $displayName = setting('whatsapp_display_name', 'RoyalWay Media');
    $greeting = setting('whatsapp_greeting', 'Hi there! Planning a campaign, event or media project? Chat with us now — we usually reply within minutes.');
    $prefill = setting('whatsapp_prefill', 'Hello RoyalWay Media, I\'d like to enquire about your services.');
    $position = setting('whatsapp_position', 'right');
    $logo = setting_file_url('logo', asset('assets/img/logo.svg'));
    $waLink = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $number) . '?text=' . urlencode($prefill);
@endphp

@if($enabled)
<div class="wa-widget" data-position="{{ $position }}" id="waWidget">
    {{-- Floating Button --}}
    <button class="wa-widget-btn" id="waToggle" aria-label="Chat on WhatsApp" aria-expanded="false" aria-controls="waPopup">
        <i class="fa-brands fa-whatsapp"></i>
    </button>

    {{-- Popup Card --}}
    <div class="wa-widget-popup" id="waPopup" role="dialog" aria-labelledby="waTitle" aria-hidden="true">
        <div class="wa-widget-header">
            <div class="wa-widget-avatar">
                <img src="{{ $logo }}" alt="{{ $displayName }}">
            </div>
            <div class="wa-widget-info">
                <span class="wa-widget-name" id="waTitle">{{ $displayName }}</span>
                <span class="wa-widget-status"><span class="wa-online-dot"></span> Online</span>
            </div>
            <button class="wa-widget-close" id="waClose" aria-label="Close chat">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="wa-widget-body">
            <div class="wa-chat-bubble">
                <span class="wa-chat-name">{{ $displayName }}</span>
                <p class="wa-chat-message">{{ $greeting }}</p>
            </div>
        </div>
        <div class="wa-widget-footer">
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="wa-start-chat">
                <i class="fa-brands fa-whatsapp me-2"></i> Start Chat
            </a>
        </div>
    </div>
</div>

<style>
.wa-widget {
    position: fixed;
    bottom: 24px;
    z-index: 9998;
}
.wa-widget[data-position="right"] {
    right: 24px;
}
.wa-widget[data-position="left"] {
    left: 24px;
}
.wa-widget-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #25D366;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.wa-widget-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 25px rgba(37, 211, 102, 0.5);
}
.wa-widget-btn i {
    color: white;
    font-size: 32px;
}
.wa-widget-popup {
    position: absolute;
    bottom: 75px;
    width: 340px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.15);
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px) scale(0.95);
    transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
}
.wa-widget[data-position="right"] .wa-widget-popup {
    right: 0;
}
.wa-widget[data-position="left"] .wa-widget-popup {
    left: 0;
}
.wa-widget-popup.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}
.wa-widget-header {
    background: linear-gradient(135deg, #1B3A6D 0%, #0f2444 100%);
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.wa-widget-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
}
.wa-widget-avatar img {
    width: 36px;
    height: auto;
}
.wa-widget-info {
    flex: 1;
}
.wa-widget-name {
    color: #fff;
    font-weight: 600;
    display: block;
    font-size: 15px;
}
.wa-widget-status {
    color: rgba(255,255,255,0.8);
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.wa-online-dot {
    width: 8px;
    height: 8px;
    background: #25D366;
    border-radius: 50%;
    display: inline-block;
}
.wa-widget-close {
    background: rgba(255,255,255,0.1);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}
.wa-widget-close:hover {
    background: rgba(255,255,255,0.2);
}
.wa-widget-body {
    padding: 20px 16px;
    background: #e8efe5;
    min-height: 80px;
}
.wa-chat-bubble {
    background: #fff;
    padding: 12px 14px;
    border-radius: 0 12px 12px 12px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    max-width: 90%;
}
.wa-chat-name {
    color: #25D366;
    font-weight: 600;
    font-size: 13px;
    display: block;
    margin-bottom: 4px;
}
.wa-chat-message {
    color: #333;
    font-size: 14px;
    line-height: 1.5;
    margin: 0;
}
.wa-widget-footer {
    padding: 16px;
    background: #fff;
}
.wa-start-chat {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 14px 20px;
    background: #25D366;
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    font-size: 15px;
    transition: background 0.2s;
}
.wa-start-chat:hover {
    background: #20bd5a;
    color: #fff;
}

/* Mobile responsiveness */
@media (max-width: 480px) {
    .wa-widget {
        bottom: 16px;
    }
    .wa-widget[data-position="right"] {
        right: 16px;
    }
    .wa-widget[data-position="left"] {
        left: 16px;
    }
    .wa-widget-popup {
        width: calc(100vw - 32px);
        right: 0 !important;
        left: 0 !important;
        margin: 0 auto;
    }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    .wa-widget-btn,
    .wa-widget-popup {
        transition: none;
    }
}
</style>

<script>
(function() {
    'use strict';
    var widget = document.getElementById('waWidget');
    var toggle = document.getElementById('waToggle');
    var popup = document.getElementById('waPopup');
    var closeBtn = document.getElementById('waClose');

    if (!widget || !toggle || !popup) return;

    function openPopup() {
        popup.classList.add('active');
        popup.setAttribute('aria-hidden', 'false');
        toggle.setAttribute('aria-expanded', 'true');
        closeBtn.focus();
    }

    function closePopup() {
        popup.classList.remove('active');
        popup.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
    }

    toggle.addEventListener('click', function() {
        if (popup.classList.contains('active')) {
            closePopup();
        } else {
            openPopup();
        }
    });

    closeBtn.addEventListener('click', closePopup);

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && popup.classList.contains('active')) {
            closePopup();
        }
    });

    // Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!widget.contains(e.target) && popup.classList.contains('active')) {
            closePopup();
        }
    });
})();
</script>
@endif
