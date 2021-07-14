<?php

namespace AsayDev\LaraTickets;

use AsayDev\LaraTickets\Console\InstallLaraTicketsPackage;
use AsayDev\LaraTickets\Controllers\NotificationsController;
use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Livewire\Components\Admins\LaraTicketsAdminsForm;
use AsayDev\LaraTickets\Livewire\Components\Admins\LaraTicketsAdminsTable;
use AsayDev\LaraTickets\Livewire\Components\Admins\LaraTicketsAdminsTabs;
use AsayDev\LaraTickets\Livewire\Components\Agents\LaraTicketsAgentsForm;
use AsayDev\LaraTickets\Livewire\Components\Agents\LaraTicketsAgentsTable;
use AsayDev\LaraTickets\Livewire\Components\Categories\LaraTicketsCategoriesForm;
use AsayDev\LaraTickets\Livewire\Components\Categories\LaraTicketsCategoriesTable;
use AsayDev\LaraTickets\Livewire\Components\Configuration\LaraTicketsConfigurationForm;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsActiveTickets;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsAdministrator;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsAgents;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsCategories;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsCommentForm;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsCompletedTickets;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsConfiguration;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsMain;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsPriorities;
use AsayDev\LaraTickets\Livewire\Components\LaraTicketsStatuses;
use AsayDev\LaraTickets\Livewire\Components\Configuration\LaraTicketsConfigurationTable;
use AsayDev\LaraTickets\Livewire\Components\Priorities\LaraTicketsPrioritiesForm;
use AsayDev\LaraTickets\Livewire\Components\Priorities\LaraTicketsPrioritiesTable;
use AsayDev\LaraTickets\Livewire\Components\Statuses\LaraTicketsStatusesForm;
use AsayDev\LaraTickets\Livewire\Components\Statuses\LaraTicketsStatusesTable;
use AsayDev\LaraTickets\Livewire\Components\Tickets\LaraTicketsForm;
use AsayDev\LaraTickets\Livewire\Components\Tickets\LaraTicketsViewer;
use AsayDev\LaraTickets\Livewire\LaraTicketsDashboard;
use AsayDev\LaraTickets\Livewire\Layouts\LaraTicketsContent;
use \AsayDev\LaraTickets\Livewire\Components\Tickets\LaraTicketsTable;
use AsayDev\LaraTickets\Models\Comment;
use AsayDev\LaraTickets\Models\Ticket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
        $this->publishMigration('CreateLaraTicketsSettingsTable', '2020_08_30_123457_create_lara_tickets_settings_table');
        $this->publishMigration('AddIndexes', '2020_08_31_120557_add_indexes');
        /**
         * step4: setup laravel User model aliases to used in package extends
         */
        if (!class_exists('AsayDev\LaraTickets\Models\ParentUserModel')) {
            if(config("laratickets.user_model")){
                class_alias(config("laratickets.user_model"), 'AsayDev\LaraTickets\Models\ParentUserModel');
            }else{
                class_alias('App\User', 'AsayDev\LaraTickets\Models\ParentUserModel');
            }

        }
        /**
         * step5: registering
         */
        Livewire::component('lara-tickets-dashboard', LaraTicketsDashboard::class);
        Livewire::component('lara-tickets-content', LaraTicketsContent::class);

        Livewire::component('lara-tickets-main', LaraTicketsMain::class);

        Livewire::component('lara-tickets-tickets-table', LaraTicketsTable::class);
        Livewire::component('lara-tickets-form', LaraTicketsForm::class);
        Livewire::component('lara-tickets-viewer', LaraTicketsViewer::class);


        Livewire::component('lara-tickets-comment-form', LaraTicketsCommentForm::class);

        Livewire::component('lara-tickets-statuses', LaraTicketsStatuses::class);
        Livewire::component('lara-tickets-priorities', LaraTicketsPriorities::class);
        Livewire::component('lara-tickets-agents', LaraTicketsAgents::class);
        Livewire::component('lara-tickets-cateogries', LaraTicketsCategories::class);

        Livewire::component('lara-tickets-configuration-table', LaraTicketsConfigurationTable::class);
        Livewire::component('lara-tickets-configuration-form', LaraTicketsConfigurationForm::class);

        Livewire::component('lara-tickets-categories-table', LaraTicketsCategoriesTable::class);
        Livewire::component('lara-tickets-categories-form', LaraTicketsCategoriesForm::class);

        Livewire::component('lara-tickets-agents-table', LaraTicketsAgentsTable::class);
        Livewire::component('lara-tickets-agents-form', LaraTicketsAgentsForm::class);

        Livewire::component('lara-tickets-priorities-table', LaraTicketsPrioritiesTable::class);
        Livewire::component('lara-tickets-priorities-form', LaraTicketsPrioritiesForm::class);

        Livewire::component('lara-tickets-statuses-table', LaraTicketsStatusesTable::class);
        Livewire::component('lara-tickets-statuses-form', LaraTicketsStatusesForm::class);

        Livewire::component('lara-tickets-admins-tabs', LaraTicketsAdminsTabs::class);
        Livewire::component('lara-tickets-admins-table', LaraTicketsAdminsTable::class);
        Livewire::component('lara-tickets-admins-form', LaraTicketsAdminsForm::class);

        /**
         * register forms components
         */
        /**
         * step6: load package views
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'asaydev-lara-tickets');
        /**
         * step7: load translations files
         */
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laratickets');
        /**
         * step8: publishing assets files
         */
        $this->publishes([
            __DIR__ . '/../assets/css' => public_path('laratickets/css'),
            __DIR__ . '/../assets/js' => public_path('laratickets/js'),
        ], 'laratickets_assets');


        /**
         * step9: register package emails
         */


        /**
         * next for registering mail service
         */
        //TicketsHelper::general();
        //$this->registerNotifications();


    }


    /**
     * publish migration file
     */
    private function publishMigration($class_name, $file_name)
    {
        if (!class_exists($class_name)) {
            $this->publishes([
                __DIR__ . '/../database/migrations/' . $file_name . '.php' => database_path('migrations/' . $file_name . '.php'),
            ], 'laratickets_migrations');
        }
    }

    private function registerNotifications()
    {


        $enable_package_default_mails = TicketsHelper::getDefaultSetting('enable_package_default_mails', '1')->value;
        if ($enable_package_default_mails == 1) {

            $comment_notification = TicketsHelper::getDefaultSetting('comment_notification', '1')->value;
            $status_notification = TicketsHelper::getDefaultSetting('status_notification', '1')->value;
            $assigned_notification = TicketsHelper::getDefaultSetting('assigned_notification', '1')->value;

            // Send notification when new comment is added
            Comment::creating(function ($comment) use ($comment_notification) {
                if ($comment_notification) {
                    $notification = new NotificationsController();
                    $notification->newComment($comment);
                }
                return true;
            });
//
//            // Send notification when ticket status is modified
//            Ticket::updating(function ($modified_ticket)use($status_notification) {
//                if ($status_notification) {
//                    $original_ticket = Ticket::find($modified_ticket->id);
//                    if ($original_ticket->status_id != $modified_ticket->status_id || $original_ticket->completed_at != $modified_ticket->completed_at) {
//                        $notification = new NotificationsController();
//                        $notification->ticketStatusUpdated($modified_ticket, $original_ticket);
//                    }
//                }
//                if ($assigned_notification) {
//                    $original_ticket = Ticket::find($modified_ticket->id);
//                    if ($original_ticket->agent->id != $modified_ticket->agent->id) {
//                        $notification = new NotificationsController();
//                        $notification->ticketAgentUpdated($modified_ticket, $original_ticket);
//                    }
//                }
//
//                return true;
//            });
//
//            // Send notification when ticket status is modified
//            Ticket::created(function ($ticket) {
//                if (Setting::grab('assigned_notification')) {
//                    $notification = new NotificationsController();
//                    $notification->newTicketNotifyAgent($ticket);
//                }
//
//                return true;
//            });


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
