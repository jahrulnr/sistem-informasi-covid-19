<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Informasi Covid-19</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- select2 -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Heebo:300,400,400i,700&display=swap" rel="stylesheet">

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- Moment -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/locale/id.js') }}"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link text-center">
      <span class="brand-text font-weight-light"><sub>Sistem Informasi</sub><br/><b>Covid-19</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#periode" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Periode
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-3">
      <script type="text/javascript">
        function make_chart(id, json_data){
          let myChart = new Chart(id, {
            type: 'bar',
            options: {
              responsive: true,
              maintainAspectRatio: false,
              locale: 'id',
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  }
                }]
              },
            },
            data: json_data,
          });
        }
      </script>

      <!-- Chart Content -->
      <div class="col-12">
        <div class="card" id="periode-card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">
                Data Covid-19 dari {{ $periode != null ? count($periode) : 0 }} periode terakhir
              </h3>
            </div>
          </div>
          <div class="card-body">
            <div class="position-relative mb-4">
              <canvas id="covid-chart" height="200"></canvas>
              <script type="text/javascript">
                make_chart('covid-chart', {
                  @if($periode != null)
                  labels: [
                    @foreach($periode as $p)
                    "{{$p[1]}}",
                    @endforeach
                    ],
                  datasets: [{ 
                    data: [
                      {{implode(",", $hijau)}}
                    ],
                    label: "Hijau",
                    borderColor: "#0a0",
                    backgroundColor: "#0b0",
                    fill: false
                  }, { 
                    data: [
                      {{implode(",", $kuning)}}
                    ],
                    label: "Kuning",
                    borderColor: "#ee0",
                    backgroundColor: "#ff0",
                    fill: false
                  }, { 
                    data: [
                      {{implode(",", $Oren)}}
                    ],
                    label: "Oren",
                    borderColor: "#fa0",
                    backgroundColor:"#fa0",
                    fill: false
                  }, { 
                    data: [
                      {{implode(",", $merah)}}
                    ],
                    label: "Merah",
                    borderColor: "#e00",
                    backgroundColor:"#e00",
                    fill: false
                  }]
                  @endif
                });
              </script>
            </div>
          </div>
        </div>
      </div>
      <!-- Chart Content -->

      <div class="col-12">
        <div class="card">
          <div class="card-header border-0">
            <div class="col-11 col-md-5 col-lg-4 d-flex">
              <label style="padding-top: 0.2rem;" class="mr-2">Periode</label>
              <select class="form-control form-control-sm" id="periode" name="periode">
                @if($periode != null)
                @foreach(array_reverse($periode) as $p)
                <option value="{{ $p[0] }}">{{ $p[1] }}</option>
                @endforeach
                @endif
              </select>
            </div>       
          </div>
          <hr class="mb-0 mt-0" /> 
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Kelurahan</th>
                  <th>Jumlah Positif</th>
                  <th>Rata-Rata Positif per RW</th>
                </tr>
              </thead>
              <tbody id="table_periode"></tbody>
            </table>
            <hr class="mb-2 mt-3" /> 
            <div class="row" id="chart_periode"></div>
          </div>
        </div>
      </div>

    </section>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer text-center">
    <strong>Copyright &copy; {{ $_SERVER['HTTP_HOST'] }} All rights
    reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  <data class="d-none">
    <div id="chart-template">
      <div class="col-md-6">
        <h5 class="mb-0">
          Kelurahan __kelurahan__
        </h5>
        <div class="position-relative mb-4">
          <canvas id="covid-chart-__id__" height="200"></canvas>
          <xcript>make_chart("covid-chart-__id__", __json__);</xcript>
        </div>
      </div>
    </div>
    <div id="table-body-template">
      <tr_data>
        <td_data class="w-auto" align="center">__no__.</td_data>
        <td_data>__kelurahan__</td_data>
        <td_data><span class="fas fa-circle" style="color:var(__j_color__)"></span> __jumlah__</td_data>
        <td_data><span class="fas fa-circle" style="color:var(__r_color__)"></span> __rata2__</td_data>
      </tr_data>
    </div>
  </data>

  <script type="text/javascript">
    $('#periode').select2();

    function getJSON(id){
      $.ajax({url: "/periode/" + id, success: function(data){
        if(data == null){
          $('#chart_periode').html("Belum ada data.");
          return false;
        }
        let show_table = "";
        let show_chart = "";
        let j = 1;

        $.each(data, function(i, v){
          let kelurahan = i;
          let d = $("#table-body-template").html()
            .replace("__no__", j)
            .replace("__kelurahan__", kelurahan)
            .replace("__j_color__", v.status_jumlah[0])
            .replace("__jumlah__", v.jumlah)
            .replace("__r_color__", v.status_rata2[0])
            .replace("__rata2__", v.rata2)
            .replaceAll("tr_data", "tr")
            .replaceAll("td_data", "td");
          let c = $("#chart-template").html()
            .replace("__kelurahan__", kelurahan)
            .replaceAll("__id__", j)
            .replace("__json__", JSON.stringify(v))
            .replaceAll("xcript", "script");
          show_table += d;
          show_chart += c;
          j++;
        });
        $("#table_periode").html(show_table);
        $('#chart_periode').html(show_chart);
      }});
    }

    $(document).ready(function(){
      getJSON($('#periode').val());
      $('#periode').change(function(){
        getJSON($(this).val());
      });

      $("a").click(function(){
        let htag = window.location.hash;
        if(htag == "#periode")
          $("#periode-card").focus();
      });
    });
  </script>
</div>
</body>
</html>
