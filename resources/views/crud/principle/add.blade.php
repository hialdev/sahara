@extends('templates.crud.add', ['routeName'=>'principle'])

@section('title', 'Add Principle')
@section('description', 'Add Principle or Supplier with PIC Contact')

@section('form')

    <form action="{{route('principle.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Priciple Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" required class="form-control" value="{{old('name')}}" placeholder="PT / Instansi / Others">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" required class="form-control" value="{{old('email')}}" placeholder="email@mail.com">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{old('description')}}</textarea>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <hr class="d-block bg-dark w-100 border-0 outline-0" style="height:2px;">
                            <span style="font-size:10px; white-space:nowrap" class="text-uppercase">Principle Address</span>
                            <hr class="d-block bg-dark w-100 border-0 outline-0" style="height:2px;">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="address" id="address" required cols="30" rows="3" class="form-control" placeholder="Full Address">{{old('address')}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Kota / Kabupaten <span class="text-danger">*</span></label>
                            <select id="city" name="city" required class="choices form-select">
                                @foreach (\App\Models\City::all() as $city)
                                <option value="{{$city->city_name}}" {{ $city->city_name === old('city') ? 'selected' : '' }}>{{$city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                            <input type="number" id="postal_code" required name="postal_code" value="{{old('postal_code')}}" class="form-control" placeholder="123456" minlength="5" maxlength="7">
                        </div>
                        <div class="mb-3">
                            <label for="fax" class="form-label">Faksimili</label>
                            <input type="number" id="fax" name="fax" value="{{old('fax')}}" class="form-control" placeholder="Fax Number">
                        </div>
                        <div class="">
                            <label for="telp" class="form-label">No. Telp</label>
                            <input type="tel" id="telp" name="telp" value="{{old('telp')}}" class="form-control" placeholder="No. Telp" minlength="5">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center text-primary rounded-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M6 17c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6m9-9a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3a3 3 0 0 1 3 3M3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2" />
                        </svg>
                    </div>
                    <h6 class="m-0">PIC Contact</h6>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">PIC Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="contact_name" required value="{{old('contact_name')}}" class="form-control" placeholder="PIC Name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="contact_email" required value="{{old('contact_email')}}" class="form-control" placeholder="pic@email.com">
                        </div>
                        <div class="">
                            <label for="tel" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" id="tel" name="contact_phone" required value="{{old('contact_phone')}}" class="form-control" placeholder="No Telp">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 position-sticky bottom-0 pb-3">
                <button class="btn btn-primary w-100">Add New</button>
            </div>
        </div>
    </form>

@endsection
