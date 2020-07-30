# laratickets
real time tickets system for laravel framework

# installation step

composer require asaydev/laratickets

# publishing config file
php artisan vendor:publish --provider="AsayDev\LaraTickets\AsayDevLaraTicketsServiceProvider" --tag="laratickets_config"

# publishing migrations files

php artisan vendor:publish --tag=laratickets_migrations
