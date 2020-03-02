
<?php require('head_c.php'); ?>
<div class="wrapper">
  <?php require('leftMenu.php'); 
$data=$obj->getData('product',1);
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Stock Report Out
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="stock_report_out.php">Stock Report Out </a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="box">
          <div class="box-body">
            <form action="stock_report_out.php" method="post">
              <div class="col-xs-12 col-md-12">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th colspan="2">Start Date<input type="text" autocomplete="off" name="d1" class="form-control datepicker"></th>
                      <th colspan="2">End Date<input type="text" autocomplete="off" name="d2" class="form-control datepicker"></th>
                      <th colspan="3"> <input type="submit" name="ok" value="Result" class="form-control btn btn-success btn-block"></th>
                    </tr>
                    <tr class="bg-primary">
                      <th>SL</th>
                      <th>Product</th>
                      <th>Stock</th>
                      <th>Price</th>
                      <th>Stock value</th>
                      <th>Depreciation Rate</th>
                      <th>Current value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=0; while ( $d=$data->fetch(PDO::FETCH_ASSOC)) { ++$i;
                      $sale=$obj->db->query("select sum(quantity) as s from stock_out where date between '".$_POST['d1']."' and '".$_POST['d2']."'and product_id=".$d['id'])->fetch(PDO::FETCH_ASSOC);
                      $parchase=$obj->db->query("select sum(quantity) as p from stock_in where date between '".$_POST['d1']."' and '".$_POST['d2']."'and product_id=".$d['id'])->fetch(PDO::FETCH_ASSOC);
                      $waste=$obj->db->query("select sum(quantity) as w from wastage where date between '".$_POST['d1']."' and '".$_POST['d2']."'and product_id=".$d['id'])->fetch(PDO::FETCH_ASSOC);
                      $return=$obj->db->query("select sum(quantity) as r from returns where date between '".$_POST['d1']."' and '".$_POST['d2']."'and product_id=".$d['id'])->fetch(PDO::FETCH_ASSOC);
                      ?>
                      <tr>   
                        <th><?php echo $i ?></th>
                        <th><?php echo $d['name']; ?></th>
                        <th><?php echo $stk=$parchase['p']-($sale['s']+$waste['w'])+$return['r']; ?></th>
                        <th class="text-right"><?php echo number_format($d['price'],2); ?></th>
                        <th class="text-right"><?php echo number_format( $stk*$d['price'],2) ?></th>
                        <th class="text-right"><?php echo number_format($d['depreciation'],2)  ?></th>
                        <th></th>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- /.content -->
</div>
</div>
<!-- ./wrapper -->
<?php require('footer_c.php');?>


