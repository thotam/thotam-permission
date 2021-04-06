
<div>
    <!-- Filters and Add Buttons -->
    @include('thotam-permission::livewire.role.sub.filters')

    <!-- Incluce các modal -->
    @include('thotam-permission::livewire.role.modal.add_edit')
    @include('thotam-permission::livewire.role.modal.delete_modal')
    @include('thotam-permission::livewire.role.modal.set_role_permission_modal')

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
