## About Rent Car

RentCar is a simple CRUD application using Laravel 10 and TailwindCSS with simple car rental features, this application is divided into 2 roles, namely the admin and user roles and each role has its own page access rights.

This application is very simple so some feature implementations are made less complex such as

-   RBAC (Role Based Access Control): using simple middleware
-   Authentication: I'm used to making use of JWT but because I'm chasing time and taking a simple concept, so I use Laravel's built-in sanctum as authentication.

## Installation

-   Clone this repository
-   Run `composer install`
-   Run `cp .env.example .env`
-   Update .env into correct database configuration
-   Run `php artisan migrate:fresh --seed`
-   Run `php artisan storage:link`
-   Run `php artisan serve`

## Account

-   Admin
    -   email: faraazap@gmail.com
    -   password: password
-   User
    -   email: penggunasatu@gmail.com / penggunadua@gmail.com
    -   password: password
