# HabitFlow

A personal habit tracker built with Laravel. Track daily habits, monitor your progress, and build consistent routines through a simple weekly dashboard.

## Features

- User registration and authentication
- Create and delete habits
- Customize habit colors
- Track daily habit completions
- Weekly habit matrix
- Daily progress statistics
- User-specific habits and completions

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade, Tailwind CSS
- **Build Tool:** Vite
- **Database:** SQLite
- **Authentication:** Laravel Breeze

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/HabitFlow.git
cd HabitFlow
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

Copy the example environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, you can use:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Configure the database

Create the SQLite database file if it doesn't exist:

```powershell
New-Item database/database.sqlite -ItemType File
```

In your `.env` file, configure:

```env
APP_NAME=HabitFlow
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Do not commit your `.env` file. It contains local configuration and potentially sensitive information.

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Start the application

Start the Laravel development server:

```bash
php artisan serve
```

In another terminal, start Vite:

```bash
npm run dev
```

Open http://127.0.0.1:8000 in your browser.

## Database Structure

### `users`

Stores registered users. Provided by Laravel Breeze.

| Column | Description |
|---|---|
| id | Primary key |
| name | User's name |
| email | Unique email address |
| password | Hashed password |
| created_at | Creation timestamp |
| updated_at | Last update timestamp |

### `habits`

Stores habits belonging to individual users.

| Column | Description |
|---|---|
| id | Primary key |
| user_id | Owner of the habit |
| name | Habit name |
| color | Habit display color |
| created_at | Creation timestamp |
| updated_at | Last update timestamp |

### `habit_completions`

Stores the dates on which habits were completed.

| Column | Description |
|---|---|
| id | Primary key |
| habit_id | Related habit |
| completed_on | Completion date |
| created_at | Creation timestamp |
| updated_at | Last update timestamp |

Each habit can only have one completion record per date.

## Migrations

Database migrations are located in:

```text
database/migrations/
```

Run migrations:

```bash
php artisan migrate
```

Rollback the latest migration batch:

```bash
php artisan migrate:rollback
```

Reset and rerun all migrations:

```bash
php artisan migrate:fresh
```

**Warning:** `migrate:fresh` deletes existing database tables and their data.

When adding new database features, create migrations using:

```bash
php artisan make:migration create_example_table
```

## Project Structure

```text
HabitFlow/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── database.sqlite
├── resources/
│   └── views/
│       ├── layouts/
│       └── dashboard.blade.php
├── routes/
│   └── web.php
├── tests/
├── .env.example
└── README.md
```

## Planned Features

- [ ] Weekly navigation (previous and next week)
- [ ] Habit editing and renaming
- [ ] Habit categories
- [ ] Daily and weekly streak tracking
- [ ] Monthly and yearly views
- [ ] Customizable first day of the week
- [ ] Custom dashboard settings
- [ ] More detailed statistics and charts
- [ ] Habit target frequency
- [ ] Improved mobile responsiveness

## License

This project is currently intended for personal learning and development.