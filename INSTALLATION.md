# Instalasi dan Setup Plugin ACF/SCF Accordion for Elementor

## Panduan Instalasi

### 1. Upload Plugin

1. Download atau clone repository ini
2. Upload folder `accordion-acf-elementor` ke direktori `/wp-content/plugins/` 
3. Atau zip folder dan upload melalui admin WordPress: **Plugins** → **Add New** → **Upload Plugin**

### 2. Aktivasi Plugin

1. Masuk ke WordPress Admin
2. Pergi ke **Plugins** → **Installed Plugins**
3. Cari "ACF/SCF Accordion for Elementor" 
4. Klik **Activate**

### 3. Verifikasi Dependencies

Plugin akan otomatis mengecek dependencies yang diperlukan:

- ✅ **Elementor** (versi 3.0.0+)
- ✅ **Advanced Custom Fields (ACF)** ATAU **Secure Custom Fields (SCF)**

Jika ada dependency yang missing, akan muncul notice di admin.

## Setup Custom Fields

### Opsi 1: Setup ACF Field

#### 1. Buat Field Group Baru

1. Pergi ke **Custom Fields** → **Field Groups**
2. Klik **Add New**
3. Beri nama: "Accordion FAQ" (atau sesuai kebutuhan)

#### 2. Tambah Repeater Field

1. Klik **Add Field**
2. **Field Label**: Accordion Items
3. **Field Name**: `accordion_items` 
4. **Field Type**: Repeater

#### 3. Tambah Sub Fields

Di dalam Repeater, tambahkan 2 sub fields:

**Sub Field 1 - Title:**
- **Field Label**: Title
- **Field Name**: `title`
- **Field Type**: Text

**Sub Field 2 - Content:**
- **Field Label**: Content  
- **Field Name**: `content`
- **Field Type**: Textarea atau WYSIWYG Editor

### Opsi 2: Setup SCF Field

#### 1. Install SCF Plugin

1. Pergi ke **Plugins** → **Add New**
2. Cari "Secure Custom Fields"
3. Install dan aktifkan plugin

#### 2. Buat Field Group Baru

1. Pergi ke **SCF** → **Field Groups**
2. Klik **Add New**
3. Beri nama: "Accordion FAQ"

#### 3. Tambah Repeater Field

1. Klik **Add Field**
2. **Field Label**: Accordion Items
3. **Field Name**: `accordion_items`
4. **Field Type**: Repeater

#### 4. Tambah Sub Fields

Di dalam Repeater, tambahkan 2 sub fields:

**Sub Field 1 - Title:**
- **Field Label**: Title
- **Field Name**: `title`
- **Field Type**: Text

**Sub Field 2 - Content:**
- **Field Label**: Content
- **Field Name**: `content`
- **Field Type**: Textarea

### 4. Set Location Rules (ACF & SCF)

Pilih dimana field ini akan muncul:
- **Post Type** is equal to **Page**
- Atau **Post Type** is equal to **Post**
- Atau sesuai kebutuhan

### 5. Simpan Field Group

Klik **Publish** untuk menyimpan.

## Menggunakan Widget di Elementor

### 1. Edit Page dengan Elementor

1. Buat atau edit page/post
2. Klik **Edit with Elementor**

### 2. Tambah Widget

1. Di panel kiri, cari widget **"ACF/SCF Accordion"**
2. Drag ke area yang diinginkan

### 3. Konfigurasi Widget

**Tab Content:**
- **Repeater Field Name**: `accordion_items`
- **Title Sub Field Name**: `title`  
- **Content Sub Field Name**: `content`
- **Post ID**: Kosongkan (untuk post saat ini)
- **Open First Item**: Toggle sesuai kebutuhan
- **Allow Multiple Open**: Toggle sesuai kebutuhan

**Tab Style:**
- Sesuaikan styling accordion, title, content, dan icon
- Semua bisa dikustomisasi melalui Elementor

### 4. Preview dan Publish

1. Klik **Preview** untuk melihat hasil
2. Jika sudah sesuai, klik **Publish**

## Contoh Data

Untuk testing, isi data field seperti ini:

**Item 1:**
- Title: "Apa itu WordPress?"
- Content: "WordPress adalah sistem manajemen konten (CMS) yang populer untuk membuat website."

**Item 2:**  
- Title: "Bagaimana cara install plugin?"
- Content: "Anda bisa install plugin melalui admin WordPress di menu Plugins > Add New."

**Item 3:**
- Title: "Apa keuntungan menggunakan Elementor?"
- Content: "Elementor memungkinkan Anda membuat halaman dengan drag & drop tanpa coding."

## Tips Penggunaan

### Plugin Compatibility
- Plugin ini kompatibel dengan ACF Free, ACF Pro, dan SCF
- Secara otomatis mendeteksi plugin mana yang aktif
- Menggunakan function yang sesuai untuk mengambil data

### Multiple Accordion di Satu Page

Anda bisa menambahkan beberapa widget accordion di satu halaman dengan field yang berbeda.

### Custom Post Types

Widget bisa digunakan untuk custom post types, pastikan ACF field sudah di-assign ke post type tersebut.

### Styling Lanjutan

Gunakan **Additional CSS** di Customizer atau child theme untuk styling yang lebih spesifik:

```css
/* Custom styling untuk accordion */
.my-custom-accordion .acf-accordion-title {
    background: #your-color;
}
```

### Menggunakan dengan PHP

Anda juga bisa menampilkan accordion secara programmatik:

```php
// Di template file
if (function_exists('get_field')) {
    $accordion_items = get_field('accordion_items');
    // Render manual atau gunakan shortcode
}
```

## Troubleshooting

### Widget tidak muncul
- Pastikan Elementor dan ACF sudah aktif
- Clear cache Elementor
- Refresh halaman editor

### Data tidak tampil  
- Cek nama field sudah benar (ACF/SCF)
- Pastikan data sudah di-save di post/page
- Cek Post ID jika menggunakan ID khusus
- Pastikan plugin custom fields (ACF/SCF) aktif

### Styling bermasalah
- Cek apakah tema tidak override CSS
- Gunakan browser inspector untuk debug
- Tambahkan `!important` jika perlu

## Support

Jika mengalami masalah:
1. Cek versi WordPress, Elementor, dan ACF/SCF
2. Test dengan tema default (Twenty Twenty-Three)
3. Disable plugin lain untuk test conflict
4. Pastikan hanya satu plugin custom fields yang aktif (ACF atau SCF)
5. Hubungi developer jika masih ada issue
