
# Psychologist Appointment API

This project is a Dockerized Laravel application for managing psychologist appointments.

## Prerequisites

- Docker
- Docker Compose

## Setup Instructions

1. Clone the repository to your local machine.
2. Navigate to the project directory.
3. Make a copy of the `.env.example` file and rename it to `.env`.

## Running the Project

Run the following commands in the project directory:

```bash
docker-compose up --build -d
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan test
docker-compose exec app php artisan migrate --seed
```

## Additional Information

- The `docker-compose up --build -d` command builds and starts the Docker containers in detached mode.
- The `composer install` command installs the PHP dependencies.
- The `php artisan key:generate` command generates the application key.
- The `php artisan test` command runs the application tests.
- The `php artisan migrate --seed` command runs the database migrations and seeds the database.

## API Routes

The following routes are available in the Psychologist Appointment API:

- `POST /api/register` - Register a new user. (user will have role of a basic user)
- `POST /api/login` - Authenticate a user and generate a token.
- `GET /api/appointments` - Retrieve a list of all appointments.
- `GET /api/psychologist/{psychologist_id}/time-slots` - Retrieve a list of all appointments for a specific psychologist.

The following routes requires user to be authenticated:

- `POST /api/psychologist/{psychologist_id}/time-slots` - Create a time slot
- `PUT /api/psychologist/{psychologist_id}/time-slots` - Update an existing appointment.
- `POST /api/reserve/{time_slot_id}` - Reserve an appointment. After successfull reservation email will be sent (appears in storage/logs/laravel.log).
- `DELETE /api/psychologist/{psychologist_id}/time-slots` - Delete an appointment.
