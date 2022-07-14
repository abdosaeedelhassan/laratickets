<?php

namespace AsayDev\LaraTickets\Helpers;


use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;

class  TicketsHelper
{

    public static $tickets_new_status = 1;
    public static $tickets_opened_status = 2;
    public static $tickets_closed_status = 3;

    public static function getTicketsStatues($status): array
    {
        return [
            self::$tickets_new_status => __('New'),
            self::$tickets_opened_status => __('Opened'),
            self::$tickets_closed_status => __('Closed')
        ];
    }

    public static function userCan($permission)
    {
        if (auth()->user()->hasPermissionTo($permission) || auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator'))) {
            return true;
        }
        return false;
    }


    public static function getTicketStatusLabel($status)
    {
        if ($status == 1) {
            return trans('laratickets::lang.new');
        } elseif ($status == 2) {
            return trans('laratickets::lang.opened');
        } elseif ($status == 3) {
            return trans('laratickets::lang.closed');
        } else {
            return '';
        }
    }


    public static function getTicketsCollection($model, $model_id, $status = null)
    {
        $collection = Ticket::with(['createdby', 'priority'])->where('model', $model);
        if ($model === 'orders') {
            $collection = $collection->where('model_id', $model_id);
        }
        if (!auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_display_all')) && !auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator'))) {
            $collection = Ticket::with(['createdby', 'priority'])
                ->where('model_id', $model_id)
                ->where('user_id', auth()->user()->id);
        }
        if ($status) {
            return  self::getTicketsWithStatus($collection, $status);
        }
        return $collection;
    }

    public static function getTicketsWithStatus($model, $status)
    {
        if ($status === 'active') {
            $model = $model->whereNull('completed_at');
        } else if ($status == 'completed') {
            $model = $model->whereNotNull('completed_at');
        } else if ($status == 'waitingClientReply') {
            $model = $model->whereNull('completed_at')->whereColumn('user_id', '<>', 'last_comment_by');
        } else if ($status == 'waitingManagingReply') {
            $model = $model->whereNull('completed_at')->whereColumn('user_id', 'last_comment_by');
        }
        return $model;
    }

    public function data($complete = false)
    {
        $user = Agent::find(auth()->user()->id);

        if ($user->laratickets_hasRole(config('laratickets.roles.laratickets_administrator'))) {
            if ($complete) {
                $collection = Ticket::complete();
            } else {
                $collection = Ticket::active();
            }
        } elseif ($user->isAgent()) {
            if ($complete) {
                $collection = Ticket::complete()->agentUserTickets($user->id);
            } else {
                $collection = Ticket::active()->agentUserTickets($user->id);
            }
        } else {
            if ($complete) {
                $collection = Ticket::userTickets($user->id)->complete();
            } else {
                $collection = Ticket::userTickets($user->id)->active();
            }
        }

        $data = $collection
            ->join('users', 'users.id', '=', 'laratickets.user_id')
            ->join('laratickets_statuses', 'laratickets_statuses.id', '=', 'laratickets.status_id')
            ->join('laratickets_priorities', 'laratickets_priorities.id', '=', 'laratickets.priority_id')
            ->join('laratickets_categories', 'laratickets_categories.id', '=', 'laratickets.category_id')
            ->select([
                'laratickets.id',
                'laratickets.subject AS subject',
                'laratickets_statuses.name AS status',
                'laratickets_statuses.color AS color_status',
                'laratickets_priorities.color AS color_priority',
                'laratickets_categories.color AS color_category',
                'laratickets.id AS agent',
                'laratickets.updated_at AS updated_at',
                'laratickets_priorities.name AS priority',
                'users.name AS owner',
                'laratickets.agent_id',
                'laratickets_categories.name AS category',
            ])->get();

        $data->map(function ($column) {
            $column->status = TicketsHelper::getTicketStatusLabel($column->status);
            $column->priority = "<div style='color: $column->color_priority'>e($column->priority)</div>";
            $column->category = "<div style='color: $column->color_category'>e($column->category)</div>";
            $ticket = Ticket::find($column->id);
            $column->agent = e($ticket->agent->name);
            return $column;
        });


        return $data;
    }

    public static function getDefaultPriorityInSetting($key)
    {
        $setting = \AsayDev\LaraTickets\Models\Setting::where('key', $key)->first();
        if (!$setting) {
            $priority = \AsayDev\LaraTickets\Models\Priority::create([
                'name' => 'Default',
                'color' => 'green'
            ]);
            $setting = \AsayDev\LaraTickets\Models\Setting::create([
                'key' => $key,
                'value' => $priority->id,
            ]);
        }
        return $setting;
    }

    public static function getDefaultSetting($key, $default)
    {
        $setting = \AsayDev\LaraTickets\Models\Setting::where('key', $key)->first();
        if (!$setting) {
            $setting = \AsayDev\LaraTickets\Models\Setting::create([
                'key' => $key,
                'value' => $default,
            ]);
        }
        return $setting;
    }

    /**
     * next function to be removed
     */
    public static function permTo($user_id, $ticket_id, $type)
    {

        if ($type == 'close') {
            $ticket_perm = self::getDefaultSetting('close_ticket_perm', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}')->value;
        } else if ($type == 'reopen') {
            $ticket_perm = self::getDefaultSetting('reopen_ticket_perm', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}')->value;
        } else {
            return 'no';
        }

        $agent = Agent::find($user_id);

        $ticket_perm = unserialize($ticket_perm);

        if ($agent->laratickets_hasRole(config('laratickets.roles.laratickets_administrator')) && $ticket_perm['admin'] == 'yes') {
            return 'yes';
        }
        if ($agent->isAgent() && $ticket_perm['agent'] == 'yes') {
            return 'yes';
        }
        if ($agent->isTicketOwner($ticket_id) && $ticket_perm['owner'] == 'yes') {
            return 'yes';
        }

        return 'no';
    }

    public static function generateCode($size)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $size; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $currentTime = time();
        return substr($currentTime, strlen($currentTime) - 8, strlen($currentTime) - 1) . '-' . $randomString;
    }


    public static function general()
    {
        // Passing to views the master view value from the setting file
        view()->composer('laratickets::*', function ($view) {
            //$tools = new ToolsController();
            // $master = Setting::grab('master_template');

            $email = TicketsHelper::getDefaultSetting('email.template', 'laratickets::resources.email.templates.laratickets')->value;
            $view->with(compact(/*'master',*/'email'/*, 'tools'*/));
        });
    }


    public static function getSetting($key, $default)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return $default;
    }

    public static function saveSetting($key, $value)
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            Setting::create([
                'key' => $key,
                'value' => $value
            ]);
        } else {
            $setting->value = $value;
            $setting->save();
        }
    }
}
