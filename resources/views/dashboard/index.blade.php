@extends('layouts.app')
@section('content')
<div class="page-heading">
    <h3>Hello, {{Auth::user()->name}}</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12">
            <div class="row">
              <div class="col-6 col-lg-3 col-md-6">
                  <div class="card">
                      <div class="card-body px-4 py-4-5">
                          <div class="row">
                              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                  <div class="stats-icon purple mb-2">
                                      <i class="bi-credit-card-2-back-fill"></i>
                                  </div>
                              </div>
                              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                  <h6 class="text-muted font-semibold">Total Client PO</h6>
                                  <h6 class="font-extrabold mb-0">Rp 8.422.000.000</h6>
                              </div>
                          </div> 
                      </div>
                  </div>
              </div>
              <div class="col-6 col-lg-3 col-md-6">
                  <div class="card"> 
                      <div class="card-body px-4 py-4-5">
                          <div class="row">
                              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                  <div class="stats-icon blue mb-2">
                                      <i class="bi-credit-card-2-back-fill"></i>
                                  </div>
                              </div>
                              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                  <h6 class="text-muted font-semibold">Total PO ke Principle</h6>
                                  <h6 class="font-extrabold mb-0">Rp 12.032.000.000</h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-6 col-lg-3 col-md-6">
                  <div class="card">
                      <div class="card-body px-4 py-4-5">
                          <div class="row">
                              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                  <div class="stats-icon red mb-2">
                                      <i class="bi-send-fill"></i>
                                  </div>
                              </div>
                              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                  <h6 class="text-muted font-semibold">Total Ongoing Delivery</h6>
                                  <h6 class="font-extrabold mb-0">182</h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon green mb-2">
                                    <i class="bi-cup-hot-fill"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total Invoice</h6>
                                <h6 class="font-extrabold mb-0">Rp 13.256.000.000</h6>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-8">
              </div>
              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                      <h4>PO Comparation</h4>
                      <p class="text-secondary m-0">Perbandingan Total PO dari Client dengan Total PO ke Principle (Rupiah)</p>
                  </div>
                  <div class="card-body">
                      <div id="po-comparation"></div>
                  </div>
                </div>
              </div>            
            </div>
        </div>
    </section>
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
  let optionsPOComparation = {
    series: [127420000000, 114235904000],
    labels: ["From Client", "To Principle"],
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
    document.getElementById("po-comparation"),
    optionsPOComparation
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