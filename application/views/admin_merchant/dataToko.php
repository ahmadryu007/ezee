<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Toko
        <small>Merchant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Toko</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-gray"><i class="fa fa-institution"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Toko</span>
              <span class="info-box-number"><?php echo $jumlahToko; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-flag-checkered"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Kota Dengan Toko </span>
              <span class="info-box-text">Terbanyak</span>
              <span class="info-box-number"><?php echo $highCity; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Toko Paling Banyak </span>
              <span class="info-box-text">Transaksi</span>
              <span class="info-box-number"><?php echo "ID Toko : ".$highStore; ?></span>
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
          <a href="<?php echo $base_url;?>index.php/merchantToko/addToko" class="btn btn-warning">Tambah Data</a>
        </div>
      </div>

      <br />

      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Toko</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/merchantToko" method="post">
              <label>Cari Berdasarkan</label>
              <select class="form-control" name="searchField">
                <option value="TokoID">ID Toko</option>
                <option value="Kota">Kota</option>
                <option value="Almat">Alamat</option>
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
                  echo 'Menampilkan Data Kartu Dengan <strong>'.$searchField.'</strong> <i>"'.$search.'"</i> '; 
                  echo '<br />';
                }
              ?>
            </form>

            <!--  <table id="example1" class="table table-bordered table-striped">
              </table> -->
              <label><?php echo $message; ?></label>
              <br />
              <form action="<?php echo $base_url;?>index.php/merchantToko" method="post">
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

                <form action="<?php echo $base_url;?>index.php/merchantToko/download_pdf" method="post">
                    <input type="text" id="jumlah" name="jumlah" value=0 size=5 onchange="cek()" disabled>
                    <input type="submit" id="import" class="btn btn-warnig" value="Export Data yang Dipilih Ke File PDF">
                    <a href="<?php echo $base_url;?>index.php/merchantToko/download_csv" class="btn btn-info">
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
        </div>
      
    </section>
</div>