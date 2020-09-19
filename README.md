<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About this Project
This app is made using [Laravel](https://laravel.com/docs), and intended to be the backend for [Practical Test FE](https://github.com/lalajr/adg-practical-test-fe).

## Requirements
- Local server (XAMPP, WAMPP)
- Git bash (or default CMD for Windows)

## Installation
Follow the steps below to make your clone of this backend ready for service.

1. After cloning, run command `composer install` and `npm install` to initiate all dependencies for this project.
2. Make a local copy of the `.env` file, run this command to do so `scp .env.example .env`.
3. Run artisan command `php artisan key:generate` to generate key for your project.
4. Open `.env` file change the database credentials and other configs that suits your local environment. **Note: leave the `API_TOKEN` at is is.**
5. Run artisan command `php artisan migrate`, this will create the database tables for this project. **Note: Make sure your local server is up and running**
6. Now you can access via browser this project on your localhost.

## Data Seeding
This project has a custom import scripts that will read the csv file located in `storage/app/` and will import those
job records in the database.

To do so, run the command `php artisan run:job-import`
