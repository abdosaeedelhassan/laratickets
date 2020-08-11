<div class="card-body">
    <form wire:submit.prevent="saveData">
        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">{{trans('laratickets::admin.table-lang') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                {{$lang}}
{{--                <input type="text" class="form-control" id="lang" wire:model="lang">--}}
{{--                @error('lang') <span class="text-danger">{{ $message }}</span> @enderror--}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">{{trans('laratickets::admin.table-slug') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                {{$slug}}
{{--                <input type="text" class="form-control" id="slug" wire:model="slug">--}}
{{--                @error('slug') <span class="text-danger">{{ $message }}</span> @enderror--}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">{{trans('laratickets::admin.table-value') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="value" wire:model="value">
                @error('value') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>


        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">{{trans('laratickets::admin.table-default') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="default" wire:model="default">
                @error('default') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                <button type="submit" class="btn btn-primary">{{trans('laratickets::lang.btn-submit')}}</button>
            </div>
        </div>
    </form>
    <button wire:click="goback" class="btn btn-link">{{trans('laratickets::lang.btn-back')}}</button>
</div>
