<?php

namespace AsayDev\LaraTickets\Models;

use Illuminate\Database\Eloquent\Model;
use AsayDev\LaraTickets\Traits\ContentEllipse;
use AsayDev\LaraTickets\Traits\Purifiable;

class Comment extends Model
{
    use ContentEllipse;
    use Purifiable;

    protected $table = 'laratickets_comments';


    protected $fillable = [
        'content', 'html', 'user_id', 'ticket_id', 'attachments', 'created_at', 'updated_at'
    ];


    public function ticket()
    {
        return $this->belongsTo('AsayDev\LaraTickets\Models\Ticket', 'ticket_id');
    }


    public function user()
    {
        return $this->belongsTo(config('laratickets.user_model'), 'user_id');
    }
}
