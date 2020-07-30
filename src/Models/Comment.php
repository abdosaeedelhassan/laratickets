<?php

namespace AsayDev\LaraTickets\Models;

use Illuminate\Database\Eloquent\Model;
use AsayDev\LaraTickets\Traits\ContentEllipse;
use AsayDev\LaraTickets\Traits\Purifiable;

class Comment extends Model
{
    use ContentEllipse;
    use Purifiable;

    protected $table = 'ticketit_comments';

    /**
     * Get related ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo('AsayDev\LaraTickets\Models\Ticket', 'ticket_id');
    }

    /**
     * Get comment owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('laratickets.user_model'), 'user_id');
    }
}
