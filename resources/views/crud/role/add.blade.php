@extends('templates.crud.add', ['routeName'=>'role'])

@section('title', 'Add Role')
@section('description', 'Add role and give an access to selected applications')

@section('form')
<form action="{{route('role.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="d-none d-md-block col-md-4">
            <img src="/images/applock.webp" alt="Icon Role Access" class="d-block w-100">
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Role Name" id="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">Give Access to</label>
                                <select class="choices form-select multiple-remove" name="applications[]" multiple="multiple">
                                    @foreach ($applications as $app)
                                    <option value="{{$app->id}}" {{ in_array($app->id, old('applications', [])) ? 'selected' : '' }}qw>{{$app->title}}</option>
                                    @endforeach
                                </select>
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
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
@endsection