
# Job Filtering API

This project provides a flexible and powerful API for filtering job listings. It allows users to search for jobs based on various criteria, including job type, language requirements, location, and custom attributes.

## Features
- Filter jobs by basic fields (e.g., job title, company name, job type).
- Filter jobs by related models (e.g., languages, locations, categories).
- Filter jobs based on custom attributes such as years of experience, salary, etc.
- Complex query support with logical operators (`AND`, `OR`) and custom operators (`HAS_ANY`, `IS_ANY`, `EXISTS`).
- Paginated responses to manage large datasets.

## Table of Contents
1. [Installation](#installation)
2. [Environment Setup](#environment-setup)
3. [Postman Collection](#postman-collection)
4. [API Endpoints](#api-endpoints)
5. [Filtering Syntax](#filtering-syntax)
6. [Examples](#examples)
7. [Contributing](#contributing)
8. [License](#license)

## Installation

To get the Job Filtering API up and running locally, follow these steps:

### 1. Clone the repository

```bash
git clone https://github.com/naderhany96/job-board.git
cd job-filtering-api
```

### 2. Install dependencies

Make sure you have Composer installed, then run the following command to install Laravel dependencies:

```bash
composer install
```

### 3. Set up environment variables

Copy the `.env.example` file to create your own `.env` file:

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database and other environment variables.

### 4. Generate application key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### 5. Run migrations

Run the migrations to set up your database tables:

```bash
php artisan migrate
```

### 6. Seed the database (optional)

You can seed the database with sample data using the following command:

```bash
php artisan db:seed
```

### 7. Serve the application

Start the development server:

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

---

## Environment Setup

The application uses the following environment variables for configuration:

- `DB_CONNECTION`: The database connection (e.g., `mysql`, `pgsql`).
- `DB_HOST`: The database host (e.g., `127.0.0.1`).
- `DB_PORT`: The database port (e.g., `3306` for MySQL).
- `DB_DATABASE`: The name of the database.
- `DB_USERNAME`: The database username.
- `DB_PASSWORD`: The database password.

---

## Postman Collection

For ease of testing, a Postman collection is included in the `docs/postman` directory. The collection contains several example requests to help you get started with the API. You can import the collection into Postman and use the examples to explore the available endpoints and filtering options.

---

## API Endpoints

### `GET /api/jobs`

Fetches a list of jobs based on filter criteria. Supports complex queries using logical operators.

#### Query Parameters

- `filter[AND][field]`: Filter by a field with an AND operator.
- `filter[OR][field]`: Filter by a field with an OR operator.
- `attribute[field]`: Filter based on custom attributes (e.g., `years_experience`).
  
#### Example Request:

```http
GET /api/jobs?filter[AND][job_type]=full-time&filter[OR][languages HAS_ANY]=PHP,JavaScript&attribute[years_experience]=>=3
```

#### Response:

A paginated list of jobs that match the filter criteria.

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Full Stack Developer",
            "company_name": "Tech Corp",
            "job_type": "full-time",
            "languages": ["PHP", "JavaScript"],
            "location": "New York",
            "years_experience": 3
        },
        
    ],
    "meta": {
        "current_page": 1,
        "total": 100,
        "per_page": 10
    }
}
```

---

## Filtering Syntax

### Basic Filters

You can filter jobs based on basic fields (e.g., `job_type`, `title`, `company_name`).

#### Example:

```http
filter[AND][job_type]=full-time
filter[OR][title]=developer
```

### Relationship Filters

You can filter jobs by related models such as `languages`, `locations`, or `categories`.

#### Example:

```http
filter[AND][languages HAS_ANY]=PHP,JavaScript
filter[OR][locations IS_ANY]=New York,Remote
```

### Attribute Filters

Filter jobs based on attributes like `years_experience`, `salary_min`, or any custom attributes.

#### Example:

```http
attribute[years_experience]=>=3
```

### Supported Operators

Here’s the corrected table in proper Markdown syntax:

| Operator   | Example                                  | Description                        |
|------------|------------------------------------------|------------------------------------|
| `=`        | `filter[AND][job_type]=full-time`       | Exact match                       |
| `LIKE`     | `filter[AND][title]=developer`          | Partial match                     |
| `HAS_ANY`  | `filter[AND][languages HAS_ANY]=PHP,JavaScript` | Matches any of the specified values |
| `IS_ANY`   | `filter[OR][locations IS_ANY]=New York,Remote` | Matches at least one of the provided values |
| `EXISTS`   | `filter[AND][categories EXISTS]=1`      | Checks if a relationship exists   |
| `>=`       | `attribute[years_experience]>=3`        | Greater than or equal to          |

---

## Examples

### Example 1: Find full-time jobs that require PHP or JavaScript and are in New York or Remote

```http
GET /api/jobs?filter[AND][job_type]=full-time&filter[OR][languages HAS_ANY]=PHP,JavaScript&filter[OR][locations IS_ANY]=New York,Remote
```

### Example 2: Find jobs that are remote OR require at least 3 years of experience

```http
GET /api/jobs?filter[OR][is_remote]=1&attribute[years_experience]=>=3
```
