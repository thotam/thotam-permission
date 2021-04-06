
<div>
    <!-- Filters and Add Buttons -->
    @include('thotam-permission::livewire.permission.sub.filters')

    <!-- Incluce các modal -->
    @include('thotam-permission::livewire.permission.modal.add_edit')
    @include('thotam-permission::livewire.permission.modal.delete_modal')

    <!-- Scripts -->
    @push('livewires')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                window.thotam_livewire = @this;
                Livewire.emit("dynamic_update_method");
            });
        </script>
    @endpush
</div>
