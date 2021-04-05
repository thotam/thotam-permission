
<div>
    <!-- Filters and Add Buttons -->
    @include('thotam-permission::livewire.role.sub.filters')

    <!-- Incluce các modal -->
    @include('thotam-permission::livewire.role.modal.add_edit')

    <!-- Scripts -->
    @push('livewires')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                Livewire.hook('component.initialized', (component) => {
                    console.log(component);
                    console.log(@this);
                })
            });
        </script>
    @endpush
</div>
