<div class="container">
<div id="css_include">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/print.css')?>">
</div>
<div>
	 <h3 style="font-weight:bold;text-align:center;">Area Wise Data Comparision</h3>
	 </div>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th style="background-color:whitesmoke;">Mine Type</th>
                <td>
                    <?php
                      echo $key1[1]['mine_type'];
                    ?>
                </td>
			</tr>

			<tr>
				<th style="background-color:whitesmoke;">Production</th>
				<td>
                <?php
                      echo $key1[1]['production'];
                    ?>
                </td>
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
	
	<br><br>
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
			<!--<th>Total</th>-->
			
		</thead>
		<tbody>
            <?php
            if($key1[1]['cadre']!=NULL):
            $i=1;foreach($key1 as $key){
             $flag=1;       
            echo '<tr>
            <td>'.$key['cadre'].'</td>
            <td>'.$key['E1'].'</td>
            <td>'.$key['E2'].'</td>
            <td>'.$key['E3'].'</td>
            <td>'.$key['E4'].'</td>
            <td>'.$key['E5'].'</td>
            <td>'.$key['E6'].'</td>
            <td>'.$key['E7'].'</td>
            <td>'.$key['E8'].'</td>
            <td>'.$result=$key['E1']+$key['E2']+$key['E3']+$key['E4']+$key['E5']+$key['E6']+$key['E7']+$key['E8'].'</td>
            </tr>';
            $i++;}
                  echo '<tr>
                  <td><b>Total Cadre Executives</b></td>';
                  static $total_E1,$total_E2,$total_E3,$total_E4,$total_E5,$total_E6,$total_E7,$total_E8;
                  foreach($key1 as $key)
                  { 
                      $total_E1+=$key['E1'];$total_E2+=$key['E2'];$total_E3+=$key['E3'];$total_E4+=$key['E4'];$total_E5+=$key['E5'];
                      $total_E6+=$key['E6'];$total_E7+=$key['E7'];$total_E8+=$key['E8'];
                  }
                  echo '<td>'.$total_E1.'</td>';echo '<td>'.$total_E2.'</td>';echo '<td>'.$total_E3.'</td>';echo '<td>'.$total_E4.'</td>';
                  echo '<td>'.$total_E5.'</td>';echo '<td>'.$total_E6.'</td>';echo '<td>'.$total_E7.'</td>';echo '<td>'.$total_E8.'</td><td>---</td></tr>';
                else:
                echo "<br><br><h2>NO DATA IS FOUND</h2>";
                endif;
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
<style>
    th{
        background-color:whitesmoke;
    }
   th, td{
       text-align:center;
    }
    </style>
<script type="text/javascript">
	function printer(){
		$(".btn").hide();
		$('.navbar').hide();
		window.print();
		$(".btn").show();
		$('.navbar').show();
	}
	
</script>
