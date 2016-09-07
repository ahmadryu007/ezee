<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile Customer
        <small>Ezeelink</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Customer</a></li>
        <li><a href="#">Profile Customer</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="col-md-3">
        <div class="box box-solid">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?php echo $customer->Nama; ?></h3>
              <h5 class="widget-user-desc"><?php echo $customer->Alamat; ?></h5>
              <div>
                <p>
                <?php
                
                  echo $rating.'&nbsp;&nbsp;';
                  for ($i=0;$i<$rating;$i++){
                    echo '<span class="glyphicon glyphicon-star"></span>';
                  }
                
                ?>
                </p>
              </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Jumlah Transaksi</h5>
                    <span class="description-text"><?php echo $jumlahTransaksi; ?></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Usia</h5>
                    <span class="description-text"><?php echo $customer->Umur; ?></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">Gender</h5>
                    <span class="description-text"><?php echo $customer->JenisKelamin; ?></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
      </div>
        <!-- /.col -->

        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <div class="box-header with-border">
                <h3 class="box-title">Rincian Data</h3>
              </div>
              <div class="box-body">  
                <div class="col-md-3 col-sm-4"><span class="fa fa-user">&nbsp;&nbsp;Nama </span></div>
                <div class="col-md-3 col-sm-4"><?php echo $customer->Nama; ?></div>
                <br />
                <div class="col-md-3 col-sm-4"><span class="fa fa-location-arrow">&nbsp;&nbsp;Alamat</span></div>
                <div class="col-md-3 col-sm-4"><?php echo $customer->Alamat; ?></div>
                <br />
                <br />
                <div class="col-md-3 col-sm-4"><span class="fa fa-building-o">&nbsp;&nbsp;Kota</span></div>
                <div class="col-md-3 col-sm-4"><?php echo $customer->Kota; ?></div>
                <br />
                <div class="col-md-3 col-sm-4"><span class="fa fa-phone">&nbsp;&nbsp;No Telepon</span></div>
                <div class="col-md-3 col-sm-4"><?php echo $customer->Telepon; ?></div>
                <br />
                <div class="col-md-3 col-sm-4"><span class="fa fa-arrows">&nbsp;&nbsp;Tanggal Lahir</span></div>
                <div class="col-md-3 col-sm-4"><?php echo $customer->TanggalLahir; ?></div>
                <br />
                <div class="col-md-3 col-sm-4"><span class="fa fa-at">&nbsp;&nbsp;Email</span></div>
                <div class="col-md-3 col-sm-4"><?php echo $customer->Email; ?></div>
                <br />
              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->  

        <div class="col-md-9">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Histori Transaksi</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <?php echo $historiTransaksi ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
          </div>
</div>