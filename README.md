# Psychologist Appointment API

Beginning of Docker + Laravel project

Currently nothing works

To run this project you need:

Make a copy of .env.example file and rename it to .env

Then run these commands in the following order:

```bash
docker-compose up --build -d
docker-compose exec app composer install
docker-compose exec app php artisan migrate
docker-compose exec app php artisan test
```
