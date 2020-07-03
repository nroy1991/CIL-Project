 <div class="container">
<div id="css_include">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/print.css')?>">
</div>
<div>
	 <h3 style="font-weight:bold;text-align:center;">Mine Wise Data Comparison</h3>
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
				<td><?=$minecategory.'('.$munit.')'?></td>
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
			<th>TOTAL</th>
           <!--  <th>TOTAL EXCUETIVES</th> -->
			
		</thead>
		<tbody>
			<?php
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
									$x1 = $key1['newe1']-$key2['e1'];
									$x2 = $key1['newe2']-$key2['e2'];
									$x3 = $key1['newe3']-$key2['e3'];
									$x4 = $key1['newe4']-$key2['e4'];
									$x5 = $key1['newe5']-$key2['e5'];
									$x6 = $key1['newe6']-$key2['e6'];
									$x7 = $key1['newe7']-$key2['e7'];
									$x8 = $key1['newe8']-$key2['e8'];
									$x9 =$x1+$x2+$x3+$x4+$x5+$x6+$x7+$x8;
					                if (preg_match("/-/", $x1))
						               echo '<td style="background-color:LightPink;">'.$x1.'</td>';
					                else if($x1==0)
						               echo '<td style="background-color:LightGray;">'.$x1.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x1.'</td>';
						           if (preg_match("/-/", $x2))
						               echo '<td style="background-color:LightPink;">'.$x2.'</td>';
					                else if($x2==0)
						               echo '<td style="background-color:LightGray;">'.$x2.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x2.'</td>';
						           if (preg_match("/-/", $x3))
						               echo '<td style="background-color:LightPink;">'.$x3.'</td>';
					                else if($x3==0)
						               echo '<td style="background-color:LightGray;">'.$x3.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x3.'</td>';
						           if (preg_match("/-/", $x4))
						               echo '<td style="background-color:LightPink;">'.$x4.'</td>';
					                else if($x4==0)
						               echo '<td style="background-color:LightGray;">'.$x4.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x4.'</td>';
						           if (preg_match("/-/", $x5))
						               echo '<td style="background-color:LightPink;">'.$x5.'</td>';
					                else if($x5==0)
						               echo '<td style="background-color:LightGray;">'.$x5.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x5.'</td>';
						           if (preg_match("/-/", $x6))
						               echo '<td style="background-color:LightPink;">'.$x6.'</td>';
					                else if($x6==0)
						               echo '<td style="background-color:LightGray;">'.$x6.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x6.'</td>';
						           if (preg_match("/-/", $x7))
						               echo '<td style="background-color:LightPink;">'.$x7.'</td>';
					                else if($x7==0)
						               echo '<td style="background-color:LightGray;">'.$x7.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x7.'</td>';
						           if (preg_match("/-/", $x8))
						               echo '<td style="background-color:LightPink;">'.$x8.'</td>';
					                else if($x8==0)
						               echo '<td style="background-color:LightGray;">'.$x8.'</td>';
					                else
									   echo '<td style="background-color:LightGreen;">'.$x8.'</td>';
									   if (preg_match("/-/", $x9))
						               echo '<td style="background-color:red;">'.$x9.'</td>';
					                else if($x8==0)
						               echo '<td style="background-color:Gray;">'.$x9.'</td>';
					                else
						               echo '<td style="background-color:Green;">'.$x9.'</td>';
						            
								   
							   }
							}
						}
					if($flag==0)
					{ 
					                $x1 = $key1['newe1'];
									$x2 = $key1['newe2'];
									$x3 = $key1['newe3'];
									$x4 = $key1['newe4'];
									$x5 = $key1['newe5'];
									$x6 = $key1['newe6'];
									$x7 = $key1['newe7'];
									$x8 = $key1['newe8'];
									$x9 =$x1+$x2+$x3+$x4+$x5+$x6+$x7+$x8;
					                if (preg_match("/-/", $x1))
						               echo '<td style="background-color:LightPink;">'.$x1.'</td>';
					                else if($x1==0)
						               echo '<td style="background-color:LightGray;">'.$x1.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x1.'</td>';
						           if (preg_match("/-/", $x2))
						               echo '<td style="background-color:LightPink;">'.$x2.'</td>';
					                else if($x2==0)
						               echo '<td style="background-color:LightGray;">'.$x2.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x2.'</td>';
						           if (preg_match("/-/", $x3))
						               echo '<td style="background-color:LightPink;">'.$x3.'</td>';
					                else if($x3==0)
						               echo '<td style="background-color:LightGray;">'.$x3.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x3.'</td>';
						           if (preg_match("/-/", $x4))
						               echo '<td style="background-color:LightPink;">'.$x4.'</td>';
					                else if($x4==0)
						               echo '<td style="background-color:LightGray;">'.$x4.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x4.'</td>';
						           if (preg_match("/-/", $x5))
						               echo '<td style="background-color:LightPink;">'.$x5.'</td>';
					                else if($x5==0)
						               echo '<td style="background-color:LightGray;">'.$x5.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x5.'</td>';
						           if (preg_match("/-/", $x6))
						               echo '<td style="background-color:LightPink;">'.$x6.'</td>';
					                else if($x6==0)
						               echo '<td style="background-color:LightGray;">'.$x6.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x6.'</td>';
						           if (preg_match("/-/", $x7))
						               echo '<td style="background-color:LightPink;">'.$x7.'</td>';
					                else if($x7==0)
						               echo '<td style="background-color:LightGray;">'.$x7.'</td>';
					                else
						               echo '<td style="background-color:LightGreen;">'.$x7.'</td>';
						           if (preg_match("/-/", $x8))
						               echo '<td style="background-color:LightPink;">'.$x8.'</td>';
					                else if($x8==0)
						               echo '<td style="background-color:LightGray;">'.$x8.'</td>';
					                else
									   echo '<td style="background-color:LightGreen;">'.$x8.'</td>';
									   if (preg_match("/-/", $x9))
						               echo '<td style="background-color:red;">'.$x9.'</td>';
					                else if($x8==0)
						               echo '<td style="background-color:Gray;">'.$x9.'</td>';
					                else
						               echo '<td style="background-color:Green;">'.$x9.'</td>';
								   
					}
				echo '</tr>';
				}
				?>
				<?php
			   echo'
			   <tr><td>Total Cadre Executives</td>';
			   static $total_e1,$total_e2,$total_e3,$total_e4,$total_e5,$total_e6,$total_e7,$total_e8;
			   foreach ($values[0] as $key1)
			 {
				 $flag=0;
						 if (!empty($values[1])) 
						 { 
							 foreach ($values[1] as $key2)
							 {
								 if($key1['cadre'] == $key2['cadre'])
								 {  $flag=1;
									 $total_e1 += $key1['newe1']-$key2['e1'];
									 $total_e2 += $key1['newe2']-$key2['e2'];
									 $total_e3 += $key1['newe3']-$key2['e3'];
									 $total_e4 += $key1['newe4']-$key2['e4'];
									 $total_e5 += $key1['newe5']-$key2['e5'];
									 $total_e6 += $key1['newe6']-$key2['e6'];
									 $total_e7 += $key1['newe7']-$key2['e7'];
									 $total_e8 += $key1['newe8']-$key2['e8'];
								}
							 }
						 }
					 if($flag==0)
					 { 
						 $total_e1 += $key1['newe1'];
						 $total_e2 += $key1['newe2'];
						 $total_e3 += $key1['newe3'];
						 $total_e4 += $key1['newe4'];
						 $total_e5 += $key1['newe5'];
						 $total_e6 += $key1['newe6'];
						 $total_e7 += $key1['newe7'];
						 $total_e8 += $key1['newe8'];
					 }
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

