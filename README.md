# lumen_restapi

Testing rest_api dengan framework Lumen.

Untuk testing bisa menggunakan postman, restman atau sejenisnya

Route:

Show All: /api/user (get)

Create: /api/user (post)

Show by ID: /api/user/id (get)

Update: /api/user/id (put)

Delete: /api/user/id (delete)

Untuk login dan mendapatkan api token yang nantinya digunakan di header dengan nama "_token":

Login: /api/user/login (post)

Untuk inisiasi awal, buat database kemudian jalankan perintah berikut melalui terminal/cmd:

php artisan migrate --seed
