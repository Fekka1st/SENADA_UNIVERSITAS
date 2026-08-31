@props([
    'id' => 'modalHapus',
    'title' => 'Hapus Data',
    'itemName' => '',
    'deleteRoute' => '',
    'relatedCount' => 0,
    'relatedType' => '',
    'isSelfUser' => false,
    'isDynamic' => false  // Mode untuk server-side DataTables
])

<div class="modal fade" id="{{ $id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="{{ $id }}Label">
                    <i class="ti ti-trash me-1"></i> {{ $title }}
                </h2>
            </div>
            <div class="modal-body">
                @if($isDynamic)
                    {{-- Mode Dynamic untuk Server-Side DataTables --}}
                    <p class="mb-2">
                        Anda yakin ingin menghapus <span class="fw-bold" id="{{ $id }}ItemName">{{ $itemName }}</span>?
                    </p>
                    <div id="{{ $id }}WarningRelated" class="alert alert-warning d-none">
                        <i class="ti ti-alert-triangle me-1"></i>
                        Data ini memiliki <span id="{{ $id }}RelatedCount"></span> {{ $relatedType }} terkait dan tidak dapat dihapus.
                    </div>
                    <p id="{{ $id }}WarningDelete" class="text-danger small mb-0">
                        <i class="ti ti-alert-triangle me-1"></i>
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </p>
                @else
                    {{-- Mode Static untuk Client-Side --}}
                    <p class="mb-2">
                        Anda yakin ingin menghapus <span class="fw-bold">{{ $itemName }}</span>?
                    </p>
                    @if($isSelfUser)
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Anda tidak dapat menghapus akun Anda sendiri.
                        </div>
                    @elseif($relatedCount > 0)
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Data ini memiliki {{ $relatedCount }} {{ $relatedType }} terkait dan tidak dapat dihapus.
                        </div>
                    @else
                        <p class="text-danger small mb-0">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Data yang sudah dihapus tidak dapat dikembalikan.
                        </p>
                    @endif
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                @if($isDynamic)
                    {{-- Mode Dynamic: form action akan diubah via JavaScript --}}
                    <form id="{{ $id }}Form" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="{{ $id }}BtnSubmit">Ya, Hapus!</button>
                    </form>
                @else
                    {{-- Mode Static: form action sudah ditentukan --}}
                    @if(!$isSelfUser && $relatedCount == 0)
                        <form action="{{ $deleteRoute }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
