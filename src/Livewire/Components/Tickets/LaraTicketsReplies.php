<?php

namespace AsayDev\LaraTickets\Livewire\Components\Tickets;

use AsayDev\LaraTickets\Models\Replies;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsReplies extends Component
{

    public $reply_id;
    public $title;
    public $content;
    protected $listeners = ['setContent'];

    public $container = 'form';

    public $collapse_id;


    public function mount($container = 'form')
    {
        $this->container = $container;
    }


    public function setContent($content)
    {
        $this->content = $content;
    }

    public function initForm()
    {
        $this->emit('renderLaraTicketsContentEditor', '');
    }


    public function render()
    {
        return view('asaydev-lara-tickets::components.tickets.replies', [
            'replies' => Replies::all()
        ]);
    }

    public function saveData()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required|min:6',
        ], [], [
            'title' => trans('laratickets::lang.title'),
            'content' => trans('laratickets::lang.reply')
        ]);

        if ($this->reply_id) {
            Replies::where('id', $this->reply_id)->update([
                'title' => $this->title,
                'content' => $this->content
            ]);
        } else {
            Replies::create([
                'title' => $this->title,
                'content' => $this->content
            ]);
        }
        $this->title = '';
        $this->content = '';
        $this->reply_id = null;
        $this->emit('cleartext', '');
        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::admin.nav-ticket-replies'), trans('laratickets::lang.table-saved-success'));
        $this->emit('laratickets-flash-message', $msg);
    }

    public function doAction($id)
    {
        $reply = Replies::where('id', $id)->first();
        if ($reply) {
            if ($this->container == 'form') {
                $this->reply_id = $id;
            }
            $this->title = $reply->title;
            $this->emit('setLaraTicketsCKEditorContent', $reply->content);
        }
    }

    public function display($id)
    {
        if ($this->collapse_id == $id) {
            $this->collapse_id = null;
        } else {
            $this->collapse_id = $id;
        }
    }

    public function delete($id)
    {
        Replies::where('id', $id)->delete();
        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::admin.nav-ticket-replies'), trans('laratickets::lang.table-deleted-success'));
        $this->emit('laratickets-flash-message', $msg);
    }
}
