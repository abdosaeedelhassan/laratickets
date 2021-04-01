<?php


namespace AsayDev\LaraTickets\Helpers;


use Illuminate\Support\Facades\Schema;

class GlobalHelper
{

    public static function getUsersNameField()
    {
        if (Schema::hasColumn('users', 'first_name')) {
            return 'first_name';
        } else {
            return 'name';
        }

    }


}
