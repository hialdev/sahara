@extends('templates.crud.add', ['routeName'=>'profile'])

@section('title', 'My Profile')
@section('description', 'Setting your profile, make sure your data, and verification your email or phone')

@section('form')
<div class="row">
    <div class="col-md-4">
        <form action="{{ env('SSO_URL') }}/profile/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card">
                <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <labe class="form-label">Image</labe>
                            <input type="file" name="image" class="image-input" image-crop-aspect-ratio="1:1">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name Surname" id="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <button type="submit" class="d-block btn btn-primary w-100">Update</button>
                    </div>
                </div>
            </div>
        </form>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="d-flex align-items-center gap-2">
                                <p class="m-0">{{$user->email}}</p>
                                @if ($user->email && $user->email_verified_at)
                                <div class="d-flex align-items-center justify-content-center text-success" data-bs-toggle="tooltip" title="Email telah diverifikasi">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="currentColor" fill-rule="evenodd" d="M9.592 3.2a6 6 0 0 1-.495.399c-.298.2-.633.338-.985.408c-.153.03-.313.043-.632.068c-.801.064-1.202.096-1.536.214a2.71 2.71 0 0 0-1.655 1.655c-.118.334-.15.735-.214 1.536a6 6 0 0 1-.068.632c-.07.352-.208.687-.408.985c-.087.13-.191.252-.399.495c-.521.612-.782.918-.935 1.238c-.353.74-.353 1.6 0 2.34c.153.32.414.626.935 1.238c.208.243.312.365.399.495c.2.298.338.633.408.985c.03.153.043.313.068.632c.064.801.096 1.202.214 1.536a2.71 2.71 0 0 0 1.655 1.655c.334.118.735.15 1.536.214c.319.025.479.038.632.068c.352.07.687.209.985.408c.13.087.252.191.495.399c.612.521.918.782 1.238.935c.74.353 1.6.353 2.34 0c.32-.153.626-.414 1.238-.935c.243-.208.365-.312.495-.399c.298-.2.633-.338.985-.408c.153-.03.313-.043.632-.068c.801-.064 1.202-.096 1.536-.214a2.71 2.71 0 0 0 1.655-1.655c.118-.334.15-.735.214-1.536c.025-.319.038-.479.068-.632c.07-.352.209-.687.408-.985c.087-.13.191-.252.399-.495c.521-.612.782-.918.935-1.238c.353-.74.353-1.6 0-2.34c-.153-.32-.414-.626-.935-1.238a6 6 0 0 1-.399-.495a2.7 2.7 0 0 1-.408-.985a6 6 0 0 1-.068-.632c-.064-.801-.096-1.202-.214-1.536a2.71 2.71 0 0 0-1.655-1.655c-.334-.118-.735-.15-1.536-.214a6 6 0 0 1-.632-.068a2.7 2.7 0 0 1-.985-.408a6 6 0 0 1-.495-.399c-.612-.521-.918-.782-1.238-.935a2.71 2.71 0 0 0-2.34 0c-.32.153-.626.414-1.238.935m6.781 6.663a.814.814 0 0 0-1.15-1.15l-4.85 4.85l-1.596-1.595a.814.814 0 0 0-1.15 1.15l2.17 2.17a.814.814 0 0 0 1.15 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @else
                                <form action="{{route('verifikasi.email')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{$user->email}}">
                                    <button type="submit" class="border-0 d-flex align-items-center p-1 px-2 rounded-3 gap-1 bg-light-primary">
                                        verifikasi
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Phone / Whatsapp</label>
                            <div class="d-flex align-items-center gap-2">
                                <p class="m-0">{{$user->phone}}</p>
                                @if ($user->phone && $user->phone_verified_at)
                                <div class="d-flex align-items-center justify-content-center text-success" data-bs-toggle="tooltip" title="Nomor telah diverifikasi">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="currentColor" fill-rule="evenodd" d="M9.592 3.2a6 6 0 0 1-.495.399c-.298.2-.633.338-.985.408c-.153.03-.313.043-.632.068c-.801.064-1.202.096-1.536.214a2.71 2.71 0 0 0-1.655 1.655c-.118.334-.15.735-.214 1.536a6 6 0 0 1-.068.632c-.07.352-.208.687-.408.985c-.087.13-.191.252-.399.495c-.521.612-.782.918-.935 1.238c-.353.74-.353 1.6 0 2.34c.153.32.414.626.935 1.238c.208.243.312.365.399.495c.2.298.338.633.408.985c.03.153.043.313.068.632c.064.801.096 1.202.214 1.536a2.71 2.71 0 0 0 1.655 1.655c.334.118.735.15 1.536.214c.319.025.479.038.632.068c.352.07.687.209.985.408c.13.087.252.191.495.399c.612.521.918.782 1.238.935c.74.353 1.6.353 2.34 0c.32-.153.626-.414 1.238-.935c.243-.208.365-.312.495-.399c.298-.2.633-.338.985-.408c.153-.03.313-.043.632-.068c.801-.064 1.202-.096 1.536-.214a2.71 2.71 0 0 0 1.655-1.655c.118-.334.15-.735.214-1.536c.025-.319.038-.479.068-.632c.07-.352.209-.687.408-.985c.087-.13.191-.252.399-.495c.521-.612.782-.918.935-1.238c.353-.74.353-1.6 0-2.34c-.153-.32-.414-.626-.935-1.238a6 6 0 0 1-.399-.495a2.7 2.7 0 0 1-.408-.985a6 6 0 0 1-.068-.632c-.064-.801-.096-1.202-.214-1.536a2.71 2.71 0 0 0-1.655-1.655c-.334-.118-.735-.15-1.536-.214a6 6 0 0 1-.632-.068a2.7 2.7 0 0 1-.985-.408a6 6 0 0 1-.495-.399c-.612-.521-.918-.782-1.238-.935a2.71 2.71 0 0 0-2.34 0c-.32.153-.626.414-1.238.935m6.781 6.663a.814.814 0 0 0-1.15-1.15l-4.85 4.85l-1.596-1.595a.814.814 0 0 0-1.15 1.15l2.17 2.17a.814.814 0 0 0 1.15 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @else
                                <form action="{{route('verifikasi.phone')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="phone" value="{{$user->phone}}">
                                    <button type="submit" class="border-0 d-flex align-items-center p-1 px-2 rounded-3 gap-1 bg-light-primary">
                                        verifikasi
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <p>*************</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-outline-primary btn-change">Change Password, Email, or Phone</button>
                    </div>
                    <div class="card-change bg-light-primary rounded-4 p-4 mt-3">
                        <form action="{{route('profile.change')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-2">
                                    Masukkan password untuk memastikan bahwa ini anda
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="password" name="password" placeholder="Password" class="rounded-5 px-3 form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="password" name="confirm_password" placeholder="Confirm password" class="rounded-5 px-3 form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class=" d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M17.25 2.75H6.75A4.75 4.75 0 0 0 2 7.5v9a4.75 4.75 0 0 0 4.75 4.75h10.5A4.76 4.76 0 0 0 22 16.5v-9a4.76 4.76 0 0 0-4.75-4.75m-3.65 8.32a3.26 3.26 0 0 1-3.23 0L3.52 7.14a3.25 3.25 0 0 1 3.23-2.89h10.5a3.26 3.26 0 0 1 3.23 2.89z"></path></svg>
                                        <div id="email-edit" class="d-flex align-items-center gap-3">
                                            <div>{{$user->email}}</div>
                                            <button type="button" class="btn p-0 d-flex align-items-center justify-content-center rounded-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 36 36"><path fill="currentColor" d="m4.22 23.2l-1.9 8.2a2.06 2.06 0 0 0 2 2.5a2 2 0 0 0 .43 0L13 32l15.84-15.78L20 7.4Z" className="clr-i-solid clr-i-solid-path-1"></path><path fill="currentColor" d="m33.82 8.32l-5.9-5.9a2.07 2.07 0 0 0-2.92 0L21.72 5.7l8.83 8.83l3.28-3.28a2.07 2.07 0 0 0-.01-2.93" className="clr-i-solid clr-i-solid-path-2"></path><path fill="none" d="M0 0h36v36H0z"></path></svg>
                                            </button>
                                        </div>
                                        <div id="email-change" class="d-flex align-items-center gap-2 d-none">
                                            <input type="email" name="email" placeholder="New Email" value="" class="rounded-5 px-3 form-control">
                                            <button type="button" class="btn btn-danger d-flex align-items-center justify-content-center rounded-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="m289.94 256l95-95A24 24 0 0 0 351 127l-95 95l-95-95a24 24 0 0 0-34 34l95 95l-95 95a24 24 0 1 0 34 34l95-95l95 95a24 24 0 0 0 34-34Z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-success {{strlen($user->email_verified_at) > 1 ? 'd-block' : 'd-none'}}" style="font-size: 12px;">Email ini telah diverifikasi, mengubahnya akan membutuhkan verifikasi ulang</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class=" d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64c0 247.4 200.6 448 448 448c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368c-70.4-33.3-127.4-90.3-160.7-160.7l49.3-40.3c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path></svg>
                                        <div id="phone-edit" class="d-flex align-items-center gap-3">
                                            <div>{{$user->phone}}</div>
                                            <button type="button" class="btn p-0 d-flex align-items-center justify-content-center rounded-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 36 36"><path fill="currentColor" d="m4.22 23.2l-1.9 8.2a2.06 2.06 0 0 0 2 2.5a2 2 0 0 0 .43 0L13 32l15.84-15.78L20 7.4Z" className="clr-i-solid clr-i-solid-path-1"></path><path fill="currentColor" d="m33.82 8.32l-5.9-5.9a2.07 2.07 0 0 0-2.92 0L21.72 5.7l8.83 8.83l3.28-3.28a2.07 2.07 0 0 0-.01-2.93" className="clr-i-solid clr-i-solid-path-2"></path><path fill="none" d="M0 0h36v36H0z"></path></svg>
                                            </button>
                                        </div>
                                        <div id="phone-change" class="d-flex align-items-center gap-2 d-none">
                                            <input type="number" name="phone" placeholder="New Phone Number" value="" class="rounded-5 px-3 form-control">
                                            <button type="button" class="btn btn-danger d-flex align-items-center justify-content-center rounded-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="m289.94 256l95-95A24 24 0 0 0 351 127l-95 95l-95-95a24 24 0 0 0-34 34l95 95l-95 95a24 24 0 1 0 34 34l95-95l95 95a24 24 0 0 0 34-34Z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-success {{strlen($user->phone_verified_at) > 1 ? 'd-block' : 'd-none'}}" style="font-size: 12px;">Phone ini telah diverifikasi, mengubahnya akan membutuhkan verifikasi ulang</span>
                                </div>
                                <div class="col-12">
                                    <div class="row shadow-sm mb-2 mx-1 p-3 px-2 rounded-5">
                                        <div class="col-12">
                                            <p>Isi jika ingin mengganti password, abaikan bila tidak</p>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="password" name="new_password" placeholder="New Password" class="form-control rounded-5 px-3">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="password" name="confirm_new_password" placeholder="Confirm New Password" class="form-control rounded-5 px-3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary rounded-5 w-100">Ubah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $imagePath = env('SSO_URL').'/storage'.'/'.$user->image;
@endphp
@section('scripts')
<script>
    
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

    @if($imagePath)
    fetch("{{ $imagePath }}", {mode:'cors'})
        .then(response => response.blob())
        .then(blob => {
            const reader = new FileReader();
            reader.onloadend = () => {
                pond.addFile(reader.result);
            };
            reader.readAsDataURL(blob);
        })
        .catch(error => console.error('Error fetching image:', error));
    @endif

    var changeBtn = $('.btn-change');
    var changeCard = $('.card-change');
    var phoneEdit = $('#phone-edit');
    var phoneChange = $('#phone-change');
    var emailEdit = $('#email-edit');
    var emailChange = $('#email-change');
    var changeCard = $('.card-change');

    changeBtn.on('click' ,function() {
        changeCard.toggle();
    });

    phoneEdit.find('button').on('click' ,function() {
        phoneEdit.addClass('d-none');
        phoneChange.removeClass('d-none');
    });

    phoneChange.find('button').on('click' ,function() {
        phoneChange.addClass('d-none');
        phoneEdit.removeClass('d-none');
    });

    emailEdit.find('button').on('click' ,function() {
        emailEdit.addClass('d-none');
        emailChange.removeClass('d-none');
    });

    emailChange.find('button').on('click' ,function() {
        emailChange.addClass('d-none');
        emailEdit.removeClass('d-none');
    });
</script>
@endsection