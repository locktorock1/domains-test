# 🌐 Domain Monitoring

> Monitoring domain uptime, response time, and HTTP status with automated checks and history tracking.

---

## 📊 Project Status

![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.3+-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![Docker](https://img.shields.io/badge/Docker-Ready-blue)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 🚀 Features

### 🔐 Authentication (Laravel Breeze)
- User registration / login / logout
- Protected dashboard routes
- Session-based auth

---

### 🌍 Domain Management
- Add / edit / delete domains
- Per-user domain list
- Domain ownership isolation

---

### ⚙️ Monitoring Configuration
- HTTP method selection (GET / HEAD)
- Request timeout configuration
- Check interval per domain

---

### 🔄 Automated Monitoring
- Cron-based laravel scheduler
- Background domain checks

---

### 📊 History & Logs
- HTTP status codes
- Response time tracking (ms)
- Error logging (timeouts, DNS, connection errors)
- Timestamped check history

---

### 🔔 Notifications (Future)
- Email notifications up/down domain

---

## 🧱 Architecture Overview

```text id="arch_001"
User
 ↓
Laravel Breeze (Auth)
 ↓
Dashboard
 ↓
Domains
 ↓
HTTP Domain Checker Service
 ↓
Scheduler (cron)
 ↓
Database (MySQL 8)
 ↓
Logs Table
```

## 🚀 Installation
git clone git@github.com:locktorock1/domains-test.git
cd domains-test

cp .env.example .env

## 🐳 Run with Docker
docker-compose up -d --build

## 📦 Setup Application
docker exec -it laravel_app composer install

docker exec -it laravel_app npm install

docker exec -it laravel_app npm run build

docker exec -it laravel_app php artisan key:generate

docker exec -it laravel_app php artisan migrate

## ⏱️ Scheduler Setup
* * * * * php /var/www/artisan schedule:run >> /dev/null 2>&1
