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
			<div class="col-sm-8 col-md-8">
				<div class="row">

					<div class="col-sm-2 col-md-2">
						<?php echo '<a href="'.site_url("pages/add_grade").'"<button class="btn btn-primary">Add Grade</button></a>'; ?>
					</div>

					<div class="col-sm-2 col-md-2">
						<?php echo '<a href="'.site_url("pages/select_edit_grade").'"<button class="btn btn-primary">Edit Grade</button></a>'; ?>
					</div>

					
					<div class="col-sm-4 col-md-4">
						<?php echo '<a href="'.site_url("pages/select_delete_grade").'"<button class="btn btn-primary">Delete Grade</button></a>'; ?>
					</div>

				</div>
				<h2 align="center"><?php echo $header;?></h2>

				<table class="table table-bordered table-striped" id="designation">
			        <thead>
			            <tr>
			                <th class="text-center">S. No.</th>
			                <th class="text-center">Grade</th>
			               <!--  <th class="text-center">Designation</th>
			                <th class="text-center">Discipline</th> -->
			            </tr>
			        </thead>

			        <tbody align="center">
			            <?php
			            $rn=1;
			            if(isset($grades)){
			                foreach($grades as $grade){
			                	/*$disc="";
			                	if($grade['discipline']=='a')	$disc='All Discipline<br>(except Medical)';
			                	else $disc='Medical';
			                	if($grade['remark']==""){
			                		echo '
			                		    <tr>
			                		        <td>'.$rn.'</td>
			                		        <td>'.$grade['grade'].'</td>
			                		        
			                		    </tr>';
			                	}
			                	else*/
			                    	echo '
				                        <tr>
				                            <td>'.$rn.'</td>
				                            <td>'.$grade['grade'].'</td>
				                          
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
<!-- script not working
<script type="text/javascript">
    $(function(){
        $("#designation").dataTable({
            "bPaginate" : true,
            "bLengthChange":true,
            "bFilter" : true,
            "bSort"  :true,
            "bInfo" :true,
            "bAutoWidth" :true
        });    
    });
</script> -->