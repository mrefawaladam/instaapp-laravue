# 📸 InstaApp — Mini Instagram Clone

InstaApp adalah aplikasi sosial media sederhana di mana pengguna bisa posting gambar, like, dan berkomentar, dibangun menggunakan **Laravel + Inertia.js + Vue.js**.

## ✨ Fitur

-   Autentikasi User (Login/Register)
-   Membuat, Melihat, Like, dan Komentar pada Postingan
-   Like dan Unlike Postingan
-   Tambah, Edit, dan Hapus Komentar
-   Responsive Design dengan TailwindCSS
-   Struktur kode bersih menggunakan Controller, Service, Repository terpisah

---

## ⚙️ Requirements

-   PHP 8.1+
-   Composer
-   Node.js & npm
-   MySQL / PostgreSQL
-   Laravel 10+
-   Inertia.js (Vue 3 Version)

---

## 🚀 Instalasi

1. **Clone Repository**

```bash
git clone https://github.com/mrefawaladam/instaapp-laravue
cd instaapp-laravue
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install frontend dependencies**

```bash
npm install
```

4. **Copy file `.env`**

```bash
cp .env.example .env
```

5. **Setting database di `.env`**

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=instaapp
DB_USERNAME=root
DB_PASSWORD=
```

6. **Generate key dan migrate database**

```bash
php artisan key:generate
php artisan migrate
```

7. **Build assets frontend**

```bash
npm run dev
```

8. **Run local server**

```bash
php artisan serve
```

Buka [http://localhost:8000](http://localhost:8000) di browser untuk melihat aplikasi.

---

## 📦 Struktur Project

```
app/
    Http/
        Controllers/
            PostController.php
            CommentController.php
            LikeController.php
    Models/
        Post.php
        Comment.php
        Like.php
    Services/
        PostService.php
        CommentService.php
        LikeService.php
    Repositories/
        PostRepository.php
        CommentRepository.php
        LikeRepository.php
resources/
    js/
        Pages/
            Feed.vue
            Posts/
                Create.vue
routes/
    web.php
```

---

## 🛠️ Tech Stack

-   Backend: Laravel 10, PHP 8.1+
-   Frontend: Vue 3, Inertia.js, TailwindCSS
-   Database: MySQL / PostgreSQL

---

## 📄 License

This project is open source and available under the MIT License.

---

> Developed with ❤️ by Muhammad Refa Walada Mushtofa
