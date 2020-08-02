# laratickets
real time tickets system for laravel framework

**Important note:** this package is under development and not completed yet

# Requirements:
- user model must have **isAdmin()** property 


# Package Basics:
- first user in database will be default laratickets admin, may change latter from package configuration


# installation step:

composer require asaydev/laratickets

# publishing config file:
php artisan vendor:publish --provider="AsayDev\LaraTickets\AsayDevLaraTicketsServiceProvider" --tag="laratickets_config"

# publishing migrations files:

php artisan vendor:publish --tag=laratickets_migrations

# publishing assets files:

php artisan vendor:publish --tag=laratickets_assets
