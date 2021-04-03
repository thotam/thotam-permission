<div wire:ignore.self class="modal fade" id="add_edit_modal" tabindex="-1" role="dialog" aria-labelledby="add_edit_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-user-tag mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($addStatus || $editStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="description">Mô tả Role:</label>
                                        <div id="description_div">
                                            <input type="text" class="form-control px-2" wire:model.debounce.500ms="description" id="description" style="width: 100%" placeholder="Mô tả Role ..." autocomplete="off">
                                        </div>
                                        @error('description')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Tên Role:</label>
                                        <div id="name_div">
                                            <input type="text" class="form-control px-2" wire:model.debounce.500ms="name" id="name" style="width: 100%" placeholder="Tên Role ..." autocomplete="off">
                                        </div>
                                        @error('name')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="group">Nhóm Role:</label>
                                        <div id="group_div">
                                            <input type="text" class="form-control px-2" wire:model.debounce.500ms="group" id="group" style="width: 100%" placeholder="Nhóm Role ..." autocomplete="off"  list="suggestions">
                                            <datalist id="suggestions">
                                                @if (!!$group_arrays)
                                                    @foreach ($group_arrays as $group_array)
                                                        <option value="{{ $group_array }}">
                                                    @endforeach
                                                @endif
                                            </datalist>
                                        </div>
                                        @error('group')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="order">STT Role:</label>
                                        <div id="order_div">
                                            <input type="text" class="form-control px-2" wire:model.debounce.500ms="order" id="order" style="width: 100%" placeholder="STT Role ..." autocomplete="off">
                                        </div>
                                        @error('order')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="modal-footer mx-auto">
                <button wire:click.prevent="cancel()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                <button wire:click.prevent="save()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
