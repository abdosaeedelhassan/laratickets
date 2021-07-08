<?php

namespace AsayDev\LaraTickets\Livewire\Components;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Comment;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;
use Livewire\WithPagination;

class LaraTicketsCommentForm extends Component
{

    use WithPagination;

    /**
     * @var
     * assets vars
     */

    public $ticket;

    public $content='';


    protected $listeners=['setContent'];


    public function setContent($content){
        $this->content=$content;
    }



    public function renderContentEditor(){
        $this->emit('renderContentEditor','');
    }



    public function mount($ticket_id){
        $this->ticket = Ticket::where('id', $ticket_id)->first();
    }
    public function render()
    {
        $paginate_items = TicketsHelper::getDefaultSetting('paginate_items', '10');
        return view('asaydev-lara-tickets::forms.comment',['comments'=>$this->ticket->comments()->orderBy('id','asc')->paginate($paginate_items->value)]);
    }


    public function addComment(){
        if(strlen($this->content)>0){
            $comment = new Comment();
            $comment->html=$this->content;
            $comment->content=strip_tags(html_entity_decode($this->content));
            $comment->ticket_id =$this->ticket->id;
            $comment->user_id = auth()->user()->id;
            $comment->save();
            Ticket::where('id',$comment->ticket_id)->update(['updated_at'=>$comment->created_at]);
            $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::lang.index-my-tickets'), trans('laratickets::lang.comment-has-been-added-ok'));
            $this->emit('laratickets-flash-message', $msg);
            $this->content='';
            $this->emit('cleartext', '');

        }
    }

    public function delete($id){
        Comment::where('id',$id)->delete();
    }

}
