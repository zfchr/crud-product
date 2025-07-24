API endpoint untuk mengelola data product.

```
-composer install / update
-buat file .env dari .env.example lalu php artisan key:generate
-php artisan migrate, disini saya memakai DB Mysql
```

## 📍 Base URL

```
http://your-domain.com/api
```

---

## 📘 Response

### ✅ Success Response
```json
{
  "status": {
    "error": true,
    "title": "Success",
    "message": "The operation was successful"
  },
  "data": {
    // your data here
  }
}
```

### ❌ Error Response
```json
{
  "status": {
    "error": false,
    "title": "Failed to process your request",
    "message": "Something went wrong"
  },
  "data": []
}
```

---

## 📁 Endpoints

### 1. 🔍 Get All Products
**URL:** `/product`  
**Method:** `GET`  
**Deskripsi:** Mengambil semua data produk.

#### Response:
```json
{
  "status": {
    "error": true,
    "title": "Success",
    "message": "Success"
  },
  "data": [
    {
      "id": 1,
      "code": "P001",
      "sku": "SKU001",
      "name": "Produk A",
      "alias_name": "Produk Alternatif",
      "price": 100000,
      "description": "Deskripsi produk A",
      "created_at": "...",
      "updated_at": "..."
    }
  ]
}
```

---

### 2. 🔍 Get Product by ID
**URL:** `/product/{id}`  
**Method:** `GET`  
**Deskripsi:** Mengambil detail produk berdasarkan ID.

#### Response:
```json
{
  "status": {
    "error": true,
    "title": "Success",
    "message": "Success"
  },
  "data": {
    "id": 1,
    "code": "P001",
    "sku": "SKU001",
    "name": "Produk A",
    "alias_name": "Produk Alternatif",
    "price": 100000,
    "description": "Deskripsi produk A",
    "created_at": "...",
    "updated_at": "..."
  }
}
```

---

### 3. ➕ Create Product
**URL:** `/product`  
**Method:** `POST`  
**Deskripsi:** Menambahkan produk baru.

#### Request Body:
```json
{
  "code": "P001",
  "sku": "SKU001",
  "name": "Produk A",
  "alias_name": "Produk Alternatif",
  "price": 100000,
  "description": "Deskripsi produk A"
}
```

#### Validation Rules:
- `code`: required, max:30, unique
- `sku`: required, max:30, unique
- `name`: required, max:50
- `alias_name`: optional, max:50
- `price`: required, numeric, min:0
- `description`: optional, max:150

#### Success Response:
```json
{
  "status": {
    "error": true,
    "title": "Success",
    "message": "The new data has been successfully created."
  },
  "data": {
    "id": 1,
    "code": "P001",
    "sku": "SKU001",
    "name": "Produk A",
    "alias_name": "Produk Alternatif",
    "price": 100000,
    "description": "Deskripsi produk A",
    "created_at": "...",
    "updated_at": "..."
  }
}
```

#### Validation Error (422):
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "code": ["The code field is required."]
  }
}
```

#### Internal Server Error (500):
```json
{
  "status": {
    "error": false,
    "title": "Failed to process your request",
    "message": "SQLSTATE[23000]: Integrity constraint violation..."
  },
  "data": []
}
```

---

### 4. ✏️ Update Product
**URL:** `/product/{id}`  
**Method:** `PATCH`  
**Deskripsi:** Memperbarui data produk berdasarkan ID.

#### Request Body:
```json
{
  "code": "P002",
  "sku": "SKU002",
  "name": "Produk B",
  "alias_name": "Alias B",
  "price": 120000,
  "description": "Deskripsi produk B"
}
```

#### Validation Rules:
- Sama seperti endpoint `store`, dengan pengecualian data saat ini diabaikan oleh validasi unique.

#### Success Response:
```json
{
  "status": {
    "error": true,
    "title": "Success",
    "message": "The new data has been successfully saved."
  },
  "data": {
    "id": 1,
    "code": "P002",
    "sku": "SKU002",
    "name": "Produk B",
    ...
  }
}
```

---

### 5. 🗑️ Delete Product
**URL:** `/product/{id}`  
**Method:** `DELETE`  
**Deskripsi:** Menghapus produk berdasarkan ID.

#### Success Response:
```json
{
  "status": {
    "error": false,
    "title": "Failed to process your request",
    "message": "The data has been success deleted."
  },
  "data": []
}
```
