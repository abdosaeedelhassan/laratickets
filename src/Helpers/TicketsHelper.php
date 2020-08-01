<?php

namespace AsayDev\LaraTickets\Helpers;


use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;

class TicketsHelper
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

        $data=$collection
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

        $data->map(function ($column){

            // need to add onclick wire

//            $column->subject=(string) link_to_route(
//                Setting::grab('main_route').'.show',
//                $column->subject,
//                $column->id
//            );

            $column->status="<div style='color: $column->color_status'>e($column->status)</div>";
            $column->priority="<div style='color: $column->color_priority'>e($column->priority)</div>";
            $column->category="<div style='color: $column->color_category'>e($column->category)</div>";

            $ticket=Ticket::find($column->id);
            $column->agent=e($ticket->agent->name);

            return $column;
        });


        return $data;
    }



}
