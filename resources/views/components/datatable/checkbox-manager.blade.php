@props([
    'formId' => 'formSerahkan',
    'checkAllId' => 'checkAll',
    'checkItemClass' => 'checkItem',
    'buttons' => [],
])

<script>
    // Checkbox Logic
    function updateCheckboxListeners() {
        const checkAll = document.getElementById('{{ $checkAllId }}');
        const checkboxes = document.querySelectorAll('.{{ $checkItemClass }}');
        
        @foreach($buttons as $button)
            const {{ $button['id'] }} = document.getElementById('{{ $button['id'] }}');
        @endforeach

        // Function untuk mengecek dan mengatur status tombol
        function updateButtonStates() {
            const checkedBoxes = Array.from(checkboxes).filter(c => c.checked);
            const hasChecked = checkedBoxes.length > 0;

            // Permission checks dari server
            @foreach($buttons as $button)
                @if(isset($button['permission']))
                    const has{{ ucfirst($button['id']) }}Permission = {{ auth()->user()->hasPermission($button['permission']) ? 'true' : 'false' }};
                @else
                    const has{{ ucfirst($button['id']) }}Permission = true;
                @endif
            @endforeach

            if (!hasChecked) {
                // Jika tidak ada yang dipilih, disable semua tombol
                @foreach($buttons as $button)
                    if ({{ $button['id'] }}) {{ $button['id'] }}.disabled = true;
                @endforeach
                return;
            }

            // Enable tombol jika ada permission dan ada yang dipilih
            @foreach($buttons as $button)
                if ({{ $button['id'] }}) {{ $button['id'] }}.disabled = !has{{ ucfirst($button['id']) }}Permission;
            @endforeach
        }

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(c => {
                    c.checked = checkAll.checked;
                });
                updateButtonStates();
            });
        }

        checkboxes.forEach(c => {
            c.addEventListener('change', () => {
                updateButtonStates();
            });
        });

        // Initial state
        updateButtonStates();
    }
</script>
