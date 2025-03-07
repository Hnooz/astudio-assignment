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

```bash
php artisan passport:keys
```

### 7. Serve the Application

```bash
php artisan serve
```

---

## 🔒 Authentication

### Register

```http
POST /api/v1/register
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
POST /api/v1/login
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
POST /api/v1/logout
```

**Requires Bearer Token in Headers.**

---

## 📌 API Endpoints

### Users

| Method   | Endpoint             | Description         |
| -------- | -------------------- | ------------------- |
| `GET`    | `/api/v1/users`      | Get all users       |
| `GET`    | `/api/v1/users/{id}` | Get a specific user |
| `POST`   | `/api/v1/users`      | Create a user       |
| `PUT`    | `/api/v1/users/{id}` | Update a user       |
| `DELETE` | `/api/v1/users/{id}` | Delete a user       |

### Projects

| Method   | Endpoint                | Description            |
| -------- | ----------------------- | ---------------------- |
| `GET`    | `/api/v1/projects`      | Get all projects       |
| `GET`    | `/api/v1/projects/{id}` | Get a specific project |
| `POST`   | `/api/v1/projects`      | Create a project       |
| `PUT`    | `/api/v1/projects/{id}` | Update a project       |
| `DELETE` | `/api/v1/projects/{id}` | Delete a project       |

### Timesheets

| Method   | Endpoint                  | Description              |
| -------- | ------------------------- | ------------------------ |
| `GET`    | `/api/v1/timeSheets`      | Get all timeSheets       |
| `GET`    | `/api/v1/timeSheets/{id}` | Get a specific timesheet |
| `POST`   | `/api/v1/timeSheets`      | Create a timesheet       |
| `PUT`    | `/api/v1/timeSheets/{id}` | Update a timesheet       |
| `DELETE` | `/api/v1/timeSheets/{id}` | Delete a timesheet       |

### Attributes (EAV)

| Method   | Endpoint                  | Description         |
| -------- | ------------------------- | ------------------- |
| `GET`    | `/api/v1/attributes`      | Get all attributes  |
| `POST`   | `/api/v1/attributes`      | Create an attribute |
| `PUT`    | `/api/v1/attributes/{id}` | Update an attribute |
| `DELETE` | `/api/v1/attributes/{id}` | Delete an attribute |

### Attribute Values (EAV)

| Method   | Endpoint                        | Description               |
| -------- | ------------------------------- | ------------------------- |
| `GET`    | `/api/v1/attribute-values`      | Get all attribute values  |
| `POST`   | `/api/v1/attribute-values`      | Create an attribute value |
| `PUT`    | `/api/v1/attribute-values/{id}` | Update an attribute value |
| `DELETE` | `/api/v1/attribute-values/{id}` | Delete an attribute value |

### Filtering Example

```http
GET /api/v1/projects?filters[name]=ProjectA&filters[department]=IT
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

---

## 🔧 Composer Scripts

These scripts streamline development and automation:

- **fresh**: Resets the database with fresh migrations and clears cache.
- **start**: Runs migrations, clears cache, generates API docs, and starts the server.
- **docs**: Generates API documentation using Scribe.
- **pest**: Runs Pest tests in parallel with an increased memory limit.
- **style-fix**: Fixes code style using Laravel Pint.
- **style-check**: Checks code style without applying fixes.
- **rector-dry**: Runs Rector in dry-run mode to preview changes.
- **rector-fix**: Applies Rector fixes to code.
- **ci-check**: Runs style check and Rector dry-run for CI validation.

