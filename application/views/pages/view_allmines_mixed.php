<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>CSS/homeStyle.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/pages/mines.css">

</head>
<body style=" background-image: url('<?php echo  base_url("assets/images/cilOffice.jpg"); ?>') ; background-position: center center;background-size: 100%; background-attachment:fixed;">
	<div class="container">
		<div class="row">

			<!-- <div class="col-sm-2 col-md-2">
			</div> -->
			<div class="col-md-12">
				<h2 align="center"><?php echo $header;?></h2>
				<br>
				<div class="row">

					<div class="col-sm-4 col-md-4">
						<?php echo '<a href="'.site_url("allmines/add_allmine").'"<button class="btn btn-primary">Add Mine</button></a>'; ?>
					</div>
					<div class="col-sm-4 col-md-4">
						<?php echo '<a href="'.site_url("allmines/select_delete_allmine").'"<button class="btn btn-primary">Delete Mine</button></a>'; ?>
					</div>

				</div>
				<br>

				<table style="margin-left: -10vw!important;" class="table table-bordered table-striped" style="width:100%">
			        <thead>
			            <tr>
			                <th class="text-center">S.No.</th>
			                <th class="text-center">Subsidiary</th>
			                <th class="text-center">Area</th>
			                <th class="text-center">Subarea</th>
			                <th class="text-center">Mines</th>
			                <th class="text-center">Mine-Type</th>
			                <th class="text-center">Year</th>
			                <th class="text-center">SR(m3/t)</th>
							<th class="text-center">Coal Departmental UG(Mty)</th>
							<th class="text-center">Coal Outsource UG(Mty)</th>
							<th class="text-center">Total Coal UG(Mty)</th>
							<th class="text-center">Coal Departmental OC(Mm3)</th>
							<th class="text-center">Coal Outsource OC(Mm3)</th>
			                <th class="text-center">Total Coal OC(Mm3)</th>
			                <th class="text-center">OBR Departmental(Mt)</th>
							<th class="text-center">OBR Outsource(Mt)</th>
							<th class="text-center">Total OBR(Mt)</th>
							<th class="text-center">Total Excavation Outsource(Mm3)</th>
							<th class="text-center">Total Excavation Departmental(Mm3)</th>
			                <th class="text-center">Total Excavation(Mm3)</th>
			                <!-- <th class="text-center">Departmental Production</th> -->
			                <th class="text-center">Total Coal (UG + OC)</th>
			                <th class="text-center">Action</th>
			           
			            </tr>
			        </thead>

			        <tbody align="center">
			            <?php
			               $rn=1;
			            if(isset($allmines_mixed)){
			                foreach($allmines_mixed as $row){
			                    echo '
			                        <tr>
			                            <td>'.$rn.'</td>
			                            <td>'.$row['sub_name'].'</td>
			                            <td>'.$row['area_name'].'</td>
			                            <td>'.$row['subarea_name'].'</td>
			                            <td>'.$row['mine_name'].'</td>
			                            <td>'.$row['minecategory'].'</td>
			                            <td>'.$row['year_name'].'</td>
			                            <td>'.$row['SR'].'</td>
										<td>'.$row['coal_dept_UG'].'</td>
										<td>'.$row['coal_out_UG'].'</td>
										<td>'.$row['tot_coal_UG'].'</td>
										<td>'.$row['coal_dept_OC'].'</td>
										<td>'.$row['coal_out_OC'].'</td>
										<td>'.$row['tot_coal_OC'].'</td>
										<td>'.$row['OBR_dept'].'</td>
										<td>'.$row['OBR_out'].'</td>
										<td>'.$row['tot_OBR'].'</td>
										<td>'.$row['tot_excavation_dept'].'</td>
										<td>'.$row['tot_excavation_out'].'</td>
										<td>'.$row['tot_excavation'].'</td>
			                            <td>'.$row['tot_coal_UG_OC'].'</td>
			                            <td><a href="'.site_url("allmines/edit_allmine/".$row['mine_id']).'"<button class="btn btn-primary">Edit</button></a>
			                            </td>
			                           
			                        </tr>';
			                    $rn++;
			                }
			            }
			            ?>
			        </tbody>
			    </table>

			    <form method="post" id="import_csv" action="<?php echo base_url();?>index.php/pages/import_mine_mixed_csv" enctype="multipart/form-data">
   <div class="form-group" >
    <label style="color: white">Select CSV File</label>
    <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
   
   </div>
   
   <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
  </form>

  <div align="center">
		<label style="color: white">Click here to download Format of CSV file</label>
		<br/>
		<a href="<?php echo site_url('pages/mine_data_excel_format')?>" class= "btn btn-primary ">Download</a>

	</div>
		</div>

			</div>
			
	</div>
</body>
</html>