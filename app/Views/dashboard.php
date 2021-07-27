<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<?php 
// echo "<pre>";
// print_r($link);
// echo "</pre>";
if (isset($_SESSION['page_failed'])) {
    echo $_SESSION['page_failed'];
}
 ?>
<div class="row">
    <?php 
    $i=0;
    foreach ($laporan as $key_laporan => $value_laporan): 
        // echo $key_laporan;
        // echo $i%4;
        $cls='';
        if ($i%4==0) {
            $cls="bg-gradient-primary";
        }elseif ($i%4==1) {
            $cls="bg-gradient-success";
        }elseif ($i%4==2) {
            $cls="bg-gradient-warning";
        }elseif ($i%4==3) {
            $cls="bg-gradient-danger";
        }
        ?>
        <div class="col-lg-3 col-6">
            <div class="card <?=$cls ?>">
                <div class="card-header">
                    <h3 class="card-title"><?=strtoupper($key_laporan) ?></h3>
                </div>
                <div class="p-1 card-body">
                    <ul>
                        <?php foreach ($value_laporan as $key_data => $value_data): ?>
                            <li>
                                <?= array_keys($value_data)[0] ?> 
                                : 
                                <?=($value_data['keterangan']=="Rp")?$value_data['keterangan']." ".number_format($value_data[array_keys($value_data)[0]],0,',','.'): $value_data[array_keys($value_data)[0]]." ".$value_data['keterangan']?>
                                
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="<?=$link[$key_laporan] ?>" class="" style="color:black;float: right; font-size: 13px">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <?php 
        $i++;
    endforeach 
    ?>
  
  
    <!-- <div class="col-lg-3 col-6"> -->
        <!-- small box -->
       <!--  <div class="small-box bg-danger">
            <div class="inner">
                <h3>0</h3>
                <p>Pengiriman</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div> -->
    <!-- </div> -->
    <!-- ./col -->
</div>
<!-- /.row -->
<?= $this->endSection(); ?>