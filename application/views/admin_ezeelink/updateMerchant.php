 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Data
        <small>Merchant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Merchant</a></li>
        <li class="active">Edit Data</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Merchant</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="<?php echo $base_url;?>index.php/merchants/updateSubmit/<?php echo $merchant->MerchantID; ?>" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>ID Merchant</label>
                  <input type="text" class="form-control" name="MerchantID" value="<?php echo $merchant->MerchantID; ?>">
                </div>
                <div class="form-group">
                  <label>Nama Merchant</label>
                  <input type="text" class="form-control" name="NamaMerchant" value="<?php echo $merchant->Nama; ?>">
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select class="form-control" name="KategoriID">
                    <?php 
                      foreach($kategori as $k){
                        echo '<option value="'.$k->KategoriID.'">'.$k->Nama.'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Facebook</label>
                  <input type="tel" class="form-control" name="AlamatFB" value="<?php echo $merchant->AlamatFB;?>">
                </div>
                <div class="form-group">
                  <label>Twitter</label>
                  <input type="tel" class="form-control" name="AlamatTW" value="<?php echo $merchant->AlamatTW;?>">
                </div>
                <div class="form-group">
                  <label>Website</label>
                  <input type="tel" class="form-control" name="AlamatWWW" value="<?php echo $merchant->AlamatWWW;?>">
                </div>
                <div class="form-group">
                  <label>Tagline</label>
                  <input type="tel" class="form-control" name="Tagline" value="<?php echo $merchant->Tagline;?>">
                </div>
                <div class="form-group">
                <label>Tanggal Input</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="TanggalInput" class="form-control pull-right" id="datepicker" value="<?php echo $merchant->TanggalInput ?>">
                </div>
                <!-- /.input group -->
              </div>
                <div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="Catatan" cols="40" rows="5"><?php echo $merchant->Catatan;?></textarea>
                </div>

                <div class="form-group">
                  <label for="Logo">Logo</label>
                  <input type="file" id="Logo">

                  <p class="help-block"></p>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script src="<?php echo $base_url; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script>
  $(document).ready(function(){
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>