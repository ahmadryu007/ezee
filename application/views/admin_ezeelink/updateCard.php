 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Data
        <small>Kartu</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Kartu</a></li>
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
              <h3 class="box-title">Data Kartu</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" action="<?php echo $base_url;?>index.php/cards/updateSubmit/<?php echo $card->NoKartu;?>" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>User ID</label>
                  <input type="text" class="form-control" name="UserId" placeholder="User ID">
                </div>
                <div class="form-group">
                  <label>No Kartu</label>
                  <input type="text" class="form-control" name="NoKartu" value="<?php echo $card->NoKartu;?>">
                </div>
                <div class="form-group">
                  <label>ID Merchant</label>
                  <input type="text" class="form-control" name="MerchantID" value="<?php echo $card->MerchantID;?>">
                </div>
                <!-- Date -->
              <div class="form-group">
                <label>Trans Date</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="TransDate" class="form-control pull-right" id="datepicker" value="<?php echo $card->TransDate;?>">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
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

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo $base_url; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script>
  $(document).ready(function(){
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>