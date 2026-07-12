@props([
    'content' => ''
])

<div class="laravel-latex-rendered-content" style="box-sizing: border-box;">
    @once
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css">
    @endonce

    <div class="katex-render-target" style="line-height: 1.6;">
        {!! $content !!}
    </div>
</div>

@once
<script>
    // Robust, sequential KaTeX assets loader supporting multiple instances
    function loadKatexResourcesForRender(callback) {
        if (window.renderMathInElement && window.katex) {
            if (callback) callback();
            return;
        }

        // Load stylesheet if not already present
        const cssUrl = 'https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css';
        if (!document.querySelector(`link[href*="katex"]`)) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = cssUrl;
            document.head.appendChild(link);
        }

        // Initialize global loading queues
        window.katexLoadingQueue = window.katexLoadingQueue || [];
        if (callback) {
            window.katexLoadingQueue.push(callback);
        }

        if (window.katexLoadingStarted) {
            return;
        }
        window.katexLoadingStarted = true;

        function triggerQueue() {
            window.katexLoadingQueue.forEach(cb => {
                try { cb(); } catch(e) { console.error("Error executing KaTeX callback:", e); }
            });
            window.katexLoadingQueue = [];
        }

        // Load katex.min.js first, then auto-render.min.js
        const scriptKatex = document.createElement('script');
        scriptKatex.src = 'https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js';
        scriptKatex.async = true;
        scriptKatex.onload = function() {
            const scriptAuto = document.createElement('script');
            scriptAuto.src = 'https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/contrib/auto-render.min.js';
            scriptAuto.async = true;
            scriptAuto.onload = function() {
                triggerQueue();
            };
            document.head.appendChild(scriptAuto);
        };
        document.head.appendChild(scriptKatex);
    }

    function renderMathOnTargets() {
        const renderTargets = document.querySelectorAll('.katex-render-target');
        renderTargets.forEach(target => {
            if (window.renderMathInElement) {
                try {
                    window.renderMathInElement(target, {
                        delimiters: [
                            {left: '$$', right: '$$', display: true},
                            {left: '$', right: '$', display: false},
                            {left: '\\(', right: '\\)', display: false},
                            {left: '\\[', right: '\\]', display: true}
                        ],
                        throwOnError: false
                    });
                } catch (err) {
                    console.error("KaTeX rendering error:", err);
                }
            }
        });
    }

    function initLatexRender() {
        loadKatexResourcesForRender(renderMathOnTargets);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initLatexRender);
    } else {
        initLatexRender();
    }
</script>
@endonce
