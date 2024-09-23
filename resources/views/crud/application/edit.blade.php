@extends('templates.crud.add', ['routeName'=>'application'])

@section('title', 'Edit Application')
@section('description', '')

@section('form')
<div class="card">
    <div class="card-body">
        <form action="{{ route('application.update', $application->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $application->title) }}" required>
            </div>
            <div class="mb-3 row align-items-start">
                <div class="col-md-6">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="image-input" image-crop-aspect-ratio="4:2">
                </div>
                <div class="col-md-6">
                    <label for="icon" class="form-label">Icon Id <a href="https://icons.getbootstrap.com/" target="_blank">ambil disini</a></label>
                    <input type="text" name="icon" class="form-control" id="icon" value="{{ old('icon', $application->icon) }}" required oninput="previewIcon()">
                    <div class="form-check form-switch my-3">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Gunakan Icon 
                            <i id="icon-preview" class="bi-{{ old('icon', $application->icon) }}"></i>
                            Untuk Ditampilkan ?
                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Apabila aktif maka tampilan card application akan menggunakan icon bukan gambar">lebih lanjut</a>
                        </label>
                        <input class="form-check-input" name="use_icon" type="checkbox" id="flexSwitchCheckDefault" {{ $application->use_icon ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description">{{ old('description', $application->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input type="url" name="url" class="form-control" id="url" value="{{ old('url', $application->url) }}" required>
            </div>
            <button type="submit" class="btn w-100 btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filepond: Image Crop
    const pond = FilePond.create(document.querySelector(".image-input"), {
        credits: null,
        allowImagePreview: true,
        allowImageFilter: false,
        allowImageExifOrientation: false,
        allowImageCrop: true,
        acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg", "image/webp"],
        fileValidateTypeDetectType: (source, type) =>
            new Promise((resolve, reject) => {
                resolve(type)
            }),
        storeAsFile: true,
    });

    @if($application->image)
    pond.addFile("{{ asset('storage/' . $application->image) }}");
    @endif

    function previewIcon() {
        var iconInput = document.getElementById('icon');
        var iconPreview = document.getElementById('icon-preview');
        iconPreview.className = 'bi bi-' + iconInput.value;
    }
</script>
@endsection
