<div class="container">
<div id="css_include">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/print.css')?>">
</div>
<div>
	 <h3 style="font-weight:bold;text-align:center;">Subsidiary Headquarter Data Comparison</h3>
	 </div>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<td>Subsidiary</td>
				<td><?=$sub_name?></td>
			</tr>
			<tr>
				<td>Year</td>
				<td><?=$year_name?></td>
			</tr>
			<!--<tr>
				<td>Production</td>
				<td><?=$production?></td>
			</tr>-->
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
			<th>TOTAL</th>

			
		</thead>
		<tbody>
			<?php foreach ($values as $key): ?>
				<tr>
					<td><?=$key['cadre']?></td>
					<td <?php $x1 = $key['newe1']; 
					if (preg_match("/-/", $x1))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x1==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}  
					?>><?= $key['newe1'];?></td>
					<td <?php $x2 = $key['newe2']; 
					 if (preg_match("/-/", $x2))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x2==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}
					?>><?= $key['newe2']; ?></td>
					<td <?php $x3 = $key['newe3']; 
					 if (preg_match("/-/", $x3))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x3==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}
					?>><?=$key['newe3']?></td>
					<td <?php $x4 = $key['newe4']; 
					 if (preg_match("/-/", $x4))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x4==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}
					?>><?=$key['newe4']?></td>
					<td <?php $x5 = $key['newe5']; 
					 if (preg_match("/-/", $x5))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x5==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}
					?>><?=$key['newe5']?></td>
					<td <?php $x6 = $key['newe6']; 
					 if (preg_match("/-/", $x6))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x6==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}
					?>><?=$key['newe6']?></td>
					<td <?php $x7 = $key['newe7']; 
					 if (preg_match("/-/", $x7))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x7==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}
					?>><?=$key['newe7']?></td>
					<td <?php $x8 = $key['newe8']; 
					 if (preg_match("/-/", $x8))
					{
						echo "style="."background-color:"."LightPink;";
					}
					else if($x8==0)
					{
						echo "style="."background-color:"."LightGray;";
					}
					else
					{
						echo "style="."background-color:"."LightGreen;";
					}
					?>><?=$key['newe8']?></td>
					<td <?php $x8 =$key['newe1']+$key['newe2']+$key['newe3']+$key['newe4']+$key['newe5']+$key['newe6']+$key['newe7']+$key['newe8']; 
					 if (preg_match("/-/", $x8))
					{
						echo "style="."background-color:"."red;";
					}
					else if($x8==0)
					{
						echo "style="."background-color:"."Gray;";
					}
					else
					{
						echo "style="."background-color:"."Green;";
					}
					?>><?=($key['newe1']+$key['newe2']+$key['newe3']+$key['newe4']+$key['newe5']+$key['newe6']+$key['newe7']+$key['newe8'])?></td>
					
				</tr>
			<?php endforeach ?>
			<?php
			echo'
			  <td>Total Cadre Executives</td>';
			  static $total_e1,$total_e2,$total_e3,$total_e4,$total_e5,$total_e6,$total_e7,$total_e8;
			  foreach($values as $key)
			  {
				  $total_e1+=$key['newe1'];$total_e2+=$key['newe2'];$total_e3+=$key['newe3'];$total_e4+=$key['newe4'];$total_e5+=$key['newe5'];
				  $total_e6+=$key['newe6'];$total_e7+=$key['newe7'];$total_e8+=$key['newe8'];
			  }
			  echo '<td>'.$total_e1.'</td>';echo '<td>'.$total_e2.'</td>';echo '<td>'.$total_e3.'</td>';echo '<td>'.$total_e4.'</td>';
			  echo '<td>'.$total_e5.'</td>';echo '<td>'.$total_e6.'</td>';echo '<td>'.$total_e7.'</td>';echo '<td>'.$total_e8.'</td><td><b>'.($total_e1+$total_e2+$total_e3+$total_e4+$total_e5+$total_e6+$total_e7+$total_e8).'</b></td></tr>';
			?>

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
tr,th{
   text-align:center;
}
th{
    background-color:whitesmoke;
}
</style>
