# Mini Wallet Application

A simple digital wallet application built with **Laravel 10** (backend) and **Vue 3 + Composition API** (frontend). Users can transfer money, view transaction history, and see real-time updates via **Pusher**.

This project is a fast, scalable wallet system that can handle tons of simultaneous transactions without messing up the data.

---

## Project Structure

- **backend/** – Laravel API
- **frontend/** – Vue 3 application

---

## Requirements

- PHP >= 8.1  
- Composer  
- Node.js & npm  
- MySQL or PostgreSQL  

---

## Backend Setup (Laravel API)

1. Navigate to the backend folder:

```bash
cd backend
```

2. Install PHP dependencies:

```bash
composer install
```

3. Copy `.env.example` to `.env` and configure your **database** and **Pusher credentials**:

```bash
cp .env.example .env
```

Edit `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_key
PUSHER_APP_SECRET=your_pusher_secret
PUSHER_APP_CLUSTER=your_cluster
```

4. Generate the application key:

```bash
php artisan key:generate
```

5. Run database migrations and db seed to make **6 users** and all user's password is **secret123**

```bash
php artisan migrate
php artisan db:seed

these users will be created in the user table with random balance 
ali@example.com 
omer@example.com
adnan@example.com
hamza@example.com
qayyim@example.com
subayyal@example.com
```

6. Start the Laravel server:

```bash
php artisan serve
```

## Frontend Setup (Vue 3)

1. Navigate to the frontend folder:

```bash
cd frontend
```

2. Install Node modules:

```bash
npm install
```

1. Set **Pusher key** and **API URL** in this `.env` file

```dotenv
VITE_BACKEND_URL=http://127.0.0.1:8000
VITE_PUSHER_KEY=your_pusher_key
VITE_PUSHER_CLUSTER=your_cluster
```

1. Start frontend server:

```bash
npm run dev
```
## Features

- **User Authentication** via Laravel Sanctum  
- **Money Transfer** with 1.5% commission deducted from sender  
- **Transaction History** showing incoming and outgoing transactions  
- **Current Balance** display for authenticated user  
- **Real-Time Updates** using Pusher for instant balance and transaction updates  
- **Atomic Transfers** ensuring no partial updates; transactions are rolled back on failure  
- **Validation** for receiver existence, positive amounts, and sufficient balance etc

---

## Usage

1.  **login** as a user
2. after login you will be redirected to  **Dashboard** :  
   - Enter recipient user ID  
   - Enter the amount  
   - Click **Send**  
3. **View Transaction History & Balance**:  
   - All past transactions are listed  
   - Balance updates automatically when new transfers occur (real-time) pusher

---

## Author
**Adnan Asif**