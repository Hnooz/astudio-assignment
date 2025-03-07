# Project Management API

This is a Laravel-based project management API with **Entity-Attribute-Value (EAV)** support, user authentication, and a flexible filtering system.

## Features

- **User Authentication** (Register, Login, Logout) using Laravel Passport.
- **Project Management** with support for dynamic attributes (EAV model).
- **Timesheet Logging** for users to track hours per project.
- **Filtering System** that supports both standard and dynamic attributes.
- **RESTful API** with CRUD operations.

---

## 🛠 Setup Instructions

### 1. Clone the Repository
```bash
git clone git@github.com:Hnooz/astudio-assignment.git
cd astudio-assignment
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Set Up Environment
Copy the example environment file:
```bash
cp .env.example .env
```
Update the **database credentials** in the `.env` file.

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Set Up Database
```bash
php artisan migrate --seed
```

### 6. Install Laravel Passport
```bash
php artisan passport:install
```

### 7. Serve the Application
```bash
php artisan serve
```

---

## 🔒 Authentication

### Register
```http
POST /api/register
```
**Request:**
```json
{
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```
**Response:**
```json
{
  "token": "your-access-token",
  "user": { "id": 1, "first_name": "John", "last_name": "Doe", "email": "john@example.com" }
}
```

### Login
```http
POST /api/login
```
**Request:**
```json
{
  "email": "john@example.com",
  "password": "password"
}
```
**Response:**
```json
{
  "token": "your-access-token",
  "user": { "id": 1, "first_name": "John", "last_name": "Doe", "email": "john@example.com" }
}
```

### Logout
```http
POST /api/logout
```
**Requires Bearer Token in Headers.**

---

## 📌 API Endpoints

### Users
| Method | Endpoint             | Description |
|--------|----------------------|-------------|
| `GET`  | `/api/users`         | Get all users |
| `GET`  | `/api/users/{id}`    | Get a specific user |
| `POST` | `/api/users`         | Create a user |
| `PUT`  | `/api/users/{id}`    | Update a user |
| `DELETE` | `/api/users/{id}`  | Delete a user |

### Projects
| Method | Endpoint             | Description |
|--------|----------------------|-------------|
| `GET`  | `/api/projects`      | Get all projects |
| `GET`  | `/api/projects/{id}` | Get a specific project |
| `POST` | `/api/projects`      | Create a project |
| `PUT`  | `/api/projects/{id}` | Update a project |
| `DELETE` | `/api/projects/{id}` | Delete a project |

### Timesheets
| Method | Endpoint               | Description |
|--------|------------------------|-------------|
| `GET`  | `/api/timesheets`      | Get all timesheets |
| `GET`  | `/api/timesheets/{id}` | Get a specific timesheet |
| `POST` | `/api/timesheets`      | Create a timesheet |
| `PUT`  | `/api/timesheets/{id}` | Update a timesheet |
| `DELETE` | `/api/timesheets/{id}` | Delete a timesheet |

### Attributes (EAV)
| Method | Endpoint              | Description |
|--------|-----------------------|-------------|
| `GET`  | `/api/attributes`     | Get all attributes |
| `POST` | `/api/attributes`     | Create an attribute |
| `PUT`  | `/api/attributes/{id}` | Update an attribute |
| `DELETE` | `/api/attributes/{id}` | Delete an attribute |

### Filtering Example
```http
GET /api/projects?filters[name]=ProjectA&filters[department]=IT
```
Supports operators: `=`, `>`, `<`, `LIKE`.

---

## 🔍 API Documentation
Run the command to generate API docs with **Scribe**:
```bash
php artisan scribe:generate
```
Access the API docs at:
```
APP_URL/docs
```

---

## 🛠 Technologies Used
- **Laravel** 12
- **Laravel Passport** (Authentication)
- **MySQL** (Database)
- **Scribe** (API Documentation)


