<div>
    <div wire:init="renderContentEditor">
       <div class="row">
          <div class="col-12">
              <h2 class="mt-5">{{ trans('laratickets::lang.comments') }}</h2>
              @foreach($comments as $comment)
                  <div class="card mb-3 {!! $comment->user->tickets_role ? "border-info" : "" !!}">
                      <div
                          class="card-header d-flex justify-content-between align-items-baseline flex-wrap {!! $comment->user->tickets_role ? "bg-info text-white" : "" !!}">
                          <div>{!! $comment->user->name !!}</div>
                          <div>{!! $comment->created_at->diffForHumans() !!}</div>
                      </div>
                      <div class="card-body pb-0">
                          {!! $comment->html !!}
                      </div>
                  </div>
              @endforeach
              {{ $comments->links() }}
          </div>
       </div>
        <div class="row">
            <div class="col-sm-11" wire:ignore>
            <textarea rows="5" id="content" class="form-control" name="content" wire:model="content"
                      autocomplete="off">{{ $content }}</textarea>
                <button wire:click="addComment" class="btn btn-outline-primary pull-right mt-3 mb-3">
                    {{trans('laratickets::lang.reply')}}
                </button>
            </div>
        </div>
    </div>
</div>
