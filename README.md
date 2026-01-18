# USPS Shipping Label

This project is a challenge for a Fullstack Engineer position.

The objective is to allow users to generate shipping labels to send merchandise to other people in the USA.
It uses the [EasyPost](https://www.easypost.com/) API for label generation.

## Quick Start

### Prerequisites

- Docker and Docker Compose
- EasyPost API Key (get one at [EasyPost](https://www.easypost.com/))

### Installation with Laravel Sail

1. **Set up environment variables:**

```bash
cp .env.example .env
```

2. **Configure your `.env` file with the EasyPost API key:**

```env
EASYPOST_API_KEY=your_easypost_api_key
```

3. **Start the Docker containers:**

```bash
./vendor/bin/sail up -d
```

4. **Generate application key:**

```bash
./vendor/bin/sail artisan key:generate
```

5. **Run database migrations:**

```bash
./vendor/bin/sail artisan migrate
```

6. **Install and build frontend assets:**

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

7. **Access the application:**

Open your browser at `http://localhost`

### Useful Sail Commands

```bash
# Stop containers
./vendor/bin/sail down

# Run artisan commands
./vendor/bin/sail artisan [command]

# Access the container shell
./vendor/bin/sail shell

# Run tests
./vendor/bin/sail test

# View logs
./vendor/bin/sail logs
```

### Local Installation (Without Docker)

If you prefer not to use Docker:

1. Ensure you have PHP 8.2+, Composer, Node.js 18+, and MySQL/PostgreSQL installed
2. Run `composer install && npm install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `npm run dev` and `php artisan serve`

## What I'd Do Next

- Generate Feature tests for comprehensive coverage
- Remove unused code and components
- Add API documentation
- Implement rate limiting for API endpoints
- Add error monitoring and logging service integration
- Handle EasyPost integration errors

## Application Architecture

I used [Laravel 12](https://www.laravel.com) with Inertia.js and React.
I chose to follow the framework's recommended patterns, including the "Actions" concept proposed by Laravel Fortify.

### Frontend

- Leveraged Laravel's pre-built components for the layout
- Made necessary customizations for the shipping label functionality

### Backend

The backend architecture follows these patterns:

- **FormRequest**: Validates request inputs and generates a Data Transfer Object (DTO)
- **Controllers**: Simply call an Action using the DTO returned by FormRequest and return the response to the user
- **Actions**: Execute all necessary operations for a request (e.g., generate label and save to database)
- **Repositories**: Interface with Eloquent Models for data persistence
- **Label Generator Interface**: Created an abstraction with EasyPost implementation, making it easy to swap providers if needed

This architecture provides clear separation of concerns and makes the codebase maintainable and testable.

## Key Features

- User authentication and registration (powered by Laravel Fortify)
- Address management for sender and recipient
- Shipping label generation via EasyPost API
- Shipping history and tracking
- Responsive UI built with React and Inertia.js

## Project Structure

```
app/
├── Actions/              # Business logic actions
├── Builders/             # Data builders for complex objects
├── DataTransferObjects/  # DTOs for type-safe data handling
├── Http/
│   ├── Controllers/      # Request handlers
│   └── Requests/         # Form request validation
├── Label/                # Label generation logic
│   └── EasyPost/         # EasyPost implementation
├── Models/               # Eloquent models
└── Repositories/         # Data access layer

resources/
├── js/                   # React components and pages
└── views/                # Inertia layouts
```

## Testing

Run the test suite:

```bash
php artisan test
# or using Pest directly
./vendor/bin/pest
```
