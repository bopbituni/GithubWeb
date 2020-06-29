- Tạo file .env cấu hình database trên mysql :
 + Cấu hình giúp kết nối với github :
GITHUB_CLIENT_ID=d7d2a544cc86767d0bdc
GITHUB_CLIENT_SECRET=651fa3171958413e54955203e84e9ffd5e5bec8a
GITHUB_REDIRECT_URL=http://127.0.0.1:8000/login/github/callback

 + Cấu hình giúp kết nối với mailtrap.io: 
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=4b8887386432fc
MAIL_PASSWORD=f36c787195c963
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=thanhngau199@gmail.com
MAIL_FROM_NAME=thanh

 + Tạo database và thêm vào cấu hình env như ví dụ : 
 DB_DATABASE=website_test
 DB_USERNAME=root
 DB_PASSWORD=

 + Về queue trong env thì cấu hinh : QUEUE_CONNECTION=database

- Chạy npm install , composer update
- Chạy php artisan migrate. (để chạy migrate)
- Chạy php artisan ser. (để chạy dự án)
- Chạy php artisan queue:work. (để chạy queue)



