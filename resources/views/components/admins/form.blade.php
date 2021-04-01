<div>
    <form wire:submit.prevent="saveData">
        <div class="form-row mt-5">
            <label class="col-lg-12 col-form-label"
                   for="agent_id">
                <p>{{ trans('laratickets::admin.agent-create-select-user') }}</p>
            </label>
        </div>
        <div class="form-row mt-5">
            <table class="table table-hover">
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="form-check form-check-inline">
                                <input name="selectedUsers[]" wire:model="selectedUsers.{{ $loop->index }}"
                                       type="checkbox" class="form-check-input"
                                       value="{{ $user->id }}" {!! $user->laratickets_admin ? "checked" : "" !!}>
                                <label class="form-check-label">{{ $user->name }}</label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
        <br>
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                <button class="btn btn-primary">{{trans('laratickets::lang.btn-submit')}}</button>
            </div>
        </div>
        <a wire:click="goback" class="btn btn-link">{{trans('laratickets::lang.btn-back')}}</a>
    </form>
</div>
