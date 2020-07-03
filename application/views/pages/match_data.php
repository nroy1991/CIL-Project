<!DOCTYPE html>
<html>
<head>
  <title></title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>CSS/homeStyle.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
  $("#show").click(function(){
    $("table").show();
  });
	</script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/pages/mines.css">
	<style type="text/css">
.form-container{
	display: flex;
	min-height: 80vh;
	justify-content: center;
	align-items: center;
}
body{
	overflow-x:hidden!important;
}
.form-container-form{
	width: 100%;
}
</style>
<?php
$arr = array();
$arr[-1]= "--Select--";
$i=0;
foreach($mine as $m )
{
	$arr[$m['mine_id']] = $m['minecategory']."(".$m['munit'].")";
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</head>


<body style=" background-image: url('<?php echo base_url("assets/images/buringCoal.jpg"); ?>') ; background-position: center center;
    background-size: 100% 100%;">

<div class="container">
	<center><h1 style="color:#FFFFFF; background-color: transparent !important;"> Input Mine data  </h1> </center>
	<div class="form-container">
		<div class="form-container-form">
			<form class="form-horizontal" method="POST" action="<?=site_url('pages/get_match_data')?>" >			
				<div class="form-group">
					<label class="control-label col-sm-2" for="submine"  style="color:#FFFFFF">MineType:</label>
					<div class="col-sm-10">
									<?php
						echo form_dropdown('submine', $arr, '', 'class="form-control" name = "mine_type" id="submine"');
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="mine-production" style="color:#FFFFFF">Production Data:</label>
					<div class="col-sm-10"> 
						<input name="mine_production" type="number" class="form-control" id="mine-production" placeholder="Enter the mine production" step="0.01" min="0" required>
					</div>
				</div>
				<div> 
					<div class="col-sm-offset-2 col-sm-10">
						<span>
						<button name="login" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
	<br><br><br><br><br><br><br>
			<div align="center">
			<label style="color:white;">Click here to download Format of CSV file</label>
			<br/>
			<button name="login" type="submit" class="btn btn-primary">Download</button>

			</div>
		</div>
	</div>
</div>
</body>
</html>