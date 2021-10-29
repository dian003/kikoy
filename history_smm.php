<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$Site = $this->Site->info();
?>
<?php $this->load->view('member/Header'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        History Pembelian
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Social Media</li>
        <li class="active">History Pembelian</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     <div class="row">
        <div class="col-md-12">

        <div class="box box-default">
            <div class="box-header with-border">

              <h3 class="box-title">
                 <a href="<?=base_url();?>" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>
              Riwayat Pembelian</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php 
            if($this->input->server('REQUEST_METHOD') == "POST"){
              $this->Orders->_CheckOrder($this->input->post('id'));
              echo "<div class='alert alert-success'>Pembelian ID : {$this->input->post('id')} Berhasil Di Cek Ulang</div>";
            }
            ?>
            <table class="table table-responsive table-bordered" id="History">
            	<thead>
                  <tr>
            	<th style="width:10%;">ID</th>
            	<th style="width:20%;">Layanan</th>
            	<th style="width:20%;">Target</th>
            	<th style="width:10%;">Jumlah</th>
            	<th style="width:10%;">Status</th>
            	<th style="width:10%;">Start</th>
            	<th style="width:10%;">Remains</th>
            	<th style="width:10%;">Tanggal</th>
                  <th style="width: 10%;">Aksi</th> 
                  </tr>
            	</thead>
            	<tbody>
            		<?php 
            		foreach($this->History->_List() as $result){ ?>
            		<tr> 
            		<td><?=$result->id;?></td>
            		<td ><?=$result->name;?></td>
            		<td><input class='form-control' value='<?=$result->target;?>' disabled></td>
            		<td><?=$result->quantity;?></td>
            		<td><?=$result->status;?></td>
            		<td><?=($result->start == null ? "0" : $result->start);?> </td>
                        <td><?=($result->remains == null ? "0" : $result->remains);?></td>
            		<td><?=$result->date;?></td>
            		<td><?php 
            		if($result->status == 'Completed' || $result->status == 'Partial' || $result->status == 'Cancelled'){
            		}else {
            		echo "<form method='post'><button class='btn btn-success' name='id' value='{$result->id}' data-toggle='tooltip' title='Cek Ulang Status Pembelian'><i class='fa fa-refresh'></i></button></form>";
            		}
            		?>
                 <?php 
            		}
            		?>
            	</tbody>
            </table>
           </div>
           </div>
           </div>

      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('member/Footer'); ?>
