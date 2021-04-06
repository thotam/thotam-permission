<div wire:ignore.self class="modal fade" id="set_role_permission_modal" tabindex="-1" role="dialog" aria-labelledby="set_role_permission_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-tools mr-3"></span>Set Permission cho Role</h4>
                <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal" thotam-blockui wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid mx-0 px-0">
                    <form>
                        <div class="row">

                            @if ($setStatus)

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Role:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $description }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nhóm Role:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $group }}</span>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $permission_arrays = Spatie\Permission\Models\Permission::all()->groupBy("group");
                                @endphp

                                @if (!!$permission_arrays)
                                    @foreach ($permission_arrays as $key => $value)
                                        <div class="col-12">
                                            <div class="form-group mb-1">
                                                <label class="col-form-label mb-1 text-indigo">{{ $key }}:</label>
                                                <div class="row">

                                                    @foreach ($value as $permission)
                                                        <label class="form-check col-md-4 col-sm-6 col-12 mb-1">
                                                            <input class="form-check-input ml-0 mt-1" wire:model="permissions.{{ $permission->name }}" type="checkbox" value="{{ $permission->id }}">
                                                            <span class="form-check-label ml-4">{{ $permission->description }}</span>
                                                        </label>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            @endif

                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer mx-auto">
                <button wire:click.prevent="cancel()" class="btn btn-danger" thotam-blockui wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                <button wire:click.prevent="save_role_permission()" class="btn btn-success" thotam-blockui wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
