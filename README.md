# Order Management API

Sebuah RESTful API menggunakan Laravel 11 dan JWT untuk mengelola produk dan pesanan.

## 📦 Fitur
- Register & Login (JWT)
- CRUD Produk
- Buat Pesanan
- Riwayat Pesanan per Pengguna

## ⚙️ Instalasi

1. Clone repo
   ```bash
   git clone https://github.com/username/order-management-api.git
   cd order-management-api
   ```

2. Install dependensi PHP
   ```bash
   composer install
   ```

3. Salin file .env
   ```bash
   cp .env.example .env
   ```

4. Atur konfigurasi database di .env

5. Generate app key
   ```bash
   php artisan key:generate
   ```

6. Generate JWT secret
   ```bash
   php artisan jwt:secret
   ```

7. Jalankan migrasi database
   ```bash
   php artisan migrate
   ```

8. Jalankan server lokal
   ```bash
   php artisan serve
   ```

## 🧪 Testing dengan Postman

### 1. Register
POST 
```json
{
  "name": "User",
  "email": "user@example.com",
  "password": "password",
  "role": "admin/(default tanpa role = costumer)"
}
```

### 2. Login
POST 
```json
{
  "email": "user@example.com",
  "password": "password"
}
```
> Simpan token dari response.

### 3. Tambah Produk (Admin)
POST   
Header: Authorization: Bearer {token}

```json
{
  "name": "Nasi Goreng",
  "price": 15000,
  "stock": 100
}
```

### 4. Buat Pesanan
POST   
Header: Authorization: Bearer {token}

```json
{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}
```

### 5. Lihat Riwayat Pesanan
GET   
Header: Authorization: Bearer {token}

## ✅ Selesai!

