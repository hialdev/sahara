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
                                  <h6 class="font-extrabold mb-0">{{$ro}}</h6>
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
                                  <h6 class="font-extrabold mb-0">{{$pop}}</h6>
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
                                  <h6 class="font-extrabold mb-0">{{$ong}}</h6>
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
                                <h6 class="font-extrabold mb-0">{{$fin}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-8">
                <div class="card">
                  <div class="card-body">
                    <h6>Request Order / PO Form Client (Last 30 Days)</h6>
                    <div id="chart-30dPo"></div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                      <h4>PO Comparation</h4>
                      <p class="text-secondary m-0">Perbandingan Total antara Quotation, PO dari Client, Invoice, dan Total PO ke Principle (Jumlah)</p>
                  </div>
                  <div class="card-body">
                      <div id="chartComparation"></div>
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
let comparationPie = {
  series: @json($comparation->data),
  labels: @json($comparation->categories),
  colors: @json($comparation->colors),
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

var options30d = {
  series: [{
      name: "Total Purchases",
      data: @json($totals),
  }],
  chart: {
      height: 340,
      type: "area",
      toolbar: {
          show: false,
      },
  },
  colors: ["#432d74"],
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
      categories: @json($dates),
      axisBorder: {
          show: false,
      },
      axisTicks: {
          show: false,
      },
      labels: {
          show: true,
          format: 'dd MMM',
      },
  },
  yaxis: {
      labels: {
          show: true,
      },
  },
  tooltip: {
      x: {
          format: "dd MMM yyyy",
      },
  },
}

let options30dPo = {
  ...options30d,
  colors: ["#432d74"],
}

var chart30d = new ApexCharts(
  document.querySelector("#chart-30dPo"),
  options30dPo
)
chart30d.render()

var chartComparation = new ApexCharts(
  document.getElementById("chartComparation"),
  comparationPie
)
chartComparation.render()

</script>  
@endsection