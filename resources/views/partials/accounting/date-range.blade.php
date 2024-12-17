<link rel="stylesheet" href="/dist/assets/extensions/flatpickr/flatpickr.min.css">


<form action="{{url()->current()}}" method="GET">
  <div class="card mb-3">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 mb-2">
          <label for="start_date" class="form-label">Mulai dari Tanggal</label>
          <input type="date" name="start_date" id="start_date" class="form-control flatpickr-general" value="{{request()->get('start_date')}}">
        </div>
        <div class="col-md-6 mb-2">
          <label for="end_date" class="form-label">Hingga Tanggal</label>
          <input type="date" name="end_date" id="end_date" class="form-control flatpickr-general" value="{{request()->get('end_date')}}">
        </div>
        <div class="col-12">
          <div class="d-flex gap-2 justify-content-between align-items-center">
            <p style="font-size: 13px; max-width:30em" class="d-flex flex-wrap align-items-center gap-1"><span class="p-1 px-2 rounded-3 me-1 bg-light-warning">Note</span>Jika filter kosong maka semua data diterapkan, dan Cetak PDF hanya akan mencetak data yang diterapkan </p>
            <button type="submit" class="btn btn-primary" style="white-space: nowrap">Terapkan Filter</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script src="/dist/assets/extensions/flatpickr/flatpickr.min.js"></script>
<script>
flatpickr('.flatpickr-general', {
  enableTime: false,
  defaultDate: "today",
})
const sd = document.querySelector("#start_date")._flatpickr;
const ed = document.querySelector("#end_date")._flatpickr;
sd.setDate(`{{request()->get('start_date') ?? '2000-01-01'}}`)
ed.setDate(`{{request()->get('end_date') ?? 'today'}}`)
</script>