<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Versi KaTeX CDN
    |--------------------------------------------------------------------------
    |
    | Menentukan versi KaTeX yang digunakan untuk merender matematika LaTeX.
    | Anda dapat mengubahnya ke versi terbaru atau ke file lokal jika offline.
    |
    */
    'katex_version' => '0.16.9',

    /*
    |--------------------------------------------------------------------------
    | Tema Visual & Math Toolbar
    |--------------------------------------------------------------------------
    |
    | Menentukan daftar simbol matematika default yang akan ditampilkan
    | di toolbar pembantu editor LaTeX.
    |
    */
    'default_symbols' => [
        'Akar & Pecahan' => ['\\frac{a}{b}', '\\sqrt{x}', '\\sqrt[n]{x}', 'x^{y}', 'x_{i}'],
        'Kalkulus' => ['\\int', '\\sum', '\\lim_{x \\to \\infty}', '\\frac{dy}{dx}'],
        'Simbol & Relasi' => ['\\pm', '\\neq', '\\le', '\\ge', '\\infty'],
        'Yunani' => ['\\alpha', '\\beta', '\\gamma', '\\pi', '\\theta', '\\Delta'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Integrasi Rich Text Editor
    |--------------------------------------------------------------------------
    |
    | Tipe editor bawaan: 'standard' (Textarea + Toolbar), 'ckeditor', atau 'tinymce'.
    |
    */
    'editor_type' => 'standard',
];
