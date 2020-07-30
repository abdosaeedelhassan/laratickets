<?php

namespace AsayDev\LaraTickets;

use AsayDev\LaraTickets\Console\InstallLaraTicketsPackage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Class AsayDevTicketsServiceProvider.
 */
class AsayDevLaraTicketsServiceProvider extends ServiceProvider
{


    public function boot()
    {
        /**
         * step1: register package installer command
         */
        if ($this->app->runningInConsole()) {
            // publish config file
            $this->commands([
                InstallLaraTicketsPackage::class,
            ]);
        }
        /**
         * step2: publishing package config file in artisan
         */
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laratickets.php' => config_path('laratickets.php'),
            ], 'laratickets_config');

        }
        /**
         * step3: publishing package migrations files if not exists
         */
        $this->publishMigration('AlterUsersTable', '2020_08_30_115514_alter_users_table');
        $this->publishMigration('CreateLaraTicketsTables', '2020_08_30_115516_create_lara_tickets_tables');
        $this->publishMigration('AddIndexes', '2020_08_30_120557_add_indexes');
        $this->publishMigration('CreateLaraTicketsSettingsTable', '2020_08_30_123457_create_lara_tickets_settings_table');
        /**
         * step4: setup laravel User model aliases to used in package extends
         */
        if (!class_exists('ParentUserModel')) {
            class_alias(config("laratickets.user_model"), 'AsayDev\LaraTickets\Models\ParentUserModel');
        }
        /**
         *
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'asaydev-lara-tickets');
    }


    /**
     * publish migration file
     */
    private function publishMigration($class_name, $file_name)
    {
        if (!class_exists($class_name)) {
            $this->publishes([
                __DIR__ . '/../database/migrations/' . $file_name.'.php' => database_path('migrations/' . $file_name . '.php'),
            ], 'laratickets_migrations');
        }
    }


    /**
     * to be removed after finishing
     */
    public function bootFromOldPackage()
    {

        /*

        $installer = new InstallController();

        // if a migration or new setting is missing scape to the installation
        if (empty($installer->inactiveMigrations()) && !$installer->inactiveSettings()) {
            // Send the Agent User model to the view under $u
            // Send settings to views under $setting

            //cache $u
            $u = null;

            TicketItComposer::settings($u);

            // Adding HTML5 color picker to form elements
            CollectiveForm::macro('custom', function ($type, $name, $value = '#000000', $options = []) {
                $field = $this->input($type, $name, $value, $options);

                return $field;
            });

            TicketItComposer::general();
            TicketItComposer::codeMirror();
            TicketItComposer::sharedAssets();
            TicketItComposer::summerNotes();

            // Send notification when new comment is added
            Comment::creating(function ($comment) {
                if (Setting::grab('comment_notification')) {
                    $notification = new NotificationsController();
                    $notification->newComment($comment);
                }
            });

            // Send notification when ticket status is modified
            Ticket::updating(function ($modified_ticket) {
                if (Setting::grab('status_notification')) {
                    $original_ticket = Ticket::find($modified_ticket->id);
                    if ($original_ticket->status_id != $modified_ticket->status_id || $original_ticket->completed_at != $modified_ticket->completed_at) {
                        $notification = new NotificationsController();
                        $notification->ticketStatusUpdated($modified_ticket, $original_ticket);
                    }
                }
                if (Setting::grab('assigned_notification')) {
                    $original_ticket = Ticket::find($modified_ticket->id);
                    if ($original_ticket->agent->id != $modified_ticket->agent->id) {
                        $notification = new NotificationsController();
                        $notification->ticketAgentUpdated($modified_ticket, $original_ticket);
                    }
                }

                return true;
            });

            // Send notification when ticket status is modified
            Ticket::created(function ($ticket) {
                if (Setting::grab('assigned_notification')) {
                    $notification = new NotificationsController();
                    $notification->newTicketNotifyAgent($ticket);
                }

                return true;
            });

            $this->loadTranslationsFrom(__DIR__.'/Translations', 'ticketit');

            $viewsDirectory = __DIR__.'/Views/bootstrap3';
            if (Setting::grab('bootstrap_version') == '4') {
                $viewsDirectory = __DIR__.'/Views/bootstrap4';
            }

            $this->loadViewsFrom($viewsDirectory, 'ticketit');

            $this->publishes([$viewsDirectory => base_path('resources/views/vendor/ticketit')], 'views');
            $this->publishes([__DIR__.'/Translations' => base_path('resources/lang/vendor/ticketit')], 'lang');
            $this->publishes([__DIR__.'/Public' => public_path('vendor/ticketit')], 'public');

            // Check public assets are present, publish them if not
//            $installer->publicAssets();

            $main_route = Setting::grab('main_route');
            $main_route_path = Setting::grab('main_route_path');
            $admin_route = Setting::grab('admin_route');
            $admin_route_path = Setting::grab('admin_route_path');

            if (file_exists(Setting::grab('routes'))) {
                include Setting::grab('routes');
            } else {
                include __DIR__.'/routes.php';
            }
        } elseif (Request::path() == 'tickets-install'
            || Request::path() == 'tickets-upgrade'
            || Request::path() == 'tickets'
            || Request::path() == 'tickets-admin'
            || (isset($_SERVER['ARTISAN_TICKETIT_INSTALLING']) && $_SERVER['ARTISAN_TICKETIT_INSTALLING'])) {
            $this->loadTranslationsFrom(__DIR__ . '/Translations', 'ticketit');
            $this->loadViewsFrom(__DIR__ . '/Views/bootstrap3', 'ticketit');
            $this->publishes([__DIR__ . '/Migrations' => base_path('database/migrations')], 'db');

            $authMiddleware = Helpers\LaravelVersion::authMiddleware();

            Route::get('/tickets-install', [
                'middleware' => $authMiddleware,
                'as' => 'tickets.install.index',
                'uses' => 'Kordy\Ticketit\Controllers\InstallController@index',
            ]);
            Route::post('/tickets-install', [
                'middleware' => $authMiddleware,
                'as' => 'tickets.install.setup',
                'uses' => 'Kordy\Ticketit\Controllers\InstallController@setup',
            ]);
            Route::get('/tickets-upgrade', [
                'middleware' => $authMiddleware,
                'as' => 'tickets.install.upgrade',
                'uses' => 'Kordy\Ticketit\Controllers\InstallController@upgrade',
            ]);
            Route::get('/tickets', function () {
                return redirect()->route('tickets.install.index');
            });
            Route::get('/tickets-admin', function () {
                return redirect()->route('tickets.install.index');
            });
        }

        */
    }


}
