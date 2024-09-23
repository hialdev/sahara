@extends('templates.crud.add', ['routeName'=>'application'])

@section('title', 'Add Application')
@section('description', '')

@section('form')
<div class="card">
    <div class="card-body">
        <form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3 row align-items-start">
                <div class="col-md-6">
                    <labe class="form-label">Image</labe>
                    <input type="file" name="image" class="image-input" image-crop-aspect-ratio="4:2">
                </div>
                <div class="col-md-6">
                    <label for="icon" class="form-label">Icon Id <a href="https://icons.getbootstrap.com/" target="_blank">ambil disini</a></label>
                    <input type="text" name="icon" class="form-control" id="icon" value="{{ old('icon') }}" required oninput="previewIcon()">
                    <div class="form-check form-switch my-3">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Gunakan Icon 
                            <i id="icon-preview" class="bi-{{ old('icon') ?? 'question' }}"></i>
                            Untuk Ditampilkan ?
                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Apabila aktif maka tampilan card application akan menggunakan icon bukan gambar">lebih lanjut</a>
                        </label>
                        <input class="form-check-input" name="use_icon" type="checkbox" id="flexSwitchCheckDefault">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" value="{{ old('description') ?? '' }}"></textarea>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input type="url" name="url" class="form-control" id="url" value="{{ old('url') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filepond: Image Crop
    FilePond.create(document.querySelector(".image-input"), {
        credits: null,
        allowImagePreview: true,
        allowImageFilter: false,
        allowImageExifOrientation: false,
        allowImageCrop: true,
        acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg", "image/webp"],
        fileValidateTypeDetectType: (source, type) =>
            new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise
            resolve(type)
            }),
        storeAsFile: true,
    })

    function previewIcon() {
        var iconInput = document.getElementById('icon');
        var iconPreview = document.getElementById('icon-preview');
        iconPreview.className = 'bi bi-' + iconInput.value;
    }
</script>
@endsection