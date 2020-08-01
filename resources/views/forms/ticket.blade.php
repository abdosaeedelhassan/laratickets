<div class="card-body">
    <form>
    <div class="form-group row">
        {!! CollectiveForm::label('subject', trans('laratickets::lang.subject') . trans('laratickets::lang.colon'), ['class' => 'col-lg-2 col-form-label']) !!}
        <div class="col-lg-10">
            {!! CollectiveForm::text('subject', null, ['class' => 'form-control', 'required' => 'required']) !!}
            <small class="form-text text-muted">{!! trans('laratickets::lang.create-ticket-brief-issue') !!}</small>
        </div>
    </div>
    <div class="form-group row">
        {!! CollectiveForm::label('content', trans('laratickets::lang.description') . trans('laratickets::lang.colon'), ['class' => 'col-lg-2 col-form-label']) !!}
        <div class="col-lg-10">
            {!! CollectiveForm::textarea('content', null, ['class' => 'form-control summernote-editor', 'rows' => '5', 'required' => 'required']) !!}
            <small class="form-text text-muted">{!! trans('laratickets::lang.create-ticket-describe-issue') !!}</small>
        </div>
    </div>
    <div class="form-row mt-5">
        <div class="form-group col-lg-4 row">
            {!! CollectiveForm::label('priority', trans('laratickets::lang.priority') . trans('laratickets::lang.colon'), ['class' => 'col-lg-6 col-form-label']) !!}
            <div class="col-lg-6">
                {!! CollectiveForm::select('priority_id', $priorities, null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>
        <div class="form-group offset-lg-1 col-lg-4 row">
            {!! CollectiveForm::label('category', trans('laratickets::lang.category') . trans('laratickets::lang.colon'), ['class' => 'col-lg-6 col-form-label']) !!}
            <div class="col-lg-6">
                {!! CollectiveForm::select('category_id', $categories, null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>
        {!! CollectiveForm::hidden('agent_id', 'auto') !!}
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
