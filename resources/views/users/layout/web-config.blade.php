
    <div class="floating-buttons">
        <button class="floating-btn back-to-top" onclick="topFunction()" title="Back to top" aria-label="Back to top">
            <i class="bi bi-arrow-up"></i>
        </button>

        <div class="btn-group">
            @if (!empty($config->facebook_url))
                <a href="{{ $config->facebook_url }}" target="_blank" class="floating-btn sub-btn" title="Facebook">
                    <i class="bi bi-facebook"></i>
                </a>
            @endif
            @if (!empty($config->zalo_url))
                <a href="{{ $config->zalo_url }}" target="_blank" class="floating-btn sub-btn" title="Zalo">
                    <i class="bi bi-chat-dots"></i>
                </a>
            @endif
            @if (!empty($config->hotline))
                <a href="tel:{{ $config->hotline }}" class="floating-btn sub-btn" title="Hotline">
                    <i class="bi bi-telephone"></i>
                </a>
            @endif
            @if (!empty($config->email))
                <a href="mailto:{{ $config->email }}" class="floating-btn sub-btn" title="Email">
                    <i class="bi bi-envelope"></i>
                </a>
            @endif
            <div class="floating-btn main-btn" id="mainBtn" aria-label="Toggle menu"><i class="bi bi-plus-lg"></i>
            </div>
        </div>
    </div>
