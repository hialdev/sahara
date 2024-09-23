@extends('templates.crud.add', ['routeName'=>'user'])

@section('title', 'Edit User')
@section('description', 'Edit user information and update the photo if needed')

@section('form')
<form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Untuk mengubah metode form menjadi PUT -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="d-flex flex-column justify-content-center">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="image-input" image-crop-aspect-ratio="1:1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name Surname" id="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="your@mail.com" id="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tel" class="form-label">Phone / Whatsapp</label>
                                <input type="tel" name="phone" class="form-control" placeholder="628123456789" id="tel" value="{{ old('tel', $user->phone) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password" id="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="re-type password" id="password_confirmation">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Assign Role</label>
                                <select id="role" name="role" class="choices form-select">
                                    @php
                                        $roles = \App\Models\Role::all();
                                    @endphp
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->roles[0]->id == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="d-block btn btn-primary w-100">Update</button>
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
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // FilePond: Image Crop
    const imageInput = document.querySelector(".image-input");

    const pond = FilePond.create(imageInput, {
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

    @if($user->image)
    pond.addFile("{{ asset('storage/' . $user->image) }}");
    @endif
</script>
@endsection
