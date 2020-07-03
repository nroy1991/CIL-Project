<div class="container">
<div id="css_include">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/print.css')?>">
</div>
<div>
	 <h3 style="font-weight:bold;text-align:center;">Mine Wise Standard Data</h3>
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
				<td><?=$mine_type?></td>
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
		<a href="<?php echo site_url('pages/excel')?>" class= "btn btn-success ">Export as Excel Sheet </a>
		</div>

		<div class="col-sm-2 col-md-2">
		<a  href="<?php echo base_url();?>index.php/pages/select_edit_standard_data" class= "btn btn-primary ">Edit Standard Data</a>
		</div>

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
			<th>Total Executives</th>
			<!--<th>Total</th>-->
			
		</thead>
		<tbody>
			<?php
			static $tot=0;
			foreach ($values[0] as $key1)
			{
				$flag=0;
				echo '<tr><td>'.$key1['cadre'].'</td>';
						if (!empty($values[1])) 
						{ 
							foreach ($values[1] as $key2)
							{
								if($key1['cadre'] == $key2['cadre'])
								{  $flag=1;
									$tot+=$key1['e1']+$key2['e1']+$key1['e2']+$key2['e2']+$key1['e3']+$key2['e3']+$key1['e4']+$key2['e4']
								   +$key1['e5']+$key2['e5']+$key1['e6']+$key2['e6']+$key1['e7']+$key2['e7']+$key1['e8']+$key2['e8'];
								echo '<td>'.($key1['e1']+$key2['e1']).'</td>';
								echo '<td>'.($key1['e2']+$key2['e2']).'</td>';
								echo '<td>'.($key1['e3']+$key2['e3']).'</td>';
								echo '<td>'.($key1['e4']+$key2['e4']).'</td>';
								echo '<td>'.($key1['e5']+$key2['e5']).'</td>';
								echo '<td>'.($key1['e6']+$key2['e6']).'</td>';
								echo '<td>'.($key1['e7']+$key2['e7']).'</td>';
								echo '<td>'.($key1['e8']+$key2['e8']).'</td>';
								echo '<td>'.($key1['e1']+$key2['e1']+$key1['e2']+$key2['e2']+$key1['e3']+$key2['e3']+$key1['e4']+$key2['e4']
								+$key1['e5']+$key2['e5']+$key1['e6']+$key2['e6']+$key1['e7']+$key2['e7']+$key1['e8']+$key2['e8']).'</td>'; 
							   }
							}
						}

					if($flag==0)
					{ 
						$tot+=$key1['e1']+$key1['e2']+$key1['e3']+$key1['e4']+$key1['e5']+$key1['e6']+$key1['e7']+$key1['e8'];
					   echo '<td>'.$key1['e1'].'</td>';
					   echo '<td>'.$key1['e2'].'</td>';
					   echo '<td>'.$key1['e3'].'</td>';
					   echo '<td>'.$key1['e4'].'</td>';
					   echo '<td>'.$key1['e5'].'</td>';
					   echo '<td>'.$key1['e6'].'</td>';
					   echo '<td>'.$key1['e7'].'</td>';
					   echo '<td>'.$key1['e8'].'</td>';
					   echo '<td>'.($key1['e1']+$key1['e2']+$key1['e3']+$key1['e4']+$key1['e5']+$key1['e6']+$key1['e7']+$key1['e8']).'</td>';
					}
				echo '</tr>';
				}
			  echo'
			  <td><b>Total Cadre Executives</b></td>';
			  static $total_e1,$total_e2,$total_e3,$total_e4,$total_e5,$total_e6,$total_e7,$total_e8;
			  foreach($values[0] as $key1)
			  {
				  $f=0;
			    if (!empty($values[1]))
			    {	  
			      foreach($values[1] as $key2)
			       {
					   if($key1['cadre']==$key2['cadre'])
					   {
						   $f=1;
				         $total_e1+=$key1['e1']+$key2['e1'];$total_e2+=$key1['e2']+$key2['e2'];$total_e3+=$key1['e3']+$key2['e3'];$total_e4+=$key1['e4']+$key2['e4'];$total_e5+=$key1['e5']+$key2['e5'];
						 $total_e6+=$key1['e6']+$key2['e6'];$total_e7+=$key1['e7']+$key2['e7'];$total_e8+=$key1['e8']+$key2['e8'];
					   }
				   }
			    }
			   if($f==0)
			    {
				  $total_e1+=$key1['e1'];$total_e2+=$key1['e2'];$total_e3+=$key1['e3'];$total_e4+=$key1['e4'];$total_e5+=$key1['e5'];
				  $total_e6+=$key1['e6'];$total_e7+=$key1['e7'];$total_e8+=$key1['e8'];
				}
			  }
			  echo '<td>'.$total_e1.'</td>';echo '<td>'.$total_e2.'</td>';echo '<td>'.$total_e3.'</td>';echo '<td>'.$total_e4.'</td>';
			  echo '<td>'.$total_e5.'</td>';echo '<td>'.$total_e6.'</td>';echo '<td>'.$total_e7.'</td>';echo '<td>'.$total_e8.'</td>'; echo '<td><b>'.$tot.'</b></td></tr>';
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
	td,th
	{
		text-align:center;
	}
	th{
		background-color:whitesmoke;
	}
	</style>
