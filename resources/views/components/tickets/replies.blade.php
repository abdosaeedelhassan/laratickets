<div wire:init="initForm">
    @if ($container=='form')
    <form wire:submit.prevent="saveData">
        <h5> {{trans('laratickets::lang.add-new-reply')}}</h5>
        <div class="row">
            <div class="col-md-12">
                <label for="">{{trans('laratickets::lang.title')}}</label>
                <input type="text" wire:model.lazy="title" class="form-control">
                <div>
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                    <div wire:ignore>
                        <label for="">{{trans('laratickets::lang.reply')}}</label>
                        <textarea rows="5" class="form-control" id="content" wire:model="content"></textarea>
                    </div>
                    <div>
                        @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">@lang('Save')</button>
            </div>
        </div>
    </form>
    <div class="row mt-5">
        <div class="col-md-12">
            <h5>
                {{trans('laratickets::admin.nav-ticket-replies')}}             
            </h5>
        </div>
    </div>
    @endif
        <div class="row">
            <div class="col-md-12">
                @foreach($replies as $reply)
                <div class="row m-5">
                    <div class="col-md-12">
                         <div style="padding: 5px;background-color: #e2e0e9">

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>
                                        {{$reply->title}}
                                    </h5>
                                </div>
                                <div class="col-md-6" align="{{app::getLocale()=='ar'?'left':'right'}}">
                                    <a wire:click="display({{$reply->id}})" class="btn btn-dark">
                                        {{trans('laratickets::lang.display')}}
                                    </a>
                                    <a wire:click="doAction({{$reply->id}})" class="btn btn-success">
                                        @if ($container=='form')
                                        {{trans('laratickets::lang.edit')}}
                                        @else
                                        {{trans('laratickets::lang.select')}}
                                        @endif
                                    </a>
                                    
                                    @if ($container=='form')
                                    <a wire:click="delete({{$reply->id}})" class="btn btn-danger">
                                        {{trans('laratickets::lang.delete')}}
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @if($reply->id==$collapse_id)
                            <div>
                                {!! $reply->content !!}
                            </div>
                            @endif
                            <div >
                               
                            </div>
                         </div>
                    </div>
                </div>
                @endforeach
                {{-- {{ $replies->links() }} --}}
            </div>
        </div>
</div>
