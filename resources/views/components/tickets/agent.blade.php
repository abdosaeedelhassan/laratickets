<?php
$ticket=\AsayDev\LaraTickets\Models\Ticket::find($column->id);
?>
{{e($ticket->agent->name)}}
