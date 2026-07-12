# Laravel LaTeX Math Editor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nohara/laravel-latex-editor.svg?style=flat-square)](https://packagist.org/packages/nohara/laravel-latex-editor)
[![Total Downloads](https://img.shields.io/packagist/dt/nohara/laravel-latex-editor.svg?style=flat-square)](https://packagist.org/packages/nohara/laravel-latex-editor)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Pustaka input matematika LaTeX mandiri yang interaktif sebagai pengganti **Wiris** & **CKEditor berbayar (MathType)** untuk aplikasi Laravel Anda. 100% bebas biaya lisensi, open-source, dan sangat mudah diintegrasikan.

---

## 🌟 Fitur Utama

- **Bebas Biaya Lisensi (100% Free)**: Menggantikan solusi MathType / Wiris premium tanpa memerlukan lisensi berbayar bulanan atau tahunan.
- **Asynchronous CDN Loader**: Memuat sumber daya CKEditor, TinyMCE, KaTeX, dan MathJax secara dinamis hanya saat dibutuhkan untuk menjaga kecepatan pemuatan halaman awal tetap optimal.
- **Light Theme Toolbar**: Desain toolbar modern berwarna putih bersih dengan tingkat kontras tinggi, sangat serasi dengan dashboard form modern (seperti Bootstrap, Tailwind, atau admin template apa pun).
- **Math Assistant Panel**: Menyediakan panel pop-up interaktif berisi simbol-simbol matematika populer (pecahan, akar, integral, matriks, limit, dll.) yang dapat disisipkan ke editor hanya dengan sekali klik.
- **Instant Live KaTeX Preview**: Siswa dan pengajar dapat langsung melihat visualisasi rumus LaTeX mereka di bawah editor saat mereka mengetik secara real-time.
- **Isolasi Script Aman**: Desain inisialisasi editor tidak bentrok dengan pustaka global (seperti `ClassicEditor` milik CKEditor bawaan template utama) melalui sistem wrapper `LatexClassicEditor`.

---

## 🚀 Cara Pemasangan

### 1. Install via Composer
Jalankan perintah berikut di direktori root aplikasi Laravel Anda:

```bash
composer require nohara/laravel-latex-editor
```

### 2. Publish Konfigurasi & Aset (Opsional)
Jika Anda ingin memodifikasi konfigurasi bawaan, jalankan perintah publish:

```bash
php artisan vendor:publish --tag=laravel-latex-editor-config
```

---

## 💻 Penggunaan (Blade Component)

Paket ini menyediakan komponen Blade `<x-latex-editor />` yang siap pakai di form mana saja:

### Menggunakan CKEditor (Sangat Direkomendasikan)
```html
<div class="mb-3">
    <label class="form-label">Catatan / Matematika</label>
    <x-latex-editor 
        name="catatan" 
        id="catatan-matematika" 
        type="ckeditor" 
        value="{!! old('catatan', $dosen->catatan ?? '') !!}" 
    />
</div>
```

### Menggunakan TinyMCE Bawaan
```html
<x-latex-editor 
    name="catatan" 
    id="catatan-tinymce" 
    type="tinymce" 
    value="{!! $value !!}" 
/>
```

### Menggunakan Textarea Sederhana (Dengan KaTeX Live Preview)
```html
<x-latex-editor 
    name="catatan" 
    id="catatan-textarea" 
    type="textarea" 
    value="{{ $value }}" 
/>
```

---

## 🛠️ Parameter Atribut Komponen

| Atribut | Tipe Data | Nilai Bawaan | Deskripsi |
| :--- | :--- | :--- | :--- |
| `name` | `string` | *Wajib* | Nama input yang dikirimkan melalui form POST. |
| `id` | `string` | *Wajib* | ID HTML unik untuk elemen input dan previewer. |
| `type` | `string` | `'ckeditor'` | Tipe editor yang digunakan: `'ckeditor'`, `'tinymce'`, atau `'textarea'`. |
| `value` | `string` | `''` | Nilai default dari isi editor (aman dari XSS & html-tags). |
| `placeholder` | `string` | `'Ketik di sini...'` | Teks panduan awal dalam area editor. |
| `rows` | `int` | `4` | Tinggi default textarea jika menggunakan tipe `'textarea'`. |
| `label` | `string` | `null` | Label teks di atas komponen editor (opsional). |

---

## 📄 Lisensi

Proyek ini berada di bawah lisensi **MIT**. Anda bebas menggunakan, memodifikasi, dan mendistribusikan ulang paket ini untuk kebutuhan personal maupun komersial di institusi pendidikan Anda.

