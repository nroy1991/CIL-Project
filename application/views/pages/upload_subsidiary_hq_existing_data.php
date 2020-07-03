 <?php
$arr = array();

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div class="container">

	<?php if($this->session->flashdata('flashSuccess')){ ?>

		<div class="col-md-12">

			<div class="alert alert-success">

				<?php echo $this->session->flashdata('flashSuccess'); ?>

			</div>
</div>
	<?php }?>

<div class="container">
	
	<center><h3> Upload Subsidiary Headquarter Existing Manpower Data </h3> </center>


	<div class="form-container">
		<div class="form-container-form">
			<form class="form-horizontal" id="import_csv" method="POST" action="<?=site_url('pages/import_subsidiary_hq_existing_manpower')?>" enctype="multipart/form-data">
				

				<div class="form-group">
					<label class="control-label col-sm-2" for="sub_name">Subsidiary:</label>
					<div class="col-sm-10">
					 <select name="sub_name" id="sub_name" class="form-control input-lg" >
				     <option value="">Select Subsidiary</option>
					  <?php
					  foreach($sub_name as $row)
					  {
					     echo '<option value="'.$row->sub_id.'">'.$row->sub_name.'</option>';
					  }
					  ?>
					 </select>
					 </div>
				</div>


				 <div class="form-group">
					<label class="control-label col-sm-2" for="year_name">Year:</label>
					<div class="col-sm-10">
					 <select name="year_name" id="year_name" class="form-control input-lg" >
				     <option value="">Select Year</option>
					  <?php
					  foreach($year_name as $row)
					  {
					     echo '<option value="'.$row->year_id.'">'.$row->year_name.'</option>';
					  }
					  ?>
					 </select>
					 </div>
				</div>

				<!--<div class="form-group">
					<label class="control-label col-sm-2" for="production">Production Data:</label>
					<div class="col-sm-10"> 
						<input name="production" type="number" class="form-control" id="production" placeholder="Enter the mine production" step="0.01" min="0" required>
					</div>
				</div>-->

				
   <div class="form-group" >
    <label>Select CSV File</label>
    <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
   
   </div>
   
   <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
  
				<!--<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button name="login" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>-->
			</form>
			
		</div>

	</div>

		
		<!--<form method="post" id="import_csv" action="<?php echo base_url();?>index.php/pages/importcsv" enctype="multipart/form-data">
   <div class="form-group" >
    <label>Select CSV File</label>
    <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
   
   </div>
   
   <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
  </form>

  <div align="center">
		<label>Click here to download Format of CSV file</label>
		<br/>
		<a href="<?php echo site_url('pages/std_data_excel_format')?>" class= "btn btn-primary ">Download</a>

	</div>-->
 </div>
</body>
</html>





<style type="text/css">
.form-container{
	display: flex;
	min-height: 60vh;
	justify-content: center;
	align-items: center;
}

.form-container-form{
	width: 100%;
}
</style>



