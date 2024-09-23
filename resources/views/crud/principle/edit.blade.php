@extends('templates.crud.add', ['routeName'=>'principle'])

@section('title', 'Edit Principle : '.$principle->name)
@section('description', 'Edit Principle and Addresses')

@section('form')
<div>
    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="principle-tab" data-bs-toggle="tab" href="#principle" role="tab"
                aria-controls="principle" aria-selected="true">Principle</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab"
                aria-controls="address" aria-selected="false">Principle Address</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="principle" role="tabpanel" aria-labelledby="principle-tab">
            <form action="{{route('principle.update', $principle->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Priciple Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" required class="form-control" value="{{old('name', $principle->name)}}" placeholder="Principle or Supplier Name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" required class="form-control" value="{{old('email', $principle->email)}}" placeholder="email@mail.com">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{old('description', $principle->description)}}</textarea>
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
                                    <input type="text" id="name" name="contact_name" required value="{{old('contact_name', $principle->contact_name)}}" class="form-control" placeholder="PIC Name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="contact_email" required value="{{old('contact_email', $principle->contact_email)}}" class="form-control" placeholder="pic@email.com">
                                </div>
                                <div class="">
                                    <label for="tel" class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" id="tel" name="contact_phone" required value="{{old('contact_phone', $principle->contact_phone)}}" class="form-control" placeholder="No Telp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 position-sticky bottom-0 pb-3">
                        <button class="btn btn-primary w-100">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            <div class="row">
                <div class="col-md-6">
                    <h4># Address</h4>
                    @foreach ($principle->addresses as $address)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="p-1 px-2 text-uppercase border rounded-2 d-inline-block mb-2" style="font-size: 10px">{{$address->address_tag}}</div>
                                    <div>{{$address->address}} - {{$address->city.', '.$address->postal_code}}</div>
                                    <div>{{$address->telp.', '.$address->fax}}</div>
                                </div>
                                <div>
                                    <button type="button" 
                                        class="d-flex align-items-center justify-content-center btn btn-sm btn-outline-primary btn-edit-address block" 
                                        data-id="{{$address->id}}"
                                        data-address_tag="{{$address->address_tag}}"
                                        data-address="{{$address->address}}"
                                        data-city="{{$address->city}}"
                                        data-postal_code="{{$address->postal_code}}"
                                        data-telp="{{$address->telp}}"
                                        data-fax="{{$address->fax}}"
                                        style="aspect-ratio:1/1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621"/>
                                                <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/>
                                            </g>
                                        </svg>
                                    </button>

                                    
                                    @if (count($principle->addresses) > 1)
                                    <button type="button" class="mt-2 btn btn-sm btn-outline-danger block" style="aspect-ratio:1/1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#danger-{{$address->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2" />
                                        </svg>
                                    </button>

                                    {{-- Modal Delete --}}
                                    <div class="modal fade text-left" id="danger-{{$address->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-header bg-danger border-0">
                                                    <h5 class="modal-title white" id="myModalLabel120">Confirmation Delete</h5>
                                                    <button type="button" class="btn btn-danger bg-danger" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="mb-1 bi-x-lg"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body border-0">
                                                    Apakah anda yakin menghapus data alamat pada principle {{$principle->name}} dengan id {{$principle->id}} ? data yang dihapus bersifat permanen tidak dapat dikembalikan
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Batal</span>
                                                    </button>
                                                    <form action="{{route('principle.address.destroy', ['principle_id' => $principle->id, 'id' => $address->id])}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger ms-1"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Ya, Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>            
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <form action="{{route('principle.address.manage', ['principle_id' => $principle->id])}}" method="POST">
                        @csrf
                        <h6># Manage Address</h6>
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="purpose" id="purpose" value="add">
                                <input type="hidden" name="id" id="id">
                                <div class="mb-3">
                                    <label for="address_tag" class="form-label">Address Tag <span class="text-danger">*</span></label>
                                    <input type="text" name="address_tag" id="address_tag" placeholder="Tandai alamat sebagai" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" required cols="30" rows="3" class="form-control" placeholder="Full Address">{{old('address') ?? ''}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Kota / Kabupaten <span class="text-danger">*</span></label>
                                    <select id="city" name="city" required class="form-select">
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
                                <div class="mb-3">
                                    <label for="telp" class="form-label">No. Telp</label>
                                    <input type="number" id="telp" name="telp" value="{{old('telp')}}" class="form-control" placeholder="No. Telp" minlength="5">
                                </div>
                                <div class="position-sticky bottom-0 pb-2 d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-secondary btn-reset d-flex align-items-center justify-content-center" style="aspect-ratio:1/1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-width="2" d="M20 8c-1.403-2.96-4.463-5-8-5a9 9 0 1 0 0 18a9 9 0 0 0 9-9m0-9v6h-6" />
                                        </svg>
                                    </button>
                                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        const cityChoices = new Choices('#city', {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select a city',
            removeItemButton: true
        });

        // Event listener untuk tombol edit address
        $('.btn-edit-address').click(function () {
            // Ambil data dari atribut data-* pada tombol yang diklik
            var id = $(this).data('id');
            var address = $(this).data('address');
            var addressTag = $(this).data('address_tag');
            var city = $(this).data('city');
            var postalCode = $(this).data('postal_code');
            var telp = $(this).data('telp');
            var fax = $(this).data('fax');

            // Isi form dengan data yang diambil
            $('#purpose').val('edit');
            $('#id').val(id);
            $('#address_tag').val(addressTag);
            $('textarea#address').val(address);
            cityChoices.setChoiceByValue(city);
            $('#postal_code').val(postalCode);
            $('#telp').val(telp);
            $('#fax').val(fax);

            // Ubah tombol form menjadi "Update"
            $('.btn-primary').text('Update');
        });

        // Reset form ketika tab "Manage Address" dibuka tanpa klik tombol edit
        $('.btn-reset').click(function () {
            // Kosongkan form jika tidak mengedit data
            $('#purpose').val('add');
            $('#id').val('');
            $('#address_tag').val('');
            $('textarea#address').val('');
            $('#city').val('');
            $('#postal_code').val('');
            $('#telp').val('');
            $('#fax').val('');

            // Kembalikan tombol menjadi "Tambah"
            $('.btn-primary').text('Tambah');
        });
    });
</script>
@endsection
