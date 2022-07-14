<div>
    <div class="card" style="width: 100%">
        <div class="card-header" style="width: 100%">
            <div class="d-flex justify-centent-between align-items-center flex-wrap">
                <div>
                    <h4 class="card-title mb-0">
                        {{trans('laratickets::lang.create-ticket-brief-issue')}}
                    </h4>
                </div>
                <!--col-->
                <div>
                    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_edit'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
                    @if(! $ticket->completed_at)
                    <button wire:click="makeAsComplete({{$ticket->id}})" class="btn btn-success">
                        {{trans('laratickets::lang.btn-mark-complete')}}
                    </button>
                    @elseif($ticket->completed_at)
                    <button wire:click="reOpenTicket({{$ticket->id}})" class="btn btn-success">
                        {{trans('laratickets::lang.reopen-ticket')}}
                    </button>
                    @endif
                    <button wire:click="editTicket" class="btn btn-info">
                        {{ trans('laratickets::lang.btn-edit')  }}
                    </button>
                    @endif
                    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_managing'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
                    <button
                        onclick="confirm('{{trans("laratickets::lang.show-ticket-modal-delete-message", ["subject" => $ticket->subject]) }}') || event.stopImmediatePropagation()"
                        wire:click="destroyTicket" class="btn btn-danger">
                        {{ trans('laratickets::lang.btn-delete') }}
                    </button>
                    @endif
                </div>
                <!--col-->
            </div>
        </div>
        <!--row-->
        <div class="card-body row">
            <div class="col-md-6">
                @if($ticket->user)
                <p>
                    <strong>{{ trans('laratickets::lang.owner') }}</strong>
                    <a target="_blank"
                        href="{{str_replace('{id}',$ticket->user->id,config('laratickets.user_profile_path'))}}">
                        {{ trans('laratickets::lang.colon') }}{{ $ticket->user_id == $user->id ? $user->name : ($ticket->user?$ticket->user->name:"") }}
                    </a>
                </p>
                @endif
                <p>
                    <strong>{{ trans('laratickets::lang.status') }}</strong>{{ trans('laratickets::lang.colon') }}
                    <span>{{ \AsayDev\LaraTickets\Helpers\TicketsHelper::getTicketStatusLabel($ticket->status) }}</span>
                </p>
                <p>
                    <strong>{{ trans('laratickets::lang.priority') }}</strong>{{ trans('laratickets::lang.colon') }}
                    <span style="color: {{ $ticket->priority->color }}">
                        {{ $ticket->priority->name }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    <strong>{{ trans('laratickets::lang.responsible') }}</strong>{{ trans('laratickets::lang.colon') }}{{ $ticket->agent_id == $user->id ? $user->name : $ticket->agent->name }}
                </p>
                <p>
                    <strong>{{ trans('laratickets::lang.category') }}</strong>{{ trans('laratickets::lang.colon') }}
                    <span style="color: {{ $ticket->category->color }}">
                        {{ $ticket->category->name }}
                    </span>
                </p>
                <p>
                    <strong>{{ trans('laratickets::lang.created') }}</strong>{{ trans('laratickets::lang.colon') }}{{ $ticket->created_at->diffForHumans() }}
                </p>
                <p>
                    <strong>{{ trans('laratickets::lang.last-update') }}</strong>{{ trans('laratickets::lang.colon') }}{{ $ticket->updated_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <div class="d-flex flex-column w-100">
                <div class="d-flex justify-content-between flex-wrap">
                    <div>
                        <strong>{{trans('laratickets::lang.title') }}</strong>:
                        {!! $ticket->subject !!}
                    </div>
                    <div class="text-muted" style="text-align: {{app()->getLocale()=='ar'?'left':'right'}}">
                        {!! $ticket->created_at->format('h:s Y-m-d') !!}
                    </div>
                </div>
                <div class="mt-5">
                    {!! $ticket->content !!}
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">
            @livewire('lara-tickets-comment-form',['ticket_id'=>$ticket->id])
        </div>
    </div>
    <button wire:click="goback" class="btn btn-link">{{trans('laratickets::lang.btn-back')}}</button>
</div>