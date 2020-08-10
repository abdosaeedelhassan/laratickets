<div class="card-body" wire:init="renderAgentsList">
    <form wire:submit.prevent="saveData">
        <div class="form-row mt-5">
                    <label  class="col-lg-2 col-form-label"
                        for="agent_id">
                        <p>{{ trans('laratickets::admin.administrator-create-select-user') }}</p>
                    </label>
                <div class="col-lg-10">
                    <select class="form-control" name="agents[]" id="agents" wire:model="agents" multiple="true">
                        @foreach($admins as $key=>$value)
                            <option value="{{$value}}">{{$key}}</option>
                        @endforeach
                    </select>
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
