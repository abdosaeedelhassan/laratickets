<div class="card-body" wire:init="initData">
    <form wire:submit.prevent="saveData">

        @if($dashboardData['model']=='all')
            <div class="form-group row">
                <label class="col-lg-2 col-form-label"
                       for="subject">{{trans('laratickets::lang.user') . trans('laratickets::lang.colon')}}</label>
                <div class="col-lg-10" wire:ignore>
                    <select class="form-control" name="user_id" id="usersList">
                        @foreach($users as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">{{trans('laratickets::lang.subject') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="subject" wire:model="subject">
                <small class="form-text text-muted">{!! trans('laratickets::lang.create-ticket-brief-issue') !!}</small>
                @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="content">{{trans('laratickets::lang.description') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                <textarea rows="5" class="form-control summernote-editor" id="content" wire:model="content"></textarea>
                <small class="form-text text-muted">{!! trans('laratickets::lang.create-ticket-brief-issue') !!}</small>
                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row mt-5">
            <label class="col-lg-2 col-form-label"
                   for="priority">{!!  trans('laratickets::lang.priority') . trans('laratickets::lang.colon') !!}</label>
            <div class="col-lg-10">
                <select class="form-control" name="priority_id" id="priority_id" wire:model="priority_id">
                    @foreach($priorities as $key=>$value)
                        <option value="{{$value}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row mt-5">
            <label class="col-lg-2 col-form-label"
                   for="category">{!!  trans('laratickets::lang.category') . trans('laratickets::lang.colon') !!}</label>
            <div class="col-lg-10">
                <select class="form-control" name="category_id" id="category_id" wire:model="category_id">
                    @foreach($categories as $key=>$value)
                        <option value="{{$value}}">{{$key}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if($this->dashboardData['form']['action']=='edit')
            <div class="form-row mt-5">
                <label class="col-lg-2 col-form-label"
                       for="category">{!!  trans('laratickets::lang.agent') . trans('laratickets::lang.colon') !!}</label>
                <div class="col-lg-10">
                    <select class="form-control" name="agent_id" id="agent_id" wire:model="agent_id">
                        @foreach($agents as $key=>$value)
                            <option value="{{$value}}">{{$key}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <br>
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                <button class="btn btn-primary">{{trans('laratickets::lang.btn-submit')}}</button>
            </div>
        </div>
    </form>
    <button wire:click="goback" class="btn btn-link">{{trans('laratickets::lang.btn-back')}}</button>
</div>

{{--@section('footer')--}}
{{--    @include('ticketit::tickets.partials.summernote')--}}
{{--@append--}}
