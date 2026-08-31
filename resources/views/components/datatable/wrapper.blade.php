@props([
    'tableId' => 'dataTable',
    'columns' => [],
    'hasCheckbox' => false,
])

<div class="table-responsive">
    <table id="{{ $tableId }}" class="table align-middle datatable-bordered" style="width: 100%;">
        <thead class="table-light">
            <tr>
                @if($hasCheckbox)
                    <th><input type="checkbox" id="checkAll"></th>
                @endif
                @foreach($columns as $column)
                    @if($column !== null)
                        <th>{{ $column }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{-- DataTables will populate this --}}
        </tbody>
    </table>
</div>
