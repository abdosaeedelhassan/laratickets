<?php

return [
    'user_model' => \App\Models\User::class,
    'user_profile_path' => '/admin/auth/users/{id}/edit',
    'roles' => [
        'laratickets_administrator' => 'administrator',
    ],
    'permissions' => [
        'laratickets_add' => 'ticket_add',
        'laratickets_edit' => 'ticket_edit',
        'laratickets_delete' => 'ticket_delete',
        'laratickets_show' => 'ticket_show',
        'laratickets_main_page' => 'ticket_main_page',
        'laratickets_active' => 'ticket_active',
        'laratickets_waiting_client_reply' => 'ticket_waiting_client_reply',
        'laratickets_waiting_managing_reply' => 'ticket_waiting_managing_reply',
        'laratickets_closed' => 'ticket_closed',
        'laratickets_managing' => 'ticket_managing',
        'laratickets_display_all' => 'ticket_display_all',
    ]
];
