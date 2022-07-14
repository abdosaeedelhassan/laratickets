<?php

namespace AsayDev\LaraTickets\Models;

use Auth;
use AsayDev\LaraTickets\Models\ParentUserModel;

class Agent extends ParentUserModel
{
    protected $table = 'users';

    protected $appends = ['full_name'];

    public function scopeAgents($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('laratickets_agent', '1')->paginate($paginate, ['*'], 'agents_page');
        } else {
            return $query->where('laratickets_agent', '1');
        }
    }

    public function scopeAdmins($query, $paginate = false)
    {
        /**
         * if no laratickets_admin set default one
         */
        $adminAgent = \AsayDev\LaraTickets\Models\Agent::where('laratickets_admin', 1)->first();
        if (!$adminAgent) {
            $adminAgent = \AsayDev\LaraTickets\Models\Agent::first();
            if ($adminAgent) {
                \AsayDev\LaraTickets\Models\Agent::where('id', $adminAgent->id)->update(['laratickets_admin' => 1]);
            }
        }

        if ($paginate) {
            return $query->where('laratickets_admin', '1')->paginate($paginate, ['*'], 'admins_page');
        } else {
            return $query->where('laratickets_admin', '1')->get();
        }
    }

    public function scopeUsers($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('laratickets_agent', '0')->paginate($paginate, ['*'], 'users_page');
        } else {
            return $query->where('laratickets_agent', '0')->get();
        }
    }

    public function scopeAgentsLists($query)
    {
        if (version_compare(app()->version(), '5.2.0', '>=')) {
            return $query->where('laratickets_agent', '1')->pluck('name', 'id')->toArray();
        } else { // if Laravel 5.1
            return $query->where('laratickets_agent', '1')->lists('name', 'id')->toArray();
        }
    }

    public static function isAgent($id = null)
    {
        if (isset($id)) {
            $user = ParentUserModel::find($id);
            if ($user->laratickets_agent) {
                return true;
            }

            return false;
        }
        if (auth()->check()) {
            if (auth()->user()->laratickets_agent) {
                return true;
            }
        }

        return false;
    }


    public static function laratickets_isAdmin()
    {
        return auth()->check() && auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator'));
    }

    public static function isAssignedAgent($id)
    {
        return auth()->check() &&
            Auth::user()->laratickets_agent &&
            Auth::user()->id == Ticket::find($id)->agent->id;
    }

    public static function isTicketOwner($id)
    {
        $ticket = Ticket::find($id);
        return $ticket && auth()->check() &&
            auth()->user()->id == $ticket->user->id;
    }

    public function categories()
    {
        return $this->belongsToMany('AsayDev\LaraTickets\Models\Category', 'laratickets_categories_users', 'user_id', 'category_id');
    }

    public function agentTickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'agent_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'agent_id')->whereNull('completed_at');
        }
    }

    public function userTickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'user_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'user_id')->whereNull('completed_at');
        }
    }

    public function tickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'user_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'user_id')->whereNull('completed_at');
        }
    }

    public function allTickets($complete = false) // (To be deprecated)
    {
        if ($complete) {
            return Ticket::whereNotNull('completed_at');
        } else {
            return Ticket::whereNull('completed_at');
        }
    }

    public function getTickets($complete = false) // (To be deprecated)
    {
        $user = self::find(auth()->user()->id);

        if ($user->laratickets_isAdmin()) {
            $tickets = $user->allTickets($complete);
        } elseif ($user->isAgent()) {
            $tickets = $user->agentTickets($complete);
        } else {
            $tickets = $user->userTickets($complete);
        }

        return $tickets;
    }

    public function agentTotalTickets()
    {
        return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'agent_id');
    }

    public function agentCompleteTickets()
    {
        return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'agent_id')->whereNotNull('completed_at');
    }

    public function agentOpenTickets()
    {
        return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'agent_id')->whereNull('completed_at');
    }

    public function userTotalTickets()
    {
        return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'user_id');
    }

    public function userCompleteTickets()
    {
        return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'user_id')->whereNotNull('completed_at');
    }

    public function userOpenTickets()
    {
        return $this->hasMany('AsayDev\LaraTickets\Models\Ticket', 'user_id')->whereNull('completed_at');
    }
}
