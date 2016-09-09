<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Merchant
        <small>ezeelink</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Customer</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-gray"><i class="fa fa-bank"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Merchant</span>
              <span class="info-box-number"><?php echo $jumlahMerchant; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Kota Dengan Toko</span>
              <span class="info-box-text">Merchant Terbanyak</span>
              <span class="info-box-number"><?php echo $highKota; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-send"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Toko Merchant </span>
              <span class="info-box-text">Di Jakarta</span>
              <span class="info-box-number"><?php echo $tokoJakarta; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-reply"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Toko Merchant </span>
              <span class="info-box-text">Luar Jakarta</span>
              <span class="info-box-number"><?php echo $tokoLuarJakarta; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-3">
          <a href="#analisis" class="btn btn-default">Analisis Data Merchant</a>&nbsp;&nbsp;&nbsp;
        </div>
        <div class="col-md-3">
          <a href="<?php echo $base_url;?>index.php/merchants/addMerchant" class="btn btn-warning">Tambah Data</a>
        </div>
      </div>

      <br />

      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Merhcant</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/merchants" method="post">
              <label>Cari Berdasarkan</label>
              <select class="form-control" name="searchField">
                <option value="Nama">Nama</option>
              </select>
              <br />
              <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
              </div>
              <br />
              <?php 
                if (!empty($search)){
                  echo 'Menampilkan Data Transaksi Dengan <strong>'.$searchField.'</strong> <i>"'.$search.'"</i> '; 
                  echo '<br />';
                }
              ?>
            </form>

            <!--  <table id="example1" class="table table-bordered table-striped">
              </table> -->
              <label><?php echo $message; ?></label>
              <br />
              <form action="<?php echo $base_url;?>index.php/merchants" method="post">
                  <div class="col-md-6">
                    <label>Tampilkan Per</label>
                      <select name="limit">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="99999999">Semua</option>
                      </select>
                    <label>Data</label>
                    <input type="submit" class="btn btn-default" value="Ok">
                  </div>
                </form>

                <form action="<?php echo $base_url;?>index.php/merchants/download_pdf" method="post">
                    <input type="text" id="jumlah" name="jumlah" value=0 size=5 onchange="cek()" disabled>
                    <input type="submit" id="import" class="btn btn-warnig" value="Export Data yang Dipilih Ke File PDF">
                    <a href="<?php echo $base_url;?>index.php/merchants/download_csv" class="btn btn-info">
                      <i class="fa fa-file-excel-o">&nbsp;&nbsp;Export Semua Data Ke File .XLS</i>
                    </a>
                    <br />
                    <div><?php echo $table;?></div>
                  </form>

              <script type="text/javascript">
              function clickAll(){
                var checked = false;
                if (document.getElementById("checkMaster").checked == true)
                  checked = true;
                var tbl = document.getElementById("lineItemTable");
                var rowLen = tbl.rows.length;
                for (var idx = 1; idx < rowLen; idx++) {
                  var row = tbl.rows[idx];
                  var cell = row.cells[0];
                  var node = cell.lastChild;
                  node.checked = checked;
                }
                cek();
              }

              function cek(){
                var tbl = document.getElementById("lineItemTable");
                var rowLen = tbl.rows.length;
                var jumlah = 0;
                for (var idx = 1; idx < rowLen; idx++) {
                  var row = tbl.rows[idx];
                  var cell = row.cells[0];
                  var node = cell.lastChild;
                  if (node.checked == true)
                    jumlah++;

                  document.getElementById('jumlah').value = jumlah;
                }
              }
              </script>
              <ul class="pagination pagination-sm">
                <li>
                  <?php
                    if(empty($search)) 
                    echo $pagination; 
                  ?>
                </li>
              </ul>
              <br />

            </div>
        
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <script type="text/javascript" src="<?php echo $base_url;?>assets/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $base_url;?>assets/Chart.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
          
          // ==============================================================
          // pie chart data kota merchant

                  var data = [ <?php
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

                var ctx = document.getElementById("pieChart").getContext("2d");
                var chart = new Chart(ctx).Pie(data, {
                  //String - A legend template
                  legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><span style=\"background-color:<%=segments[i].fillColor%>\"><%if(segments[i].label){%><%=segments[i].label%><%}%></span><%}%></ul>"
                });
                document.getElementById("pieLegend").innerHTML = chart.generateLegend();

          // ==============================================================
          // pie chart data kategori merchant

                  var data2 = [ <?php
                                    $i = 0;
                                    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                                    foreach($merchantKategori as $c){
                                      {
                                        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                                        $i++;
                                        $dataPie = '{
                                                      value: '.$c->Jumlah.',
                                                      color:"'.$color.'",
                                                      highlight: "'.$color.'",
                                                      label: "'.$c->NamaKategori.'"
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

                var ctx2 = document.getElementById("pieChartKategori").getContext("2d");
                var chart2 = new Chart(ctx2).Pie(data2, {
                  //String - A legend template
                  legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><span style=\"background-color:<%=segments[i].fillColor%>\"><%if(segments[i].label){%><%=segments[i].label%><%}%></span><%}%></ul>"
                });
                document.getElementById("pieLegendKategori").innerHTML = chart2.generateLegend();
        });
        </script>

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

        <div class="col-md-6">
          <!-- PIE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Chart Analisis Kategori Merchant</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-3">
                <div id="pieLegendKategori"></div>
              </div>
              <div class="chart">
                <canvas id="pieChartKategori" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        </div>


      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>