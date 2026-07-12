@props([
    'name' => 'latex_content',
    'id' => 'latex_content',
    'value' => '',
    'label' => 'Input Matematika LaTeX',
    'placeholder' => 'Ketik soal Anda di sini, gunakan $...$ untuk inline math atau $$...$$ untuk display math...',
    'rows' => 6,
    'type' => null
])

@php
    $editorType = $type ?? config('latex-editor.editor_type', 'standard');
@endphp

<div class="laravel-latex-editor-container" style="font-family: sans-serif; margin-bottom: 1.5rem;">
    <!-- Memuat KaTeX CDN jika belum ada -->
    @once
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css">
        
        <style>
            .math-btn-item {
                background: #1e293b;
                color: #e2e8f0;
                border: 1px solid #334155;
                padding: 6px 10px;
                border-radius: 6px;
                font-family: monospace;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 40px;
                text-align: center;
            }
            .math-btn-item:hover {
                background: #0f172a;
                border-color: #38bdf8;
                color: #38bdf8;
                box-shadow: 0 0 8px rgba(56, 189, 248, 0.2);
            }
            .math-tab-btn {
                background: transparent;
                color: #94a3b8;
                border: none;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 11px;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.2s;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .math-tab-btn:hover {
                color: #e2e8f0;
                background: #1e293b;
            }
            .math-tab-btn.active {
                color: #38bdf8;
                background: #0f172a;
                border: 1px solid #334155;
            }
            /* High-end custom styling to keep CKEditor 5 matching our premium light-toolbar & dark-editor look */
            .laravel-latex-editor-container .ck.ck-editor {
                color: #cbd5e1 !important;
                background: #1e293b !important;
                border: 1px solid #334155 !important;
                border-radius: 8px !important;
                overflow: hidden !important;
            }
            .laravel-latex-editor-container .ck.ck-editor__main>.ck-editor__editable {
                background: #1e293b !important;
                color: #cbd5e1 !important;
                min-height: 200px;
                border: none !important;
                padding: 14px !important;
            }
            .laravel-latex-editor-container .ck.ck-editor__main>.ck-editor__editable.ck-focused {
                border: none !important;
                box-shadow: inset 0 0 0 2px #38bdf8 !important;
            }
            /* White/Light Toolbar */
            .laravel-latex-editor-container .ck.ck-toolbar {
                background: #ffffff !important;
                border: none !important;
                border-bottom: 1px solid #e2e8f0 !important;
                padding: 6px 12px !important;
            }
            .laravel-latex-editor-container .ck.ck-toolbar__items {
                gap: 4px !important;
            }
            /* Dark-colored buttons for high visibility on light toolbar */
            .laravel-latex-editor-container .ck.ck-button {
                color: #334155 !important;
                cursor: pointer !important;
                border-radius: 6px !important;
                transition: all 0.15s !important;
            }
            .laravel-latex-editor-container .ck.ck-button:hover {
                background: #f1f5f9 !important;
                color: #0f172a !important;
            }
            .laravel-latex-editor-container .ck.ck-button.ck-on {
                background: #e2e8f0 !important;
                color: #0284c7 !important;
            }
            .laravel-latex-editor-container .ck.ck-button .ck-icon {
                color: currentColor !important;
            }
            /* Light dropdown panels */
            .laravel-latex-editor-container .ck.ck-dropdown__panel {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            }
            .laravel-latex-editor-container .ck.ck-list {
                background: #ffffff !important;
            }
            .laravel-latex-editor-container .ck.ck-list__item {
                background: #ffffff !important;
            }
            .laravel-latex-editor-container .ck.ck-list__button {
                background: #ffffff !important;
                color: #334155 !important;
            }
            .laravel-latex-editor-container .ck.ck-list__button:hover {
                background: #f1f5f9 !important;
                color: #0f172a !important;
            }
            /* Toolbar separator */
            .laravel-latex-editor-container .ck.ck-toolbar__separator {
                background: #e2e8f0 !important;
            }
        </style>
    @endonce


    @if($label)
        <label for="{{ $id }}" style="display: block; font-size: 13px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
            {{ $label }}
        </label>
    @endif

    <div class="laravel-latex-editor-container" style="background: #1e293b; border: 1px solid #334155; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column;">
        <!-- Wrapper Panel Rumus (Selalu Terbuka agar Memudahkan Input LaTeX) -->
        <div id="latex_panel_{{ $id }}" style="border-bottom: 1px solid #334155;">
            <!-- Kategori Tabs -->
            <div class="math-tabs-header" style="background: #0f172a; border-bottom: 1px solid #334155; padding: 8px 12px; display: flex; flex-wrap: wrap; gap: 4px;">
                <button type="button" class="math-tab-btn active" data-editor="{{ $id }}" data-tab="pecahan" onclick="switchMathTab('{{ $id }}', 'pecahan', this)">Pecahan & Akar</button>
                <button type="button" class="math-tab-btn" data-editor="{{ $id }}" data-tab="kalkulus" onclick="switchMathTab('{{ $id }}', 'kalkulus', this)">Kalkulus</button>
                <button type="button" class="math-tab-btn" data-editor="{{ $id }}" data-tab="matriks" onclick="switchMathTab('{{ $id }}', 'matriks', this)">Matriks & Kurung</button>
                <button type="button" class="math-tab-btn" data-editor="{{ $id }}" data-tab="simbol" onclick="switchMathTab('{{ $id }}', 'simbol', this)">Simbol & Relasi</button>
                <button type="button" class="math-tab-btn" data-editor="{{ $id }}" data-tab="yunani" onclick="switchMathTab('{{ $id }}', 'yunani', this)">Huruf Yunani</button>
            </div>

            <!-- Toolbar Matematika Konten -->
            <div style="background: #0b0f19; padding: 12px; border-bottom: 1px solid #334155; min-height: 52px;">
                <!-- Tab Pecahan -->
                <div id="{{ $id }}_tab_pecahan" class="math-tab-content-group-{{ $id }}" style="display: flex; flex-wrap: wrap; gap: 6px;">
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\frac{a}{b}')" title="Pecahan">\frac{a}{b}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\sqrt{x}')" title="Akar Kuadrat">\sqrt{x}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\sqrt[n]{x}')" title="Akar pangkat n">\sqrt[n]{x}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', 'x^{y}')" title="Pangkat">x^y</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', 'x_{i}')" title="Subskrip">x_i</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\log_{a}{x}')" title="Logaritma">\log_a{x}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\vec{x}')" title="Vektor">\vec{x}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\bar{x}')" title="Mean / Garis Atas">\bar{x}</button>
                </div>

                <!-- Tab Kalkulus -->
                <div id="{{ $id }}_tab_kalkulus" class="math-tab-content-group-{{ $id }}" style="display: none; flex-wrap: wrap; gap: 6px;">
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\int_{a}^{b} x \\, dx')" title="Integral Tentu">\int_{a}^{b}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\int x \\, dx')" title="Integral Tak Tentu">\int</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\sum_{i=1}^{n} x')" title="Sumasi (Penjumlahan)">\sum</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\lim_{x \\to a}')" title="Limit">\lim_{x \to a}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\frac{dy}{dx}')" title="Turunan">\frac{dy}{dx}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\partial')" title="Turunan Parsial">\partial</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\iint')" title="Double Integral">\iint</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\infty')" title="Tak Hingga">\infty</button>
                </div>

                <!-- Tab Matriks -->
                <div id="{{ $id }}_tab_matriks" class="math-tab-content-group-{{ $id }}" style="display: none; flex-wrap: wrap; gap: 6px;">
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\begin{matrix} a & b \\\\ c & d \\end{matrix}')" title="Matriks Standar">Matriks</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\begin{pmatrix} a & b \\\\ c & d \\end{pmatrix}')" title="Matriks Kurung Bulat">Matriks ()</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\begin{bmatrix} a & b \\\\ c & d \\end{bmatrix}')" title="Matriks Kurung Siku">Matriks []</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\left( x \\right)')" title="Kurung Bulat Dinamis">(\cdot)</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\left[ x \\right]')" title="Kurung Siku Dinamis">[\cdot]</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\left\\{ x \\right\\}')" title="Kurung Kurawal Dinamis">\{\cdot\}</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\det(A)')" title="Determinan">\det</button>
                </div>

                <!-- Tab Simbol -->
                <div id="{{ $id }}_tab_simbol" class="math-tab-content-group-{{ $id }}" style="display: none; flex-wrap: wrap; gap: 6px;">
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\pm')" title="Kurang Lebih">±</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\neq')" title="Tidak Sama Dengan">≠</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\le')" title="Kurang Dari Sama Dengan">≤</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\ge')" title="Lebih Dari Sama Dengan">≥</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\times')" title="Perkalian">×</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\div')" title="Pembagian">÷</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\approx')" title="Mendekati">≈</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\implies')" title="Implikasi">⇒</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\iff')" title="Biimplikasi">⇔</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\forall')" title="Untuk Semua">∀</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\exists')" title="Terdapat">∃</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\in')" title="Anggota Dari">∈</button>
                </div>

                <!-- Tab Yunani -->
                <div id="{{ $id }}_tab_yunani" class="math-tab-content-group-{{ $id }}" style="display: none; flex-wrap: wrap; gap: 6px;">
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\alpha')" title="Alpha">α</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\beta')" title="Beta">β</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\gamma')" title="Gamma">γ</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\pi')" title="Pi">π</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\theta')" title="Theta">θ</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\Delta')" title="Delta">Δ</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\sigma')" title="Sigma">σ</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\mu')" title="Mu">μ</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\lambda')" title="Lambda">λ</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\omega')" title="Omega">ω</button>
                    <button type="button" class="math-btn-item" onclick="insertLatexAtCursor('{{ $id }}', '\\phi')" title="Phi">φ</button>
                </div>
            </div>
        </div>

        @if($editorType === 'ckeditor')
            <!-- Hidden input to submit the form data -->
            <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}">
            <!-- Editor target div instead of textarea to isolate from global script selectors -->
            <div 
                id="{{ $id }}_editor" 
                style="width: 100%; background: #1e293b; color: #cbd5e1; min-height: 200px; outline: none; padding: 14px; box-sizing: border-box;"
            >{!! $value !!}</div>
        @else
            <!-- Textarea Input -->
            <textarea 
                name="{{ $name }}" 
                id="{{ $id }}" 
                rows="{{ $rows }}"
                placeholder="{{ $placeholder }}"
                style="width: 100%; border: none; outline: none; background: #1e293b; color: #f8fafc; padding: 14px; font-size: 14px; line-height: 1.6; resize: vertical; box-sizing: border-box;"
                oninput="renderLatexPreview('{{ $id }}', '{{ $id }}_preview')"
            >{{ $value }}</textarea>
        @endif

        <!-- Live Preview Area -->
        <div style="background: #0f172a; border-top: 1px solid #334155; padding: 14px;">
            <div style="font-size: 10px; color: #64748b; font-weight: bold; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.05em;">
                Pratinjau Hasil KaTeX Instan:
            </div>
            <div id="{{ $id }}_preview" class="latex-editor-preview" data-editor-type="{{ $editorType }}" style="min-height: 40px; background: #ffffff; color: #0f172a; border-radius: 8px; padding: 12px; font-size: 14px; overflow-x: auto; box-sizing: border-box;">
                {{ $value ?: 'Ketik rumus di atas...' }}
            </div>
        </div>
    </div>
</div>

@once
<script>
    // Robust, sequential KaTeX assets loader supporting multiple instances
    function loadKatexResources(callback) {
        if (window.renderMathInElement && window.katex) {
            if (callback) callback();
            return;
        }

        // 1. Load stylesheet if not already present
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

        // 2. Load katex.min.js first, then auto-render.min.js
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

    function switchMathTab(editorId, tabId, clickedBtn) {
        // Hide all tab contents for this specific editor
        const contents = document.querySelectorAll('.math-tab-content-group-' + editorId);
        contents.forEach(content => {
            content.style.display = 'none';
        });

        // Show target tab content
        const activeContent = document.getElementById(editorId + '_tab_' + tabId);
        if (activeContent) {
            activeContent.style.display = 'flex';
        }

        // Deactivate all tab buttons for this editor
        const parentHeader = clickedBtn.parentElement;
        const buttons = parentHeader.querySelectorAll('.math-tab-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active');
        });

        // Activate clicked button
        clickedBtn.classList.add('active');
    }

    function insertLatexAtCursor(textareaId, latexStr) {
        const editorInstance = window['editor_' + textareaId];
        if (editorInstance) {
            // CKEditor 5
            const wrappedLatex = " $" + latexStr + "$ ";
            editorInstance.model.change(writer => {
                const textNode = writer.createText(wrappedLatex);
                editorInstance.model.insertContent(textNode);
            });
            
            // Return focus to the editor so the user can continue typing and cursor updates correctly
            try {
                editorInstance.editing.view.focus();
            } catch (e) {
                console.warn("Could not focus CKEditor:", e);
            }
            
            // Update preview
            renderEditorPreview(textareaId, editorInstance.getData());
            return;
        }

        const tinymceInstance = window.tinymce && window.tinymce.get(textareaId);
        if (tinymceInstance) {
            // TinyMCE
            const wrappedLatex = " $" + latexStr + "$ ";
            tinymceInstance.insertContent(wrappedLatex);
            // Update preview
            renderEditorPreview(textareaId, tinymceInstance.getContent());
            return;
        }

        // Standard Textarea
        const txtarea = document.getElementById(textareaId);
        if (!txtarea) return;

        const scrollPos = txtarea.scrollTop;
        let strPos = txtarea.selectionStart;
        const endPos = txtarea.selectionEnd;

        const front = (txtarea.value).substring(0, strPos);
        const back = (txtarea.value).substring(endPos, txtarea.value.length);
        
        const wrappedLatex = " $" + latexStr + "$ ";
        txtarea.value = front + wrappedLatex + back;
        
        strPos = strPos + wrappedLatex.length;
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
        txtarea.scrollTop = scrollPos;
        
        // Trigger live preview render
        renderLatexPreview(textareaId, textareaId + '_preview');
    }

    function renderEditorPreview(textareaId, htmlContent) {
        const previewDiv = document.getElementById(textareaId + '_preview');
        if (!previewDiv) return;

        previewDiv.innerHTML = htmlContent || 'Ketik rumus di atas...';
        
        if (window.renderMathInElement) {
            try {
                window.renderMathInElement(previewDiv, {
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
    }

    function renderLatexPreview(textareaId, previewId) {
        const txtarea = document.getElementById(textareaId);
        const previewDiv = document.getElementById(previewId);
        if (!txtarea || !previewDiv) return;

        let content = txtarea.value || 'Ketik rumus di atas...';
        
        // Replace custom HTML tags if any to prevent script injection
        previewDiv.innerText = content;
        
        // Render math via KaTeX
        if (window.renderMathInElement) {
            try {
                window.renderMathInElement(previewDiv, {
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
        } else {
            // KaTeX not loaded yet, initiate dynamic sequential load
            loadKatexResources(function() {
                renderLatexPreview(textareaId, previewId);
            });
        }
    }

    // Dynamic resource loader for editors to handle asynchronous/CDN delays
    function loadEditorResources(editorType, callback) {
        if (editorType === 'ckeditor') {
            if (window.LatexClassicEditor) {
                callback();
                return;
            }
            
            // Backup any existing ClassicEditor loaded on the page
            const backupClassicEditor = window.ClassicEditor;
            
            // Check if our specific script tag is already in the document
            let script = document.getElementById('latex-ckeditor-script') || document.querySelector('script[src*="ckeditor5/39.0.1"]');
            if (!script) {
                script = document.createElement('script');
                script.id = 'latex-ckeditor-script';
                script.src = 'https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js';
                document.head.appendChild(script);
            }
            
            const handleScriptLoaded = function() {
                if (window.ClassicEditor && !window.LatexClassicEditor) {
                    // Assign our newly loaded editor to window.LatexClassicEditor
                    window.LatexClassicEditor = window.ClassicEditor;
                    
                    // Safely restore the user's original ClassicEditor so their layout forms never break
                    if (backupClassicEditor) {
                        window.ClassicEditor = backupClassicEditor;
                    } else {
                        try {
                            delete window.ClassicEditor;
                        } catch(e) {
                            window.ClassicEditor = undefined;
                        }
                    }
                }
                callback();
            };
            
            script.addEventListener('load', handleScriptLoaded);
            
            // Polling backup
            let attempts = 0;
            const interval = setInterval(() => {
                attempts++;
                if (window.ClassicEditor && window.ClassicEditor !== backupClassicEditor) {
                    clearInterval(interval);
                    handleScriptLoaded();
                } else if (attempts > 50) {
                    clearInterval(interval);
                    if (window.ClassicEditor || window.LatexClassicEditor) {
                        handleScriptLoaded();
                    }
                }
            }, 100);
            
        } else if (editorType === 'tinymce') {
            if (window.tinymce) {
                callback();
                return;
            }
            
            let script = document.querySelector('script[src*="tinymce.min.js"]');
            if (!script) {
                script = document.createElement('script');
                script.src = 'https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js';
                script.referrerPolicy = 'origin';
                document.head.appendChild(script);
            }
            
            script.addEventListener('load', callback);
            
            let attempts = 0;
            const interval = setInterval(() => {
                attempts++;
                if (window.tinymce) {
                    clearInterval(interval);
                    callback();
                } else if (attempts > 50) {
                    clearInterval(interval);
                }
            }, 100);
            
        } else {
            callback();
        }
    }

    // Initial render on load
    function initLatexEditors() {
        loadKatexResources(function() {
            const previews = document.querySelectorAll('.latex-editor-preview');
            
            previews.forEach(preview => {
                const id = preview.id.replace('_preview', '');
                const editorType = preview.getAttribute('data-editor-type') || 'textarea';
                
                loadEditorResources(editorType, function() {
                    if (editorType === 'ckeditor') {
                        const activeClassicEditor = window.LatexClassicEditor || window.ClassicEditor;
                        if (!activeClassicEditor) return;
                        if (window['editor_' + id]) return; // Avoid double initialization
                        
                        const element = document.getElementById(id + '_editor');
                        if (!element) return;
                        
                        activeClassicEditor
                            .create(element, {
                                placeholder: 'Ketik di sini... Gunakan panel rumus di atas untuk memasukkan simbol matematika.'
                            })
                            .then(editor => {
                                window['editor_' + id] = editor;
                                
                                // Set initial preview
                                renderEditorPreview(id, editor.getData());
                                
                                // Listen to changes
                                editor.model.document.on('change:data', () => {
                                    const data = editor.getData();
                                    renderEditorPreview(id, data);
                                    // Keep hidden input synchronized
                                    const hiddenInput = document.getElementById(id);
                                    if (hiddenInput) {
                                        hiddenInput.value = data;
                                        // Trigger change event for any reactive forms or handlers
                                        const event = new Event('change', { bubbles: true });
                                        hiddenInput.dispatchEvent(event);
                                    }
                                });
                            })
                            .catch(err => console.error("Error loading CKEditor:", err));
                    } else if (editorType === 'tinymce' && window.tinymce) {
                        if (window.tinymce.get(id)) return; // Avoid double initialization
                        
                        window.tinymce.init({
                            selector: '#' + id,
                            height: 250,
                            menubar: false,
                            plugins: 'lists link code table',
                            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | code',
                            setup: function (editor) {
                                editor.on('init', function () {
                                    renderEditorPreview(id, editor.getContent());
                                });
                                editor.on('change keyup input', function () {
                                    renderEditorPreview(id, editor.getContent());
                                    // Keep textarea values perfectly synchronized for traditional forms
                                    const element = document.getElementById(id);
                                    if (element) element.value = editor.getContent();
                                });
                            }
                        });
                    } else {
                        renderLatexPreview(id, preview.id);
                    }
                });
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initLatexEditors);
    } else {
        initLatexEditors();
    }
</script>
@endonce
