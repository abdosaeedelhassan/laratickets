<?php

namespace AsayDev\LaraTickets\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use AsayDev\LaraTickets\Traits\ContentEllipse;
use AsayDev\LaraTickets\Traits\Purifiable;

class Ticket extends Model
{
    use ContentEllipse;
    use Purifiable;

    protected $table = 'laratickets';
    protected $dates = ['completed_at'];


    protected $fillable = [
        'subject',
        'content',
        'html',
        'code',
        'status_id',
        'priority_id',
        'user_id',
        'model',
        'model_id',
        'updated_at',
        'category_id',
        'completed_at',
        'agent_id',
        'created_at'];


    /**
     * List of completed tickets.
     *
     * @return bool
     */
    public function hasComments()
    {
        return (bool)count($this->comments);
    }

    public function isComplete()
    {
        return (bool)$this->completed_at;
    }

    /**
     * List of completed tickets.
     *
     * @return Collection
     */
    public function scopeComplete($query)
    {
        return $query->whereNotNull('completed_at');
    }

    /**
     * List of active tickets.
     *
     * @return Collection
     */
    public function scopeActive($query)
    {
        return $query->whereNull('completed_at');
    }

    /**
     * Get Ticket status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('AsayDev\LaraTickets\Models\Status', 'status_id');
    }

    /**
     * Get Ticket priority.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo('AsayDev\LaraTickets\Models\Priority', 'priority_id');
    }

    /**
     * Get Ticket category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('AsayDev\LaraTickets\Models\Category', 'category_id');
    }

    /**
     * Get Ticket owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('laratickets.user_model'), 'user_id');
    }

    /**
     * Get Ticket agent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('AsayDev\LaraTickets\Models\Agent', 'agent_id');
    }

    /**
     * Get Ticket comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('AsayDev\LaraTickets\Models\Comment', 'ticket_id');
    }

//    /**
    //     * Get Ticket audits
    //     *
    //     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //     */
    //    public function audits()
    //    {
    //        return $this->hasMany('Kordy\Ticketit\Models\Audit', 'ticket_id');
    //    }
    //

    /**
     * @see Illuminate/Database/Eloquent/Model::asDateTime
     */
    public function freshTimestamp()
    {
        return new Date();
    }

    /**
     * @see Illuminate/Database/Eloquent/Model::asDateTime
     */
    protected function asDateTime($value)
    {
        if (is_numeric($value)) {
            return Date::createFromTimestamp($value);
        } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
            return Date::createFromFormat('Y-m-d', $value)->startOfDay();
        } elseif (!$value instanceof \DateTimeInterface) {
            $format = $this->getDateFormat();

            return Date::createFromFormat($format, $value);
        }

        return Date::instance($value);
    }

    /**
     * Get all user tickets.
     *
     * @param $query
     * @param $id
     *
     * @return mixed
     */
    public function scopeUserTickets($query, $id)
    {
        return $query->where('user_id', $id);
    }

    /**
     * Get all agent tickets.
     *
     * @param $query
     * @param $id
     *
     * @return mixed
     */
    public function scopeAgentTickets($query, $id)
    {
        return $query->where('agent_id', $id);
    }

    /**
     * Get all agent tickets.
     *
     * @param $query
     * @param $id
     *
     * @return mixed
     */
    public function scopeAgentUserTickets($query, $id)
    {
        return $query->where(function ($subquery) use ($id) {
            $subquery->where('agent_id', $id)->orWhere('user_id', $id);
        });
    }

    /**
     * Sets the agent with the lowest tickets assigned in specific category.
     *
     * @return Ticket
     */
    public function autoSelectAgent()
    {
        $cat_id = $this->category_id;
        $agents = Category::find($cat_id)->agents()->with(['agentOpenTickets' => function ($query) {
            $query->addSelect(['id', 'agent_id']);
        }])->get();
        $count = 0;
        $lowest_tickets = 1000000;
        // If no agent selected, select the admin
        $first_admin = Agent::admins()->first();
        if ($first_admin) {
            $selected_agent_id = $first_admin->id;
            foreach ($agents as $agent) {
                if ($count == 0) {
                    $lowest_tickets = $agent->agentOpenTickets->count();
                    $selected_agent_id = $agent->id;
                } else {
                    $tickets_count = $agent->agentOpenTickets->count();
                    if ($tickets_count < $lowest_tickets) {
                        $lowest_tickets = $tickets_count;
                        $selected_agent_id = $agent->id;
                    }
                }
                $count++;
            }
            return $selected_agent_id;
        } else {
            return array('error' => 'No admin user selecetd for tickets, must be at least one admin selecetd');
        }
    }
}
