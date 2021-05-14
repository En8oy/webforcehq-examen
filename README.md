# WebforceHQ Exam
Welcome to my exam to the company WebforceHQ, i used technologys like Vue CLI and Laravel 8 for view the project follow this steps

```
git clone https://github.com/En8oy/webforcehq-examen.git
```

Backend

```
cd backend
composer install
php artisan migrate --seed
php artisan cache:clear
php artisan config:clear
php artisan key:generate
php artisan jwt:secret
php artisan serve
```

Frontend
```
cd frontend
npm install
npm run serve
```

For the login need to enter to ``` /login ``` in frontend project.
the credentials are email in the database and "password"
