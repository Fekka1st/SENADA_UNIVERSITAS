<x-app-layout>

<x-slot:title>Edit Kategori Mitra</x-slot:title>
<x-slot:breadcrumb>Edit</x-slot:breadcrumb>

<div class="card">
    <div class="card-body">

        {{-- Alert --}}
        <x-alert></x-alert>


        {{-- FORM UPDATE --}}
        <form action="{{ route('master-data.kategori_mitra.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')


            <div class="row">

                {{-- LEFT --}}
                <div class="col-md-8">

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="ti ti-tag"></i>
                            </span>

                            <input type="text"
                                name="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                autocomplete="off">

                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Keterangan</label>

                        <textarea name="keterangan"
                            rows="4"
                            class="form-control  @error('keterangan') is-invalid @enderror" placeholder="Jelaskan secara singkat cakupan kategori ini..."
                        >{{ old('keterangan', $kategori->keterangan) }}</textarea>

                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>


                {{-- RIGHT --}}
                <div class="col-md-4">

                    {{-- WARNA --}}
                    <div class="card border-dashed bg-light bg-opacity-50 h-100">

                        <div class="card-body">

                            <label class="form-label fw-bold">
                                <i class="ti ti-palette me-1"></i>
                                Identitas Warna <span class="text-danger">*</span>
                            </label>

                            <p class="small text-muted mb-3">
                                Klik untuk memilih warna marker.
                            </p>


                            <div class="d-flex flex-column gap-2 mb-3">

                                {{-- DISPLAY --}}
                                <div
                                    id="customColorDisplay"
                                    class="custom-color-display d-flex align-items-center justify-content-center shadow-sm"
                                    style="
                                        background-color: {{ old('warna_peta', $kategori->warna_peta) }};
                                        height:45px;
                                        border-radius:8px;
                                        cursor:pointer;
                                    "
                                >
                                    <span class="fw-bold text-white">
                                        Klik Pilih Warna
                                    </span>
                                </div>


                                <div class="d-flex gap-2">

                                    {{-- COLOR PICKER --}}
                                    <input type="color"
                                        name="warna_peta"
                                        id="colorPicker"
                                        class="visually-hidden"
                                        value="{{ old('warna_peta', $kategori->warna_peta) }}">


                                    {{-- HEX --}}
                                    <div class="input-group">

                                        <span class="input-group-text">
                                            HEX
                                        </span>

                                        <input type="text"
                                            id="colorText"
                                            class="form-control text-center fw-bold"
                                            readonly
                                            value="{{ old('warna_peta', $kategori->warna_peta) }}">
                                    </div>

                                </div>
                            </div>


                            {{-- PREVIEW --}}
                            <div class="p-3 bg-white rounded border text-center">

                                <div id="previewMarker"
                                    class="mx-auto"
                                    style="
                                        width:40px;
                                        height:40px;
                                        border-radius:50% 50% 50% 0;
                                        background-color: {{ old('warna_peta', $kategori->warna_peta) }};
                                        transform:rotate(-45deg);
                                        border:3px solid #fff;
                                    ">
                                </div>

                                <small class="text-muted d-block mt-2">
                                    Preview Marker
                                </small>

                            </div>


                            @error('warna_peta')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                </div>

            </div>


            {{-- BUTTON --}}
            <div class="row mt-4">
                <div class="col-12 text-end">

                    <hr>

                    <a href="{{ route('master-data.kategori_mitra.index') }}"
                       class="btn btn-light me-2">

                        <i class="ti ti-arrow-left"></i> Batal
                    </a>

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="ti ti-device-floppy"></i>
                        Update Kategori
                    </button>

                </div>
            </div>

        </form>

    </div>
</div>


{{-- STYLE --}}
<style>
.border-dashed {
    border: 2px dashed #dee2e6;
}

#colorText {
    letter-spacing: 1px;
    text-transform: uppercase;
}
</style>


{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const colorPicker = document.getElementById('colorPicker');
    const colorText = document.getElementById('colorText');
    const previewMarker = document.getElementById('previewMarker');
    const customColorDisplay = document.getElementById('customColorDisplay');

    function syncColor(color) {

        if (!color) return;

        const hex = color.toUpperCase();

        colorText.value = hex;
        previewMarker.style.backgroundColor = hex;
        customColorDisplay.style.backgroundColor = hex;
        colorPicker.value = hex;
    }

    syncColor(colorPicker.value);


    [customColorDisplay, colorText, previewMarker].forEach(function (el) {

        el.addEventListener('click', function (e) {

            e.preventDefault();
            colorPicker.click();

        });

    });


    colorPicker.addEventListener('input', function () {
        syncColor(this.value);
    });

    colorPicker.addEventListener('change', function () {
        syncColor(this.value);
    });

});
</script>

</x-app-layout>
