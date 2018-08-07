[![Build Status](https://travis-ci.com/shibby/league-simulation.svg?branch=master)](https://travis-ci.com/shibby/league-simulation)

## Installation

Copy&fill environment file

    cp .env.example .env
    
Install dependencies

    composer install
    
Generate security key

    php artisan key:generate
    
Install frontend dependencies

    yarn install
    
Build frontend

    yarn build     
    
Migrate your database

    php artisan migrate --seed
    
Serve project

    php artisan serve

