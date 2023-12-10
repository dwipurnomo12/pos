
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# Aplikasi Point Of Sale


Aplikasi Point of Sale (POS) berbasis web Laravel adalah sebuah sistem yang digunakan oleh bisnis untuk mengelola transaksi penjualan. Aplikasi ini dibangun menggunakan framework PHP Laravel dan diakses melalui web browser, yang memungkinkan pengguna untuk mengaksesnya dari berbagai perangkat seperti komputer, tablet, atau ponsel cerdas. Berikut adalah beberapa fitur dan komponen utama yang dapat ada dalam aplikasi POS berbasis web Laravel:



# Fitur
1. Admin
- Master produk (Produk, Kategori, Supplier, Satuan)
- Set Diskon & PPn
- Karyawan
- Produk Masuk
- Produk Keluar
- Menu Penjualan / Kasir
- Stok Produk
- Laporan Produk Masuk
- Laporan Produk Keluar
- Laporan Penjualan
- Laporan  Arus Kas
- Laporan  Laba Kotor


2. Kasir
- Menu Penjualan / kasir


3. Kepala Toko / Owner Toko
- Set Diskon & PPn
- Produk Masuk
- Produk Keluar
- Menu Penjualan / Kasir
- Stok Produk
- Laporan Produk Masuk
- Laporan Produk Keluar
- Laporan Penjualan
- Laporan  Arus Kas
- Laporan  Laba Kotor



## Teknologi

Aplikasi Point of Sale dibangun menggunakan beberapa Teknologi diantaranya :

- Laravel - The PHP Framework for Web Artisans
- JavaScript - JavaScript, often abbreviated as JS, is a programming language that is one of the core technologies of the World Wide Web, alongside HTML and CSS.
- Bootstrap - Bootstrap is a free and open-source CSS framework directed at responsive, mobile-first front-end web development. 



## Installasi

Lakukan Clone Project/Unduh manual .

Aktifkan Xampp Control Panel, lalu akses ke http://localhost/phpmyadmin/.

Buat database dengan nama 'pos'.

Jika melakukan Clone Project, rename file .env.example dengan env dan hubungkan
database nya dengan mengisikan nama database, 'DB_DATABASE=pos'.


Kemudian, Ketik pada terminal :
```sh
php artisan migrate
```

Lalu ketik juga

```sh
php artisan migrate:fresh --seed
```

Jalankan aplikasi 

```sh
php artisan serve
```

Akses Aplikasi di Web browser 
```sh
127.0.0.1:8000
```

Demo Login :
1. Admin
    - email     : admin@gmail.com
    - password  : 1234
2. Kasir
    - email     : kasir@gmail.com
    - password  : 1111
3. Kepala Toko / Owner Toko
    - email     : abdul@gmail.com
    - password  : 1111


Demo Video : https://youtu.be/CCDemVVMzOo?si=ecQQt8N0JRhUfleV


## Screenshot
![Screenshot_1099](https://github.com/dwipurnomo12/pos/assets/105181667/2ed4208c-7805-497a-910f-e03e149226fb)
![Screenshot_1101](https://github.com/dwipurnomo12/pos/assets/105181667/72858818-04e7-4d6f-b774-d3bb613a4ecb)
![Screenshot_1102](https://github.com/dwipurnomo12/pos/assets/105181667/722f6595-b60f-486d-9013-131807b6e6e0)
![Screenshot_1104](https://github.com/dwipurnomo12/pos/assets/105181667/f85099dc-090b-4471-a646-5cafff417e12)
![Screenshot_1107](https://github.com/dwipurnomo12/pos/assets/105181667/e25fc019-b546-46a2-b863-74e96954b66d)


