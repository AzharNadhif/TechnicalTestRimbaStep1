# TechnicalTestRimbaStep1

## 🔧 Setup Project
1. Clone Project

git clone https://github.com/AzharNadhif/TechnicalTestRimbaStep1

cd namarepo

3. Install Dependency

composer install

npm install && npm run build

4. Setup Environment

cp .env.example .env

Lalu sesuaikan konfigurasi database di file .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_db
DB_USERNAME=root
DB_PASSWORD=

4. Generate Key dan Migrate
php artisan key:generate
php artisan migrate

5. Seed User & Task
php artisan db:seed

6. Jalankan Server
php artisan serve

## ✅ Fitur Utama
🔐 Otentikasi
Login (menghasilkan token Sanctum)
Logout
Role-based access: admin, staff, manajer

## 📁 Manajemen Tugas
| Role  | Fitur                                    |
| ----- | ---------------------------------------- |
| Admin | Tambah/Edit/Hapus tugas, Assign ke staff |
| Staff | Hanya melihat tugas yang ditugaskan      |


## 📂 Endpoint API
| Method | Endpoint      | Akses | Deskripsi                |
| ------ | ------------- | ----- | ------------------------ |
| POST   | `/`           | -     | Login dan dapatkan token |
| GET    | `/users`      | Admin | Lihat daftar user        |
| POST   | `/users`      | Admin | Tambah user baru         |
| GET    | `/tasks`      | Semua | Daftar task (filtered)   |
| POST   | `/tasks`      | Admin | Tambah task              |
| PUT    | `/tasks/{id}` | Admin | Edit task                |
| DELETE | `/tasks/{id}` | Admin | Hapus task               |
| GET    | `/logs`       | Admin | Riwayat aktivitas        |


## 🧪 Testing
Unit Test
Validasi logika overdue task

Feature Test
Login dan akses endpoint
Create Task oleh admin
Pastikan staff tidak bisa create task

Menjalankan Test
php artisan test

##📌 Catatan
Role user harus admin untuk bisa membuat task.
Task hanya bisa ditugaskan ke user dengan role staff.	
Semua Password user : password
