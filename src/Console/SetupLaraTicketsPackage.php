<?php

namespace AsayDev\LaraTickets\Console;

use AsayDev\LaraTickets\Models\Agent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SetupLaraTicketsPackage extends Command
{
    protected $signature = 'laratickets:setup';

    protected $description = 'Setup LaraTickets roles and permissions';

    public function handle()
    {

        /**
         * 1- check default roles is created
         */
        $this->info('1- Publishing required roles');
        $role = Role::firstOrCreate(['name' => config('laratickets.roles.laratickets_administrator')]);
        /**
         * 2- check default permissions is created
         */
        $this->info('2- Publishing required permissions');
        foreach (array_values(config('laratickets.permissions')) as $name) {
            $permission = Permission::firstOrCreate(['name' => $name]);
        }
        /**
         * 3- check default permissions is created
         */
        $this->info('3- Setup administrator role');

        $admin_id = $this->askValid(
            "What's administrator user ID",
            "id",
            ['required', 'numeric', 'exists:users,id']
        );
        $user = Agent::where('id', $admin_id)->first();
        if ($user) {
            $user->assignRole(config('laratickets.roles.laratickets_administrator'));
        }

        $this->info('LaraTickets setup successfully...');
    }

    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
