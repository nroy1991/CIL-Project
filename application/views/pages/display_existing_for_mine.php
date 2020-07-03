<div class="container">
<div id="css_include">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/print.css')?>">
</div>
<div>
	 <h3 style="font-weight:bold;text-align:center;">Mine Wise Existing Data</h3>
	 </div>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<td>Subsidiary</td>
				<td><?=$sub_name?></td>
			</tr>
			<tr>
				<td>Area</td>
				<td><?=$area_name?></td>
			</tr>
			<tr>
				<td>Subarea</td>
				<td><?=$subarea_name?></td>
			</tr>
			<tr>
				<td>Mine</td>
				<td><?=$mine_name?></td>
			</tr>
			<tr>
				<td>Mine Type</td>
				<td><?=$mine_type.'('.$munit.')'?></td>
			</tr>
			<tr>
				<td>Year</td>
				<td><?=$year_name?></td>
			</tr>
			<tr>
				<td>Production</td>
				<td><?=$production?></td>
			</tr>
		</tbody>
	</table>
	<hr>
	
	<div class="row">
		<div class="col-sm-2 col-md-2">
		<a href="<?php echo site_url()?>" class= "btn btn-success ">Export as Excel Sheet </a>
		</div>

		<!--<div class="col-sm-2 col-md-2">
		<a  href="<?php echo base_url();?>index.php/pages/select_edit_standard_data" class= "btn btn-primary ">Edit Standard Data</a>
		</div>-->

	</div>
	
	<br><br><br>
	
	
	<table class="table table-bordered">

		<thead>
			<th>Cadre</th>
			<th>E1</th>
			<th>E2</th>
			<th>E3</th>
			<th>E4</th>
			<th>E5</th>
			<th>E6</th>
			<th>E7</th>
			<th>E8</th>
			<th>TOTAL EXECUTIVES</th>

			
		</thead>
		<tbody>
			<?php foreach ($values as $key): ?>
				<tr>
					<td><?=$key['cadre']?></td>
					<td><?=$key['e1']?></td>
					<td><?=$key['e2']?></td>
					<td><?=$key['e3']?></td>
					<td><?=$key['e4']?></td>
					<td><?=$key['e5']?></td>
					<td><?=$key['e6']?></td>
					<td><?=$key['e7']?></td>
					<td><?=$key['e8']?></td>
					<td><?php $result=$key['e1']+$key['e2']+$key['e3']+$key['e4']+$key['e5']+$key['e6']+$key['e7']+$key['e8'];
					echo $result;?></td>
				</tr>
			<?php endforeach ?>
			<tr>
				<?php
				echo'<td><b>Total Cadre Executives</b></td>';
				static $total_E1,$total_E2,$total_E3,$total_E4,$total_E5,$total_E6,$total_E7,$total_E8,$total_result;
				foreach($values as $key)
				{
					$total_E1+=$key['e1'];$total_E2+=$key['e2'];$total_E3+=$key['e3'];$total_E4+=$key['e4'];$total_E5+=$key['e5'];
					$total_E6+=$key['e6'];$total_E7+=$key['e7'];$total_E8+=$key['e8'];$total_result+=$result;;
				}
				$result1=$total_E1+$total_E2+$total_E3+$total_E4+$total_E5+$total_E6+$total_E7+$total_E8;
				echo '<td>'.$total_E1.'</td>';echo '<td>'.$total_E2.'</td>';echo '<td>'.$total_E3.'</td>';echo '<td>'.$total_E4.'</td>';
				echo '<td>'.$total_E5.'</td>';echo '<td>'.$total_E6.'</td>';echo '<td>'.$total_E7.'</td>';echo '<td>'.$total_E8.'</td>';echo '<td><b>'.($result1).'</b></td></tr>';
				?>
			</tr>

		</tbody>
	</table>

	
	<div class="row">
		<div class="col-sm-5"></div>
		<div class="col-sm-2">
			<div class="btn btn-primary" onclick="printer(this)">
				Print
			</div>
		</div>
	</div>


</div>

<script type="text/javascript">
	function printer(){
		$(".btn").hide();
		$('.navbar').hide();
		window.print();
		$(".btn").show();
		$('.navbar').show();
	}
	
</script>
<style>
th{
  background-color:whitesmoke;
}
td,th{
     text-align:center;
}
</style>
