<div class="card-body">
    <form wire:submit.prevent="saveData">
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
            <div class="form-group offset-lg-1 col-lg-4 row">
                <div class="col-lg-6 col-form-label">
                    <label
                        for="priority">{!!  trans('laratickets::lang.priority') . trans('laratickets::lang.colon') !!}</label>
                </div>
                <div class="col-lg-6">
                    <select class="form-control" name="priority_id" id="priority_id" wire:model="priority_id">
                        @foreach($priorities as $key=>$value)
                            <option value="{{$value}}">{{$key}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group offset-lg-1 col-lg-4 row">
                <div class="col-lg-6 col-form-label">
                    <label
                        for="category">{!!  trans('laratickets::lang.category') . trans('laratickets::lang.colon') !!}</label>
                </div>
                <div class="col-lg-6">
                    <select class="form-control" name="category_id" id="category_id" wire:model="category_id">
                        @foreach($categories as $key=>$value)
                            <option value="{{$value}}">{{$key}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                <button wire:click="goback" class="btn btn-link">{{trans('laratickets::lang.btn-back')}}</button>
                <button class="btn btn-primary">{{trans('laratickets::lang.btn-submit')}}</button>
            </div>
        </div>
    </form>
</div>

{{--@section('footer')--}}
{{--    @include('ticketit::tickets.partials.summernote')--}}
{{--@append--}}
