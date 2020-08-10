<?php

namespace AsayDev\LaraTickets\Helpers;


use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use Illuminate\Support\Str;

class  TicketsHelper
{

    public function data($complete = false)
    {
        $user = Agent::find(auth()->user()->id);

        if ($user->laratickets_isAdmin()) {
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
                'users.first_name AS owner',
                'laratickets.agent_id',
                'laratickets_categories.name AS category',
            ])->get();

        $data->map(function ($column) {
            $column->status = "<div style='color: $column->color_status'>e($column->status)</div>";
            $column->priority = "<div style='color: $column->color_priority'>e($column->priority)</div>";
            $column->category = "<div style='color: $column->color_category'>e($column->category)</div>";
            $ticket = Ticket::find($column->id);
            $column->agent = e($ticket->agent->name);
            return $column;
        });


        return $data;
    }


    public static function getDefaultStatusInSetting($key)
    {
        $setting = \AsayDev\LaraTickets\Models\Setting::where('slug', $key)->first();
        if (!$setting) {
            $status = \AsayDev\LaraTickets\Models\Status::create([
                'name' => 'Default',
                'color' => 'green'
            ]);
            $setting = \AsayDev\LaraTickets\Models\Setting::create([
                'lang' => Str::random(5),
                'slug' => $key,
                'value' => $status->id,
                'default' => $status->id,
            ]);
        }
        return $setting;
    }

    public static function getDefaultPriorityInSetting($key)
    {
        $setting = \AsayDev\LaraTickets\Models\Setting::where('slug', $key)->first();
        if (!$setting) {
            $priority = \AsayDev\LaraTickets\Models\Priority::create([
                'name' => 'Default',
                'color' => 'green'
            ]);
            $setting = \AsayDev\LaraTickets\Models\Setting::create([
                'lang' => Str::random(5),
                'slug' => $key,
                'value' => $priority->id,
                'default' => $priority->id,
            ]);
        }
        return $setting;
    }

    public static function getDefaultSetting($key, $default)
    {
        $setting = \AsayDev\LaraTickets\Models\Setting::where('slug', $key)->first();
        if (!$setting) {
            $setting = \AsayDev\LaraTickets\Models\Setting::create([
                'lang' => Str::random(5),
                'slug' => $key,
                'value' => $default,
                'default' => $default,
            ]);
        }
        return $setting;
    }

    public static function permTo($user_id, $ticket_id,$type)
    {

        if($type=='close'){
            $ticket_perm = self::getDefaultSetting('close_ticket_perm', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}')->value;
        }else if($type=='reopen'){
            $ticket_perm = self::getDefaultSetting('reopen_ticket_perm', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}')->value;
        }else{
            return 'no';
        }

        $agent = Agent::find($user_id);

        $ticket_perm=unserialize($ticket_perm);

        if ($agent->laratickets_isAdmin() && $ticket_perm['admin'] == 'yes') {
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
            $view->with(compact(/*'master',*/ 'email'/*, 'tools'*/));
        });
    }


}
