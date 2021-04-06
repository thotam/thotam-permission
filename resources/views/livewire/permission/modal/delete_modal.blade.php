<div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-indigo"><span class="fas fa-user-cog mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" class="close" thotam-blockui data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid mx-0 px-0">
                    <div class="row">

                        @if ($deleteStatus)
                            <div class="col-12 mb-3 text-danger font-weight-semibold">
                                Bạn sẽ Permission có thông tin như sau, việc xóa là KHÔNG THỂ khôi phục,bạn có chắc chắn?
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Tên Permission:</label>
                                    <div>
                                        <span type="text" class="form-control px-2 h-auto">{{ $name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Mô tả Permission:</label>
                                    <div>
                                        <span type="text" class="form-control px-2 h-auto">{{ $description }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Nhóm Permission:</label>
                                    <div>
                                        <span type="text" class="form-control px-2 h-auto">{{ $group }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="modal-footer mx-auto">
                <button wire:click.prevent="cancel()" class="btn btn-info" thotam-blockui wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                <button wire:click.prevent="delete()" class="btn btn-danger" thotam-blockui wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
