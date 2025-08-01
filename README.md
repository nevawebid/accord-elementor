# ACF/SCF Accordion for Elementor

Plugin WordPress yang memungkinkan Anda menampilkan data dari ACF (Advanced Custom Fields) atau SCF (Secure Custom Fields) Repeater dalam format accordion menggunakan Elementor widget.

## Deskripsi

Plugin ini menyediakan widget Elementor khusus yang dapat mengambil data dari ACF atau SCF Repeater field dan menampilkannya dalam format accordion yang responsif dan dapat dikustomisasi.

## Fitur

- ✅ Integrasi penuh dengan ACF dan SCF Repeater fields
- ✅ Widget Elementor yang mudah digunakan
- ✅ Styling yang dapat dikustomisasi melalui Elementor
- ✅ Opsi untuk membuka item pertama secara default
- ✅ Opsi untuk mengizinkan beberapa item terbuka bersamaan
- ✅ Responsif dan mobile-friendly
- ✅ Accessibility support (keyboard navigation, ARIA attributes)
- ✅ Animasi smooth dan modern
- ✅ Support untuk post ID khusus
- ✅ JavaScript API untuk kontrol programatik
- ✅ Dukungan ACF dan SCF (Secure Custom Fields)

## Persyaratan Sistem

- WordPress 5.0 atau lebih baru
- PHP 7.4 atau lebih baru
- Elementor 3.0.0 atau lebih baru
- Advanced Custom Fields (ACF) plugin ATAU Secure Custom Fields (SCF) plugin

## Instalasi

1. Upload folder plugin ke direktori `/wp-content/plugins/`
2. Aktifkan plugin melalui menu 'Plugins' di WordPress admin
3. Pastikan Elementor dan ACF/SCF sudah terinstall dan aktif

## Cara Penggunaan

### 1. Setup Repeater Field (ACF atau SCF)

**Untuk ACF:**
Buat ACF Field Group dengan Repeater field yang berisi:
- Sub field untuk judul (text field)
- Sub field untuk konten (textarea/wysiwyg field)

**Untuk SCF:**
Buat SCF Field Group dengan Repeater field yang berisi:
- Sub field untuk judul (text field)  
- Sub field untuk konten (textarea/wysiwyg field)

Contoh struktur:
```
Field Group: FAQ
- Field Type: Repeater
- Field Name: accordion_items
  Sub Fields:
  - title (Text)
  - content (Textarea/WYSIWYG)
```

### 2. Menggunakan Widget di Elementor

1. Edit halaman dengan Elementor
2. Cari widget "ACF/SCF Accordion" di panel widgets
3. Drag widget ke area yang diinginkan
4. Konfigurasi pengaturan:
   - **Repeater Field Name**: Nama field repeater ACF/SCF (contoh: `accordion_items`)
   - **Title Sub Field Name**: Nama sub field untuk judul (contoh: `title`)
   - **Content Sub Field Name**: Nama sub field untuk konten (contoh: `content`)
   - **Post ID**: Kosongkan untuk post saat ini, atau masukkan ID post tertentu
   - **Open First Item**: Aktifkan untuk membuka item pertama secara default
   - **Allow Multiple Open**: Aktifkan untuk mengizinkan beberapa item terbuka bersamaan

### 3. Styling

Widget menyediakan berbagai opsi styling melalui Elementor:

#### Accordion Settings
- Jarak antar item
- Border dan border radius
- Box shadow

#### Title Settings
- Typography
- Warna (normal, hover, active)
- Background color
- Padding

#### Content Settings
- Typography
- Warna teks dan background
- Padding
- Border

#### Icon Settings
- Ukuran icon
- Warna icon
- Jarak dari teks

## JavaScript API

Plugin menyediakan JavaScript API untuk kontrol programatik:

```javascript
// Membuka item accordion tertentu
ACFAccordion.open('.acf-accordion-item:first');

// Menutup item accordion tertentu
ACFAccordion.close('.acf-accordion-item:first');

// Toggle item accordion
ACFAccordion.toggle('.acf-accordion-item:first');

// Membuka semua item (hanya jika multiple diaktifkan)
ACFAccordion.openAll('.acf-accordion-wrapper');

// Menutup semua item
ACFAccordion.closeAll('.acf-accordion-wrapper');
```

## Events

Widget memicu custom events yang bisa didengarkan:

```javascript
$('.acf-accordion-item').on('acf-accordion:opened', function() {
    console.log('Accordion item opened');
});

$('.acf-accordion-item').on('acf-accordion:closed', function() {
    console.log('Accordion item closed');
});
```

## Troubleshooting

### Widget tidak muncul di Elementor
- Pastikan plugin sudah aktif
- Pastikan Elementor dan ACF sudah terinstall dan aktif
- Cek versi minimum yang diperlukan

### Data tidak muncul
- Pastikan nama field ACF benar
- Pastikan data ACF sudah tersimpan untuk post/page yang dimaksud
- Cek apakah Post ID sudah benar (kosongkan untuk post saat ini)

### Styling tidak sesuai
- Gunakan CSS custom jika diperlukan
- Cek apakah tema tidak override styling
- Gunakan inspector browser untuk debug CSS

## Hooks dan Filters

Plugin menyediakan beberapa hooks untuk developer:

```php
// Filter untuk memodifikasi data accordion sebelum ditampilkan
add_filter('acf_accordion_items', function($items, $settings) {
    // Modifikasi $items sesuai kebutuhan
    return $items;
}, 10, 2);

// Action setelah accordion dirender
add_action('acf_accordion_after_render', function($settings) {
    // Kode tambahan setelah render
});
```

## Changelog

### 1.0.0
- Rilis pertama
- Widget dasar ACF Accordion
- Styling dan kontrol Elementor
- JavaScript API
- Accessibility support

## Support

Untuk pertanyaan atau bantuan, silakan:
1. Buat issue di repository GitHub
2. Hubungi developer melalui email
3. Cek dokumentasi WordPress.org

## Kontribusi

Kontribusi sangat diterima! Silakan:
1. Fork repository
2. Buat branch untuk fitur baru
3. Submit pull request

## Lisensi

GPL v2 atau yang lebih baru. Lihat [LICENSE](LICENSE) untuk detail lengkap.

## Credits

Dikembangkan dengan ❤️ menggunakan:
- [WordPress](https://wordpress.org/)
- [Elementor](https://elementor.com/)
- [Advanced Custom Fields](https://www.advancedcustomfields.com/)
