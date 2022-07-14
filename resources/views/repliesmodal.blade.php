<div>
  <!-- Modal -->
  <div id="repliesModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content p-0">
        <div class="modal-header">
          <h4 class="modal-title">
            {{ trans('laratickets::lang.select-reply') }}
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body p-0">
          <livewire:lara-tickets-replies container="modal" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            {{ trans('laratickets::lang.close') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</div>