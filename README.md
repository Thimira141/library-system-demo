# Library System Demo

This repository contains a simple library management application built with [Laravel](https://laravel.com/). The project demonstrates basic CRUD operations, user authentication, and data tables for managing books, categories, members, and borrowing/return transactions.

## 🚀 Features

- User authentication (login/register)
- Book management (create, read, update, delete)
- Category and book-category association
- Member management
- Borrow and return tracking for books
- Responsive UI with datatables and AJAX

## 🛠️ Technologies

- PHP 8.x
- Laravel framework
- MySQL (or any supported database)
- Vite for asset bundling
- Pest for testing
- Yajra Datatables for server-side tables

## 🗂️ Project Structure

The workspace follows a standard Laravel layout with directories for `app`, `config`, `database`, `resources`, `routes`, and `tests`.

Key models include:

- `Book`
- `Category`
- `BookCategory`
- `Members`
- `BooksBorrowReturn`

Controllers handle HTTP logic under `app/Http/Controllers`.

## 📦 Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/library-system-demo.git
   cd library-system-demo
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install JavaScript dependencies:

   ```bash
   npm install
   npm run dev
   ```

4. Copy `.env.example` to `.env` and configure your database credentials.
5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Run migrations and seed database:

   ```bash
   php artisan migrate --seed
   ```

7. Start the development server:

   ```bash
   php artisan serve
   ```

## ✅ Running Tests

Use Pest to execute the test suite:

```bash
./vendor/bin/pest
```

## 🧩 Customization

- Modify database settings in `.env`.
- Add new features or models following Laravel conventions.

## 📄 License

[This project is provided for educational and personal use only. Commercial use or claiming ownership is prohibited](LICENSE).

---

>NOTE: PROJECT STILL UNDER-DEVELOPMENTS
