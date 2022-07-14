<div>
    <div wire:init="renderLaraTicketsContentEditor">
        <div class="row">
            <div class="col-12">
                <h2 class="mt-5">{{ trans('laratickets::lang.comments') }}</h2>
                <?php
                $comment_order = 0;
                ?>
                @foreach($comments as $comment)

                <div style="padding: 10px;background-color: {{$comment_order%2==0?'#e1f0ff':'white'}}">
                    <div class="row">
                        <div class="col" style="text-align: {{app()->getLocale()=='ar'?'right':'left'}}">
                            <strong>{!! $comment->user->name !!}</strong>
                        </div>
                        <div class="col" style="text-align: {{app()->getLocale()=='ar'?'left':'right'}}">
                            <small class="text-muted"><span class="glyphicon glyphicon-time"></span>
                                @if(auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
                                <i style="color: red" class="fa fa-trash" wire:click="delete({{$comment->id}})"></i>
                                @endif
                                {!! $comment->created_at->format(app()->getLocale()=='ar'?'h:m Y-m-d':'Y-m-d m:h') !!}
                            </small>
                        </div>
                    </div>
                    <p>
                        <?php
                        //$content = preg_replace('/<img style="[^"]*"/', '<img ', $comment->html);
                        //$content= str_replace('<img','<img style="width:100px;height:100px" ',$content);
                        $time = time();
                        $content = preg_replace('/<img.*src="(.*?)".*?>/', '<a download="' . time() . '-img.jpg"
                            href="\1" target="_blank"><img id="img-' . $comment->id . '"
                                style="width:100px;height:100px" src="\1" /></a>', $comment->html);
                        echo $content;
                        ?>
                    </p>
                    <p>
                        @if($comment->attachments)
                        @foreach(json_decode($comment->attachments) as $attachment)
                        <a href="{{asset('storage/'.$attachment)}}" target="_blank"><i class="bi bi-paperclip"></i></a>
                        @endforeach
                        @endif
                    </p>
                </div>
                <?php
                $comment_order++;
                ?>
                @endforeach
                {{-- {{ $comments->render() }} --}}
            </div>
        </div>
        @if(!$ticket->completed_at)
        <div class="row mt-3">
            <div class="col-sm-11" wire:ignore>
                <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal"
                    data-bs-target="#repliesModal">
                    {{ trans('laratickets::lang.select-reply') }}
                </button>
                <textarea rows="5" id="editorContent" class="form-control" name="editorContent" wire:model="content"
                    autocomplete="off">{{ $content }}</textarea>
                <button wire:click="addComment" class="btn btn-outline-primary pull-right mt-3 mb-3">
                    {{trans('laratickets::lang.reply')}}
                </button>
            </div>
        </div>
        @endif
    </div>

</div>