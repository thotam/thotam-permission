<!-- Filters -->
<div class="px-4 pt-4 mb-0" wire:ignore>
    <div class="form-row">

        @if (Auth::user()->hr->can("add-role"))
            <div class="col-md-auto mb-4 pr-md-3">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <div class="col px-0 mb-1 text-md-left text-center">
                    <button type="button" class="btn btn-success waves-effect" wire:click="$emit('add_role')" wire:loading.attr="disabled"><span class="fas fa-plus-circle mr-2"></span>Thêm</button>
                </div>
            </div>
        @endif

    </div>
</div>
<!-- / Filters -->
