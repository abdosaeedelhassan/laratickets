<div class="card-body">
    <form wire:submit.prevent="saveData">
        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">{{trans('laratickets::admin.table-name') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="name" wire:model="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">{{trans('laratickets::admin.category-create-color') . trans('laratickets::lang.colon')}}</label>
            <div class="col-lg-10">
                <input type="color" class="form-control" id="color" wire:model="color">
                @error('color') <span class="text-danger">{{ $message }}</span> @enderror
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
