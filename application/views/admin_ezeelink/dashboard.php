<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Ezeelink</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $jumlahCust; ?></h3>

              <p>Jumlah Pelanggan</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="<?php echo $base_url?>index.php/customers" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $jumlahTransaksiBulanIni->Jumlah; ?></h3>

              <p>Jumlah Transaksi Bulan Sekarang</p>
            </div>
            <div class="icon">
              <i class="fa fa-dollar"></i>
            </div>
            <a href="<?php echo $base_url?>index.php/transaksi" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3><?php echo $jumlahMerchant ?></h3>

              <p>Jumlah Merchant</p>
            </div>
            <div class="icon">
              <i class="fa fa-bank"></i>
            </div>
            <a href="<?php echo $base_url?>index.php/merchants" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $jumlahKartu; ?></h3>

              <p>Jumlah Kartu</p>
            </div>
            <div class="icon">
              <i class="fa fa-credit-card"></i>
            </div>
            <a href="<?php echo $base_url?>index.php/cards" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">

        <div class="col-md-6" id="analisis">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Jumlah Transaksi Per-bulan</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/dashboard#analisis" method="post">
              <div class="form-group">
                  <label>Tahun</label>
                  <select class="form-control" name="s">
                    <?php 
                      foreach ($tahun as $t) {
                        echo '<option value="'.$t->Tahun.'">'.$t->Tahun.'</option>';
                      }
                    ?>
                  </select>
                  <br />
                  <input class="btn btn-success" type="submit" value="Submit" />
                </div>
            </form>

              <div class="chart">
                <canvas id="testChart" style="height:250px"></canvas>
                <div class="col-sm-3">
                  <div id="testLegend" style="font-size:25px"></div>
                </div>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

          <div class="col-md-6" id="analisis">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Jumlah Transaksi Per-hari</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/dashboard#analisis" method="post">
              <div class="form-group">
                  <label>Tahun</label>
                  <select class="form-control" name="sTahunHari">
                    <?php 
                      foreach ($tahun as $t) {
                        echo '<option value="'.$t->Tahun.'">'.$t->Tahun.'</option>';
                      }
                    ?>
                  </select>
                  <br />
                  <select class="form-control" name="sBulanHari">
                    <option value="0">- Semua -</option>
                    <option value="1">Januari</option>
                    <option value="2">February</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Okotober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                  <br />
                  <input class="btn btn-success" type="submit" value="Submit" />
                </div>
            </form>

              <div class="chart">
                <canvas id="hariChart" style="height:250px"></canvas>
                <div class="col-sm-6">
                  <div id="hariLegend" style="font-size:25px"></div>
                </div>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        <div class="col-md-6" id="analisis">
          <!-- PIE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Data Kota Pelanggan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-3">
                <div id="doughnatLegend"></div>
              </div>
              <div class="chart">
                <canvas id="doughnatChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        <div class="col-md-6" id="analisis">
          <!-- PIE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Chart Analisis Kota Merchant</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-3">
                <div id="pieLegend"></div>
              </div>
              <div class="chart">
                <canvas id="pieChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        <script type="text/javascript" src="<?php echo $base_url;?>assets/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $base_url;?>assets/Chart.js"></script>

        <script type="text/javascript">
              $(document).ready(function(){

                  // =============================================================
                  // line chart data jumlah transaksi per bulan
                  var data = {
                            labels: <?php echo $labelPerBulan; ?>,
                            datasets: [
                                {
                                    label: <?php echo '"'.$selectTahun.'"' ?>,
                                    fillColor: "rgb(102, 153, 255)",
                                    strokeColor: "rgb(102, 153, 255)",
                                    pointColor: "rgb(102, 153, 255)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo $transaksiPerBulan; ?>
                                }
                            ]
                        };

                  var ctx = document.getElementById("testChart").getContext("2d");
                  var chart = new Chart(ctx).Line(data);
                  document.getElementById("testLegend").innerHTML = chart.generateLegend();

                  // =============================================================
                  // line chart data jumlah transaksi
                  var data2 = {
                            labels: <?php echo $hari; ?>,
                            datasets: [
                                {
                                    label: <?php echo '"'.$selectTahun2.' Bulan Ke-'.$selectBulanHari.'"' ?>,
                                    fillColor: "rgb(194, 194, 163)",
                                    strokeColor: "rgb(194, 194, 163)",
                                    pointColor: "rgb(194, 194, 163)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo $hariJumlah; ?>
                                }
                            ]
                        };

                  var ctx2 = document.getElementById("hariChart").getContext("2d");
                  var chart2 = new Chart(ctx2).Bar(data2);
                  document.getElementById("hariLegend").innerHTML = chart2.generateLegend();

                  // pie chart data kota pelanggan

                  var data4 = [ <?php
                                    $i = 0;
                                    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                                    foreach($customerKota as $c){
                                      {
                                        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                                        $i++;
                                        $dataPie = '{
                                                      value: '.$c->Jumlah.',
                                                      color:"'.$color.'",
                                                      highlight: "'.$color.'",
                                                      label: "'.$c->Kota.'"
                                                    },';
                                        echo $dataPie;
                                      }
                                    }
                                 ?>
                                  {
                                      value: 0,
                                      color: "",
                                      highlight: "",
                                      label: ""
                                  }
                              ]
                // doughnat
                var ctx4 = document.getElementById('doughnatChart').getContext("2d");
                var chart4 = new Chart(ctx4).Doughnut(data4);

                // ==============================================================
          // pie chart data kota merchant

                  var data3 = [ <?php
                                    $i = 0;
                                    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                                    foreach($merchantKota as $c){
                                      {
                                        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                                        $i++;
                                        $dataPie = '{
                                                      value: '.$c->Jumlah.',
                                                      color:"'.$color.'",
                                                      highlight: "'.$color.'",
                                                      label: "'.$c->Kota.'"
                                                    },';
                                        echo $dataPie;
                                      }
                                    }
                                 ?>
                                  {
                                      value: 0,
                                      color: "",
                                      highlight: "",
                                      label: ""
                                  }
                              ]

                var ctx3 = document.getElementById("pieChart").getContext("2d");
                var chart3 = new Chart(ctx3).Pie(data3, {
                  //String - A legend template
                  legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><span style=\"background-color:<%=segments[i].fillColor%>\"><%if(segments[i].label){%><%=segments[i].label%><%}%></span><%}%></ul>"
                });
                document.getElementById("pieLegend").innerHTML = chart3.generateLegend();

              });
        </script>

      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>