{{--
    Preview modal for communication assets. Opened by any [data-preview-open] button.
    Optional: $autoOpen (Resource) opens that asset when the page loads (?preview=slug links).
    Optional: $syncUrl (bool) keeps ?preview=slug in the address bar while open.
--}}
@php
    $syncUrl = $syncUrl ?? false;
@endphp

<dialog class="ca-modal" id="ca-preview" aria-labelledby="ca-preview-title" data-sync-url="{{ $syncUrl ? '1' : '0' }}">
    <div class="ca-modal-inner">
        <div class="ca-modal-head">
            <h2 class="ca-modal-title" id="ca-preview-title">Preview</h2>
            <div class="ca-modal-tools">
                <a href="#" class="ca-btn" id="ca-preview-download" download>
                    <i class="fas fa-download" aria-hidden="true"></i> Download
                </a>
                <button type="button" class="ca-close" id="ca-preview-close" aria-label="Close preview">
                    <i class="fas fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="ca-modal-body" id="ca-preview-body"></div>
        <p class="ca-modal-note" id="ca-preview-note" hidden></p>
    </div>
</dialog>

@if(!empty($autoOpen) && $autoOpen->file_url)
    <button type="button" hidden
            data-preview-open
            data-preview-auto
            data-preview-slug="{{ $autoOpen->slug }}"
            data-preview-title="{{ $autoOpen->title }}"
            data-preview-kind="{{ $autoOpen->preview_kind }}"
            data-preview-src="{{ $autoOpen->file_url }}"></button>
@endif

@push('scripts')
<script>
(function () {
    var dialog = document.getElementById('ca-preview');
    if (!dialog) return;

    var body = document.getElementById('ca-preview-body');
    var title = document.getElementById('ca-preview-title');
    var note = document.getElementById('ca-preview-note');
    var download = document.getElementById('ca-preview-download');
    var closeBtn = document.getElementById('ca-preview-close');
    var syncUrl = dialog.getAttribute('data-sync-url') === '1';
    var lastTrigger = null;

    function el(tag, attrs) {
        var node = document.createElement(tag);
        Object.keys(attrs || {}).forEach(function (key) { node.setAttribute(key, attrs[key]); });
        return node;
    }

    function setNote(text) {
        note.textContent = text || '';
        note.hidden = !text;
    }

    function setUrl(slug) {
        if (!syncUrl || !window.history.replaceState) return;
        var url = new URL(window.location.href);
        if (slug) { url.searchParams.set('preview', slug); } else { url.searchParams.delete('preview'); }
        window.history.replaceState(null, '', url.toString());
    }

    function open(trigger) {
        var kind = trigger.getAttribute('data-preview-kind');
        var src = trigger.getAttribute('data-preview-src');
        var name = trigger.getAttribute('data-preview-title') || 'Preview';
        var absolute = new URL(src, window.location.href).href;

        lastTrigger = trigger.hasAttribute('data-preview-auto') ? null : trigger;
        title.textContent = name;
        download.href = src;
        body.innerHTML = '';
        body.className = 'ca-modal-body ca-modal-body--' + kind;
        setNote('');

        if (kind === 'pdf' || kind === 'text') {
            body.appendChild(el('iframe', { src: src, title: name }));
        } else if (kind === 'image') {
            body.appendChild(el('img', { src: src, alt: name }));
        } else if (kind === 'video') {
            body.appendChild(el('video', { src: src, controls: '', preload: 'metadata', playsinline: '' }));
        } else if (kind === 'audio') {
            body.appendChild(el('audio', { src: src, controls: '', preload: 'metadata' }));
        } else if (kind === 'office') {
            body.appendChild(el('iframe', {
                src: 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(absolute),
                title: name
            }));
            setNote('This preview is shown by the Microsoft Office online viewer. If it does not load, please use the Download button.');
        } else {
            var empty = el('p', { 'class': 'ca-modal-empty' });
            empty.textContent = 'A preview is not available for this file type. Please download it to view.';
            body.appendChild(empty);
        }

        if (typeof dialog.showModal === 'function') {
            dialog.showModal();
        } else {
            window.open(src, '_blank', 'noopener');
            return;
        }
        closeBtn.focus();
        setUrl(trigger.getAttribute('data-preview-slug'));
    }

    function close() {
        if (dialog.open) dialog.close();
    }

    dialog.addEventListener('close', function () {
        body.innerHTML = '';
        setUrl(null);
        if (lastTrigger) lastTrigger.focus();
    });

    closeBtn.addEventListener('click', close);

    // Click on the backdrop closes the dialog
    dialog.addEventListener('click', function (e) {
        if (e.target === dialog) close();
    });

    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('[data-preview-open]');
        if (!trigger) return;
        e.preventDefault();
        open(trigger);
    });

    var auto = document.querySelector('[data-preview-auto]');
    if (auto) open(auto);
})();
</script>
@endpush
