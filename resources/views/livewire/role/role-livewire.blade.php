
<div>
    <!-- Filters and Add Buttons -->
    @include('thotam-permission::livewire.role.sub.filters')

    <!-- Incluce các modal -->
    @include('thotam-permission::livewire.role.modal.add_edit')

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
