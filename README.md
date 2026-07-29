# Exachanger - Sistem Pertukaran Saldo Dolar Berbasis Web (studi kasus: PT. Vepay Multipayment Internasional)

Exachanger adalah Website atau sistem pertukaran saldo dolar yang dibangun menggunakan Laravel 12 dan Filament 4.

📋 Requirement:
Pastikan sistem Anda memiliki:
1. Local Server 
2. php version >= 8.3
3. MySql version >= 8.0
4. Composer
5. SMTP Server

### Configure Environment Variables ### 

Clone Repository
jalankan di terminal :
1. git clone https://github.com/Rifqi-231221003/Tugas-Akhir
2. cd exachanger

Edit file `.env` dan sesuaikan konfigurasi berikut:

APP_NAME="Exachanger"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=exachanger
DB_USERNAME=root
DB_PASSWORD=

## Konfigurasi smtp 
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@exachanger.com
MAIL_FROM_NAME="${APP_NAME}"


### Database Setup
jalankan di terminal :
1. php artisan migrate
2. php artisan serve

Website akan berjalan di: `http://127.0.0.1:8000`
Dashboard admin di: `http://127.0.0.1:8000/admin`| email : admin@exachanger.com | password : 12345678


#🐳 Menjalankan Menggunakan Docker
Requirement Install:

1. Docker Desktop
2. Docker Compose

jalankan di terminal :
1. git clone https://github.com/Rifqi-231221003/Tugas-Akhir
2. cd exachanger
3. docker compose build
4. docker compose up 

📁 Struktur Proyek
```
exachanger/
├── app/
│   ├── Console/              # Artisan commands
│   ├── Filament/             # Admin panel components
│   │   ├── Resources/        # Filament resources
│   │   └── Widgets/          # Custom admin pages
│   ├── Http/
│   │   └── Controllers/      # HTTP controllers
│   │       └──Api/           # API controllers
│   ├── Models/               # Eloquent models
│   │   ├── User.php
│   │   ├── Transaction.php
│   │   ├── Product.php
│   │   └── ExchangeRate.php
│   ├── Observers/            # Model observers
│   ├── Policies/             # Authorization policies
│   └── View/                 # View composers
├── bootstrap/                # Framework bootstrapping
├── config/                   # Configuration files
│   ├── app.php
│   ├── database.php
│   └── filament.php
├── database/
│   └── migrations/           # Database migrations
├── public/
│   ├── css/                  # Compiled styles
│   ├── js/                   # Compiled scripts
│   └── img/                  # Image
├── resources/
│   ├── views/                # Blade templates
│   │   ├── emails/           # Email views
│   │   ├── filament/         # Admin views
│   │   └── layouts/          # Layout templates
│   ├── css/                  # Source styles
│   ├── js/                   # Source scripts
│   └── lang/                 # Language files
├── routes/                   # Route definitions
│   └── web.php               # Web routes
├── storage/                  # Storage files
├── .env.example              # Environment template
├── artisan                   # Artisan CLI
├── composer.json             # PHP dependencies
├── package.json              # Node.js dependencies
├── docker-compose.yml        # Docker configuration
├── Dockerfile                # Docker image definition
└── README.md                 # Documentation
```
