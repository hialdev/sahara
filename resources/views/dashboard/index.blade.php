@extends('layouts.app')
@section('content')
<div class="page-heading mb-2">
    <h3>Hello, {{$user->name}}</h3>
    <p>Semangat dalam menjalani hari-harimu ya!, yuk akes aplikasi yang tersedia untukmu</p>
</div> 
<div class="page-content"> 
  <div class="row">
    <div class="col-12">
      <h5 class="mb-3"># Applications</h5>
    </div>
    @forelse ($apps as $app)
    <div class="col-6 col-lg-3 col-md-6 mb-4">
      <div class="card" style="height:100%">
          <div class="card-body px-4 py-4-5">
              <div class="d-flex align-items-start flex-column justify-content-between h-100">
                  <div class="w-100">
                    @if ($app->use_icon && $app->icon)
                    <div class="mb-3 text-white rounded-3 d-flex align-items-center justify-content-center w-100" style="background:#f7f7f7;aspect-ratio:16/9; object-fit:cover; ">
                      <i class="bi-{{$app->icon}} fs-1 text-dark"></i>
                    </div>
                    @else
                    <img src="{{env('SSO_URL').'/storage'.'/'.$app->image}}" alt="Image of {{$app->title}}" class="d-block rounded-3 mb-3 w-100" style="background:#f7f7f7;aspect-ratio:16/9; object-fit:contain; ">
                    @endif
                    <h6 class="font-extrabold mb-0">{{$app->title}}</h6>
                    <p class="text-muted">{{$app->description}}</p>
                  </div>
                  <div class="w-100">
                    @php
                      $currentDomain = request()->getHost(); // Mendapatkan domain saat ini, misalnya account.sahara.test
                      $appDomain = parse_url($app->url, PHP_URL_HOST); // Mendapatkan domain dari $app->url tanpa protocol
                    @endphp

                    @if($currentDomain === $appDomain)
                      <div class="w-100 text-secondary text-center p-2">You in Here</div>
                    @else
                      <a href="{{ url($app->url) }}" target="_blank" class="w-100 btn btn-outline-primary">Open App</a>
                    @endif
                  </div>
              </div> 
          </div>
      </div>
    </div>
    @empty
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center p-4">You don't have access to Applications</div>
      </div>
    </div>
    @endforelse
  </div>  
</div>
@endsection

@section('scripts')
<script>
var optionsProfileVisit = {
    annotations: {
      position: "back",
    },
    dataLabels: {
      enabled: false,
    },
    chart: {
      type: "bar",
      height: 300,
    },
    fill: {
      opacity: 1,
    },
    plotOptions: {},
    series: [
      {
        name: "sales",
        data: [9, 20, 30, 20, 10, 20, 30, 20, 10, 20, 30, 20],
      },
    ],
    colors: "#435ebe",
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
    },
  }
  let optionsVisitorsProfile = {
    series: [70, 30],
    labels: ["Male", "Female"],
    colors: ["#435ebe", "#55c6e8"],
    chart: {
      type: "donut",
      width: "100%",
      height: "350px",
    },
    legend: {
      position: "bottom",
    },
    plotOptions: {
      pie: {
        donut: {
          size: "30%",
        },
      },
    },
  }
  
  var optionsEurope = {
    series: [
      {
        name: "series1",
        data: [310, 800, 600, 430, 540, 340, 605, 805, 430, 540, 340, 605],
      },
    ],
    chart: {
      height: 80,
      type: "area",
      toolbar: {
        show: false,
      },
    },
    colors: ["#5350e9"],
    stroke: {
      width: 2,
    },
    grid: {
      show: false,
    },
    dataLabels: {
      enabled: false,
    },
    xaxis: {
      type: "datetime",
      categories: [
        "2018-09-19T00:00:00.000Z",
        "2018-09-19T01:30:00.000Z",
        "2018-09-19T02:30:00.000Z",
        "2018-09-19T03:30:00.000Z",
        "2018-09-19T04:30:00.000Z",
        "2018-09-19T05:30:00.000Z",
        "2018-09-19T06:30:00.000Z",
        "2018-09-19T07:30:00.000Z",
        "2018-09-19T08:30:00.000Z",
        "2018-09-19T09:30:00.000Z",
        "2018-09-19T10:30:00.000Z",
        "2018-09-19T11:30:00.000Z",
      ],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        show: false,
      },
    },
    show: false,
    yaxis: {
      labels: {
        show: false,
      },
    },
    tooltip: {
      x: {
        format: "dd/MM/yy HH:mm",
      },
    },
  }
  
  let optionsAmerica = {
    ...optionsEurope,
    colors: ["#008b75"],
  }
  let optionsIndia = {
    ...optionsEurope,
    colors: ["#ffc434"],
  }
  let optionsIndonesia = {
    ...optionsEurope,
    colors: ["#dc3545"],
  }
  
  var chartProfileVisit = new ApexCharts(
    document.querySelector("#chart-profile-visit"),
    optionsProfileVisit
  )
  var chartVisitorsProfile = new ApexCharts(
    document.getElementById("chart-visitors-profile"),
    optionsVisitorsProfile
  )
  var chartEurope = new ApexCharts(
    document.querySelector("#chart-europe"),
    optionsEurope
  )
  var chartAmerica = new ApexCharts(
    document.querySelector("#chart-america"),
    optionsAmerica
  )
  var chartIndia = new ApexCharts(
    document.querySelector("#chart-india"),
    optionsIndia
  )
  var chartIndonesia = new ApexCharts(
    document.querySelector("#chart-indonesia"),
    optionsIndonesia
  )
  
  chartIndonesia.render()
  chartAmerica.render()
  chartIndia.render()
  chartEurope.render()
  chartProfileVisit.render()
  chartVisitorsProfile.render()
</script>  
@endsection