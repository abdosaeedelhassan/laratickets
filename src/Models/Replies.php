<?php

namespace AsayDev\LaraTickets\Models;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{

    protected $table = 'laratickets_replies';

    protected $fillable = [
        'title', 'content',
    ];
}
