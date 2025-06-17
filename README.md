## Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- MySQL

## Các bước cài đặt
### 1. Cài đặt Composer dependencies
composer install


### 2. Tạo file cấu hình `.env`
cp .env.example .env


### 3. Cập nhật cấu hình `.env`

Chỉnh sửa thông tin kết nối cơ sở dữ liệu trong `.env`:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

> Lưu ý: Tạo sẵn database `ten_csdl` trong MySQL trước khi migrate.

### 4. Tạo key cho ứng dụng
php artisan key:generate

### 5. Chạy migration và seed
php artisan migrate
php artisan db:seed  

### 6. Cài đặt và build frontend
npm install
npm run dev

## Khởi động server
php artisan serve
Truy cập trình duyệt: [http://localhost:8000](http://localhost:8000)

**Tài liệu tham khảo**
* Laravel Docs: [https://laravel.com/docs](https://laravel.com/docs)
* Composer: [https://getcomposer.org/](https://getcomposer.org/)

