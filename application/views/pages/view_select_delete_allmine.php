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

</head>
<body>
	<div class="container">
		<div class="row">

			<div class="col-sm-2 col-md-2">
			</div>
			<div class="col-sm-8 col-md-12">
				<h2 align="center">Delete Area</h2>
				<br>

				<table class="table table-bordered table-striped">
			        <thead>
			            <tr>
			                <th class="text-center">S. No.</th>
			                <th class="text-center">Subsidiary</th>
			                 <th class="text-center">Area</th>
			                 <th class="text-center">Subarea</th>
			                 <th class="text-center">Mine</th>
			                 <th class="text-center">Mine Type</th>
			                 <th class="text-center">Year</th>
			                 <th class="text-center">SR</th>
			                 <th class="text-center">Coal</th>
			                 <th class="text-center">OBR</th>
			                 <th class="text-center">Total Excavation</th>
			                 <th class="text-center">Production</th>
			                <th class="text-center">Action</th>
			            </tr>
			        </thead>

			        <tbody align="center">
			            <?php
			            $rn=1;
			            if(isset($allmine)){
			                foreach($allmine as $allmine){
			                    echo '
			                        <tr>
			                            <td>'.$rn.'</td>
			                            <td>'.$allmine['sub_name'].'</td>
			                            <td>'.$allmine['area_name'].'</td>
			                            <td>'.$allmine['subarea_name'].'</td>
			                            <td>'.$allmine['mine_name'].'</td>
			                            <td>'.$allmine['minecategory'].'</td>
			                            <td>'.$allmine['year_name'].'</td>
			                            <td>'.$allmine['SR'].'</td>
			                            <td>'.$allmine['coal'].'</td>
			                            <td>'.$allmine['OBR'].'</td>
			                            <td>'.$allmine['tot_excavation'].'</td>
			                            <td>'.$allmine['production'].'</td>
			                            
                                        <td>
                                            <a href="'.site_url("allmines/delete_allmine/".$allmine['mine_id']).'"<button class="btn btn-danger">Delete</button></a>
                                        </td>
			                        </tr>';
			                    $rn++;
			                }
			            }
			            ?>
			        </tbody>
			    </table>
			</div>
			
		</div>
	</div>
</body>
</html>