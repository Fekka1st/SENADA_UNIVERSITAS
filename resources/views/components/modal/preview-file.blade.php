@props([
    'id' => 'previewModalFile',
    'size' => 'xl',
    'hideActions' => false  // Jika true, hanya tampilkan tombol Batal
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true" data-preview-modal>
    <div class="modal-dialog modal-{{ $size }} modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" data-preview-title>Preview File</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-preview-body
                style="height: 80vh; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                @if(!$hideActions)
                    <a href="#" data-preview-download download class="btn btn-success">
                        <i class="ti ti-download me-1"></i>Download
                    </a>
                    <a href="#" data-preview-open target="_blank" class="btn btn-primary">
                        <i class="ti ti-external-link me-1"></i>Buka di Tab Baru
                    </a>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ $hideActions ? 'Batal' : 'Tutup' }}
                </button>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle preview file button clicks using event delegation
    // This works for both normal table view and child rows (DataTables responsive)
    $(document).on('click', '.btn-preview-file', function(e) {
        e.preventDefault();

        const fileName = $(this).data('file-name');
        const fileUrl = $(this).data('file-url');
        const fileType = $(this).data('file-type');
        const modalTarget = $(this).data('modal-target');
        
        // Tentukan modal target
        let $modal;
        if (modalTarget) {
            $modal = $('#' + modalTarget);
        } else {
            // Gunakan modal preview pertama yang ditemukan
            $modal = $('[data-preview-modal]').first();
        }
        
        if ($modal.length === 0) {
            console.error('Modal preview tidak ditemukan');
            return;
        }
        
        // Update modal title
        $modal.find('[data-preview-title]').text('Preview File - ' + fileName);

        // Update modal body based on file type
        let modalBodyHtml = '';

        if (fileType === 'pdf') {
            modalBodyHtml = '<iframe src="' + fileUrl + 
                '" width="100%" height="100%" class="border rounded"></iframe>';
        } else if (fileType === 'image') {
            modalBodyHtml = 
                '<div class="text-center w-100 h-100 d-flex align-items-center justify-content-center">' +
                '<img src="' + fileUrl + 
                '" class="img-fluid border rounded" style="max-height: 100%; max-width: 100%; object-fit: contain;" alt="Preview Image">' +
                '</div>';
        } else if (fileType === 'audio') {
            modalBodyHtml = 
                '<div class="text-center w-100 d-flex align-items-center justify-content-center">' +
                '<audio controls class="w-100" style="max-width: 500px;">' +
                '<source src="' + fileUrl + '" type="audio/mpeg">' +
                'Browser Anda tidak mendukung pemutaran audio.' +
                '</audio></div>';
        } else if (fileType === 'video') {
            modalBodyHtml = 
                '<div class="text-center w-100 h-100 d-flex align-items-center justify-content-center">' +
                '<video controls class="border rounded" style="max-height: 100%; max-width: 100%; object-fit: contain;">' +
                '<source src="' + fileUrl + '" type="video/mp4">' +
                'Browser Anda tidak mendukung pemutaran video.' +
                '</video></div>';
        } else {
            modalBodyHtml = '<div class="text-center p-5">' +
                '<i class="ti ti-file-x text-muted" style="font-size: 48px;"></i>' +
                '<p class="text-muted mt-3">Preview tidak tersedia untuk tipe file ini</p>' +
                '</div>';
        }

        $modal.find('[data-preview-body]').html(modalBodyHtml);

        // Update download and open links
        $modal.find('[data-preview-download]').attr('href', fileUrl).attr('download', fileName);
        $modal.find('[data-preview-open]').attr('href', fileUrl);

        // Show modal
        var previewModal = new bootstrap.Modal($modal[0]);
        previewModal.show();
    });
});
</script>
@endpush
@endonce
