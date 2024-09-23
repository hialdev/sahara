@extends('templates.crud.add', ['routeName'=>'product'])

@section('title', 'Add Product')
@section('description', 'Add product and choose a type of unit')

@section('form')

    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" name="title" class="form-control" placeholder="Product Name" id="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="20" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <select id="satuan" name="satuan" class="choices form-select">
                                        @forelse (\App\Models\Satuan::all() as $satuan)
                                        <option value="{{$satuan->id}}">{{$satuan->name}}</option>
                                        @empty
                                        <option value="">Tidak ada satuan tersedia</option>
                                        @endforelse
                                    </select>
                                    <div class="text-secondary">Tidak menemukan satuan yang pas? <a href="{{route('satuan.index')}}" class="ms-2 btn btn-sm btn-secondary">Tambah Satuan</a></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="d-block btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
<script>
    // function previewImage(event) {
    //     var reader = new FileReader();
    //     reader.onload = function(){
    //         var output = document.getElementById('image-preview');
    //         output.src = reader.result;
    //         output.style.display = 'block';
    //     };
    //     reader.readAsDataURL(event.target.files[0]);
    // }

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


</script>
@endsection