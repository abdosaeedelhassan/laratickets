<?php

namespace AsayDev\LaraTickets\Controllers;

use App\Http\Controllers\Controller;
use AsayDev\LaraTickets\Helpers\LaravelVersion;
use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Comment;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Notifications\TicketitNotification;
use Illuminate\Support\Facades\Mail;

class NotificationsController extends Controller
{
    public function newComment(Comment $comment)
    {
        $ticket = $comment->ticket;
        $notification_owner = $comment->user;
        $template = 'laratickets::resources.mail.comment';
        $data = ['comment' => serialize($comment), 'ticket' => serialize($ticket)];
        $this->sendNotification($template, $data, $ticket, $notification_owner,
          trans('laratickets::lang.notify-new-comment-from').$notification_owner->name.trans('laratickets::lang.notify-on').$ticket->subject, 'comment');
    }

    public function ticketStatusUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = auth()->user();
        $template = 'laratickets::emails.status';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket'    => serialize($original_ticket),
        ];

        if (strtotime($ticket->completed_at)) {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('laratickets::lang.notify-updated').$ticket->subject.trans('laratickets::lang.notify-status-to-complete'), 'status');
        } else {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('laratickets::lang.notify-updated').$ticket->subject.trans('laratickets::lang.notify-status-to').$ticket->status->name, 'status');
        }
    }

    public function ticketAgentUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = auth()->user();
        $template = 'laratickets::emails.transfer';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket'    => serialize($original_ticket),
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('laratickets::lang.notify-transferred').$ticket->subject.trans('laratickets::lang.notify-to-you'), 'agent');
    }

    public function newTicketNotifyAgent(Ticket $ticket)
    {
        $notification_owner = auth()->user();
        $template = 'laratickets::emails.assigned';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('laratickets::lang.notify-created-ticket').$ticket->subject, 'agent');
    }

    /**
     * Send email notifications from the action owner to other involved users.
     *
     * @param string $template
     * @param array  $data
     * @param object $ticket
     * @param object $notification_owner
     */
    public function sendNotification($template, $data, $ticket, $notification_owner, $subject, $type)
    {
        /**
         * @var User
         */
        $to = null;

        if ($type != 'agent') {
            $to = $ticket->user;

            if ($ticket->user->email != $notification_owner->email) {
                $to = $ticket->user;
            }

            if ($ticket->agent->email != $notification_owner->email) {
                $to = $ticket->agent;
            }
        } else {
            $to = $ticket->agent;
        }

        $queue_emails = TicketsHelper::getDefaultSetting('email.template', '0')->value;
        $mail = new TicketitNotification($template, $data, $notification_owner, $subject);
        try {
            if ($queue_emails == 1) {
                Mail::to($to)->queue($mail);
            } else {
                Mail::to($to)->send($mail);
            }
        }catch (\Exception $e){
            //
        }
    }
}
