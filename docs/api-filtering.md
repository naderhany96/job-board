# Job Filtering API Documentation

## Overview
The Job Filtering API provides a flexible mechanism to query job listings based on various criteria, including basic fields, relationships, and custom attributes. This document outlines the available endpoints, filtering syntax, supported operators, and example queries.

---

## Base Endpoint
**GET /api/jobs**

### Query Parameters
The API supports complex filtering using logical operators (`AND`, `OR`) and different types of filtering:
- **Basic field filters**: Apply conditions to standard job fields.
- **Relationship filters**: Filter jobs based on related models.
- **Attribute filters**: Filter jobs based on dynamically stored attributes.

---

## Filtering Syntax
Filters are provided through the `filter` query parameter using nested structures for complex conditions.

### Basic Filters
```
filter[AND][job_type]=full-time
filter[OR][is_remote]=1
```
- **job_type**: Filters jobs with an exact match (`full-time` in this case).
- **is_remote**: Filters jobs where `is_remote` is `1`.

### Relationship Filters
```
filter[AND][languages HAS_ANY]=PHP,JavaScript
filter[OR][locations IS_ANY]=New York,Remote
```
- **languages HAS_ANY**: Finds jobs where the language is PHP **or** JavaScript.
- **locations IS_ANY**: Matches jobs in **New York** or **Remote**.

### Attribute Filters
```
attribute[years_experience]=>=3
```
- **years_experience >= 3**: Filters jobs requiring at least 3 years of experience.

---

## Supported Operators
| Operator | Usage Example | Description |
|----------|--------------|-------------|
| `=` | `filter[AND][job_type]=full-time` | Exact match |
| `LIKE` | `filter[AND][title]=developer` | Partial match |
| `HAS_ANY` | `filter[AND][languages HAS_ANY]=PHP,JavaScript` | Matches any of the specified values |
| `IS_ANY` | `filter[OR][locations IS_ANY]=New York,Remote` | Matches at least one of the provided values |
| `EXISTS` | `filter[AND][categories EXISTS]=1` | Checks if a relationship exists |
| `>=` | `attribute[years_experience]=>=3` | Greater than or equal to |
| `<=` | `attribute[years_experience]=<=5` | Less than or equal to |

---

## Example Queries

### 1. Find full-time jobs that require PHP or JavaScript and are in New York or Remote
```
/api/jobs?filter=(job_type=full-time AND (languages HAS_ANY (PHP,JavaScript))) AND (locations IS_ANY (New York,Remote))
```

### 2. Find jobs that are remote OR require at least 3 years of experience
```
/api/jobs?filter[OR][is_remote]=1&attribute[years_experience]=>=3
```

### 3. Find jobs that are published after January 1, 2024, and are either in the "Tech" category OR require Python
```
/api/jobs?filter[AND][published_at]=>=2024-01-01&filter[OR][categories HAS_ANY]=Tech&filter[OR][languages HAS_ANY]=Python
```


## Conclusion
This API allows for powerful and flexible job searching using advanced filtering capabilities. Ensure query parameters are properly structured to get the expected results.
