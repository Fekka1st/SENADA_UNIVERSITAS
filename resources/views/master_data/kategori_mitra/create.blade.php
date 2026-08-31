<x-app-layout>
<x-slot:title>Tambah Kategori Mitra</x-slot:title>
<x-slot:breadcrumb>Tambah</x-slot:breadcrumb>
<div class="card ">
    <div class="card-body">
        

        {{-- Alert Messages --}}
        <x-alert></x-alert>

        {{-- Form Tambah Data --}}
        <form action="{{ route('master-data.kategori_mitra.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    {{-- Nama Kategori --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="ti ti-tag"></i></span>
                            <input type="text" name="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori') }}"
                                placeholder="Contoh: Perusahaan Multinasional, Instansi Pemerintah..."
                                autocomplete="off">
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                        <textarea name="keterangan" rows="4"
                            class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Jelaskan secara singkat cakupan kategori ini...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    {{-- Warna Peta --}}
                    <div class="card border-dashed bg-light bg-opacity-50 h-100">
                        <div class="card-body">
                            <label class="form-label fw-bold">
                                <i class="ti ti-palette me-1"></i> Identitas Warna Peta <span class="text-danger">*</span>
                            </label>
                            <p class="small text-muted mb-3">Klik tombol warna atau kode HEX untuk memilih warna penanda peta.</p>

                            <div class="d-flex flex-column gap-2 mb-3">
                                {{-- Custom Color Button Trigger --}}
                                <div class="custom-color-display d-flex align-items-center justify-content-center shadow-sm" id="customColorDisplay"
                                    style="background-color: {{ old('warna_peta', '#3b82f6') }}; height: 45px; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;">
                                    <span class="color-text fw-bold text-white shadow-text" style="text-shadow: 0px 1px 3px rgba(0,0,0,0.3);">Klik untuk memilih warna</span>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    {{-- Native Color Picker (Hidden from view but functional) --}}
                                    <input type="color" name="warna_peta"
                                        id="colorPicker"
                                        class="visually-hidden"
                                        value="{{ old('warna_peta', '#3b82f6') }}">

                                    {{-- Visible Hex Text --}}
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted">HEX</span>
                                        <input type="text" id="colorText" class="form-control fw-bold text-center bg-white cursor-pointer"
                                            value="{{ old('warna_peta', '#3b82f6') }}"
                                            placeholder="#000000"
                                            readonly
                                            style="letter-spacing: 1px;">
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 bg-white rounded-3 border text-center shadow-sm">
                                <div id="previewMarker" class="mx-auto"
                                    style="width: 40px; height: 40px; border-radius: 50% 50% 50% 0; background-color: {{ old('warna_peta', '#3b82f6') }}; transform: rotate(-45deg); border: 3px solid #fff; cursor: pointer; transition: background-color 0.2s ease;">
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted fw-bold d-block">Preview Marker Peta</small>
                                    <span class="fs-7 text-muted">Warna identitas kategori di peta</span>
                                </div>
                            </div>

                            @error('warna_peta')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-end">
                    <hr class="opacity-10 mb-4">
                    <a href="{{ route('master-data.kategori_mitra.index') }}" class="btn btn-light fw-bold px-4 me-2">
                        <i class="ti ti-arrow-left me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="ti ti-device-floppy me-1"></i>Simpan Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .border-dashed {
        border: 2px dashed #dee2e6 !important;
    }
    .form-control-color {
        width: 60px;
        height: 45px;
        padding: .2rem;
        cursor: pointer;
    }
    #colorText {
        letter-spacing: 1px;
        text-transform: uppercase;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const colorPicker = document.getElementById('colorPicker');
    const colorText = document.getElementById('colorText');
    const previewMarker = document.getElementById('previewMarker');
    const customColorDisplay = document.getElementById('customColorDisplay');

    // Sinkronisasi warna
    function syncColor(color) {
        if (!color) return;

        const hex = color.toUpperCase();

        colorText.value = hex;
        previewMarker.style.backgroundColor = hex;
        customColorDisplay.style.backgroundColor = hex;
        colorPicker.value = hex;
    }

    // Init default / old value
    syncColor(colorPicker.value);

    // Trigger color picker saat diklik
    [customColorDisplay, colorText, previewMarker].forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            colorPicker.click();
        });
    });

    // Realtime update
    colorPicker.addEventListener('input', function () {
        syncColor(this.value);
    });

    // Final update
    colorPicker.addEventListener('change', function () {
        syncColor(this.value);
    });

});
</script>



</x-app-layout>
