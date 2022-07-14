<div class="card-body" wire:init="initSettings">
    <form wire:submit.prevent="saveData">
        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">@lang('Automatic closing period for tickets')</label>
            <div class="col-lg-10">
               <input type="number" class="form-control" id="lang" wire:model="auto_closing_ticket_period">
               @lang('Hour')
               @error('lang') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 col-form-label"
                   for="subject">@lang('Number of tickets open to the user')</label>
            <div class="col-lg-10">
               <input type="number" class="form-control" id="lang" wire:model="number_of_tickets_open_to_user">
               @lang('Ticket')
               @error('lang') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                <button type="submit" class="btn btn-primary">@lang('Save')</button>
            </div>
        </div>
    </form>
</div>
