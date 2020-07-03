

<div class="container">
	<div class="row">
		<div class="col-md-2 col-sm-2">
		</div>
		<div class="col-md-8 col-sm-8">
			<?php echo form_open_multipart('pages/save_std_dynamic_data'); ?>

			<div class="row">
			    <div class="col-md-12  ">

			        <!-- Error Form-->
			        <?php if ($error):?>
			            <div class="alert alert-danger alert-dismissible">
			                <?php echo $error; ?>
			            </div>
			        <?php endif; ?>


			        <div class="box box-solid box-primary">
			            <div class="box-header">
			                <h3 class="box-title" align="center"><?php echo $header.'<br><br>';?></h3>
			            </div>

			            <div class="box-body">

			            
			                

			                <div class="row">
			                	<div class="col-md-2">
			                	</div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="mine_type">Mine Type<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php /* echo form_input(array('name' => 'sub_name', 'id' => 'sub_name', 'placeholder' => 'Subsidiary', 'class' => 'form-control')) */ ?>
                                        <select class="form-control" id="mine_id" name="mine_id">
			                            <option>Select</option>

			                            <?php foreach ($mine_type as $value) { ?>

			                            	<option value="<?php echo $value['mine_id'] ?>"><?php echo $value['minecategory'] ?></option>
			                            	
			                           <?php } ?> 

								          <!-- <?php
										  foreach($mine_type as $row)
										  {
										     echo '<option value="'.$row->mine_id.'">'.$row->minecategory.'</option>';
										  }
										  ?> -->

			                        </select>
			                        </div>
			                    </div>
			                </div>

			                

			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="LL">Lower Limit<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
									  
									  <select class="form-control" id="LL" name="LL">
									    <option>Select</option>
									   
									  </select>
									</div>
			                    </div>

			                </div>

			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="UL">Upper Limit<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
									  
									  <select class="form-control" id="UL" name="UL">
									    <option>Select</option>
									   
									  </select>
									</div>
			                    </div>
			                    

			                </div>

			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="min_prod">Minimum Production<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'min_prod', 'id' => 'min_prod', 'placeholder' => 'Minimum Production', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>

			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="max_prod">Maximum Production<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'max_prod', 'id' => 'max_prod', 'placeholder' => 'Maximum Production', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="cadre">Cadre<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                     <div class="col-md-3">
			                        <div class="form-group">
			                            <?php /* echo form_input(array('name' => 'sub_name', 'id' => 'sub_name', 'placeholder' => 'Subsidiary', 'class' => 'form-control')) */ ?>
                                        <select class="form-control" name="cadre">
			                            <option>select</option>

			                            <?php foreach ($cadre as $value) { ?>

			                            	<option value="<?php echo $value['sno'] ?>"><?php echo $value['cil_cadre'] ?></option>
			                            	
			                           <?php } ?>

			                        </select>
			                        </div>
			                    </div>

			                </div>

			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E1">E1<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E1', 'id' => 'E1', 'placeholder' => 'E1', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E2">E2<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E2', 'id' => 'E2', 'placeholder' => 'E2', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E3">E3<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E3', 'id' => 'E3', 'placeholder' => 'E3', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E4">E4<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E4', 'id' => 'E4', 'placeholder' => 'E4', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E5">E5<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E5', 'id' => 'E5', 'placeholder' => 'E5', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E6">E6<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E6', 'id' => 'E6', 'placeholder' => 'E6', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E7">E7<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E7', 'id' => 'E7', 'placeholder' => 'E7', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>
			                <div class="row">
			                    <div class="col-md-2">
			                	</div>
			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <label for="E8">E8<i style="color:red; font-size:14px;" >*</i></label>
			                        </div>
			                    </div>

			                    <div class="col-md-3">
			                        <div class="form-group">
			                            <?php echo form_input(array('name' => 'E8', 'id' => 'E8', 'placeholder' => 'E8', 'class' => 'form-control')) ?>
			                        </div>
			                    </div>

			                </div>

			            </div>
			        </div>

			        <div class="box-footer">
			            <div class="row">
			                <div class="col-md-5">
			                </div>
			                <div class="col-md-2">
			                    <?php echo form_submit('submit', 'Submit', ' class="btn btn-primary",  style="padding-left:25px;padding-right:25px;"'); ?>
			                </div>
			            </div>
			        </div>

			    </div>
			</div>
			<?php echo form_close(); ?>

		</div>

	</div>
</div>


<script>
$(document).ready(function(){
 $('#mine_id').change(function(){
  var mine_id = $('#mine_id').val();
  if(mine_id != '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>index.php/pages/fetch_lower_lim",
    method:"POST",
    data:{mine_id:mine_id},
    success:function(data)
    {
     $('#LL').html(data);
     $('#UL').html('<option value="">Select Upper Limit</option>');
    }
   });
  }
  else
  {
   $('#LL').html('<option value="">Select Lower Limit</option>');
   $('#UL').html('<option value="">Select Upper Limit</option>');
  }
 });

 $('#LL').change(function(){
  var LL = $('#LL').val();
  if(LL != '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>index.php/pages/fetch_upper_lim",
    method:"POST",
    data:{LL:LL},
    success:function(data)
    {
     $('#UL').html(data);
    }
   });
  }
  else
  {
   $('#UL').html('<option value="">Select Upper Limit</option>');
  }
 });

});
</script>