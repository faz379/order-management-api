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
  "description": "Nasi Goreng enak dengan cita rasa digoreng    ",
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


### 5. Lihat Riwayat Pesanan (keseluruhan)
GET `/api/orders/` 
Header: Authorization: Bearer {token}



### 6. Lihat Riwayat Pesanan (per pengguna)
GET `/api/orders/user/{id}`  
Header: Authorization: Bearer {token}

Contoh:
GET `/api/orders/user/4`

Response:
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 4,
      "total_price": 30000,
      "created_at": "2025-07-31 07:00:00",
      "items": [
        {
          "product_id": 1,
          "name": "Nasi Goreng",
          "quantity": 2,
          "price": 15000,
          "subtotal": 30000
        }
      ]
    }
  ]
}


## ✅ Selesai!

