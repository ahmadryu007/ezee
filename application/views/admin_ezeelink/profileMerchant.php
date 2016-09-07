<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile Merchant
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Merchant</a></li>
        <li class="active">Profile Merchant</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="" alt="Logo Merhant">

              <h3 class="profile-username text-center"><?php echo $merchant->Nama; ?></h3>

              <p class="text-muted text-center"><?php echo $merchant->Kategori; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Jumlah Transaksi</b> <label class="pull-right"><?php echo $jumlahTransaksi; ?></label>
                </li>
                <li class="list-group-item">
                  <b>Rating</b> <label class="pull-right"><?php echo $ratingMerchant; for ($i=0;$i<$ratingMerchant;$i++){
                    echo '<span class="glyphicon glyphicon-star"></span>';
                  } ?></label>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Tanggal Input</strong>
              <p class="text-muted"><?php echo $merchant->TanggalInput; ?></p>
              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i> Lokasi Toko</strong>
                <?php 
                  foreach ($tokoMerchant as $t) {
                    echo '<p class="text-muted">'.$t->Alamat.' ,'.$t->Kota.'</p>';
                  }
                ?>
              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Kategori</strong>
              <p><?php echo $merchant->Kategori; ?></p>
              <hr>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> Catatan</strong>
              <p><?php echo $merchant->Catatan; ?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Histori Transaksi</a></li>
              <li><a href="#timeline" data-toggle="tab">Keterangan</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <?php echo $historiTransaksi; ?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->