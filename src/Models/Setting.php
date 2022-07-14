<?php

namespace AsayDev\LaraTickets\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $table = 'laratickets_settings';
}
