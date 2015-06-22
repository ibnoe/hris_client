<!-- BEGIN PAGE CONTAINER-->
  <div class="page-content"> 
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="portlet-config" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button"></button>
        <h3>Widget Settings</h3>
      </div>
      <div class="modal-body"> Widget settings form goes here </div>
    </div>
    <div class="clearfix"></div>
    <div class="content">  
	    <div id="container">
	    	<div class="row">
        <div class="col-md-12">
          <div class="grid simple">
            <div class="grid-title no-border">
              <h4>Form Pengajuan <a href="<?php echo site_url('form_training_group')?>"><span class="semi-bold">Pelatihan Group</span></a></h4>
            </div>
            <div class="grid-body no-border">
              <form class="form-no-horizontal-spacing" id="formaddtraining" action="<?php echo site_url('form_training_group/add')?>"> 
                <div class="row column-seperation">
                  <div class="col-md-12">
                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Nama Pengaju</label>
                      </div>
                      <div class="col-md-10">
                          <?php 
                          if(is_admin()){?>
                            <select id="emp" class="select2" style="width:100%" name="emp" onChange="getDropDown()">
                              <?php
                              foreach ($all_users->result() as $u) :
                                $selected = $u->id == $sess_id ? 'selected = selected' : '';?>
                                <option value="<?php echo $u->id?>" <?php echo $selected?>><?php echo $u->username; ?></option>
                              <?php endforeach; ?>
                            </select>
                          <?php }else{?>
                            <input type="text"  class="form-control" placeholder="Nama Pengaju" value="<?php echo get_name($sess_id)?>" disabled="disabled">
                            <input type="hidden" name="emp" value="<?php echo $sess_id?>">
                        <?php }?>
                      </div>
                    </div>    
                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">NIK</label>
                      </div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $sess_nik?>" disabled="disabled">
                      </div>
                    </div>

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Jabatan</label>
                      </div>
                      <div class="col-md-10">
                        <input name="position" id="position" type="text"  class="form-control" placeholder="Jabatan" value="<?php echo get_user_position($sess_nik)?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Dept/Bagian</label>
                      </div>
                      <div class="col-md-10">
                        <input name="organization" id="organization" type="text"  class="form-control" placeholder="Dept/Bagian" value="<?php echo get_user_organization($sess_nik)?>" disabled="disabled">
                      </div>
                    </div>

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Nama Peserta Training</label>
                      </div>
                    <?php 
                    if(is_admin() || !is_admin()){?>
                      <div class="col-md-10">
                        <div id="peserta" >
                        </div>
                      </div>
                    <?php}else{?>
                      <div class="col-md-10">
                        <?php if($subordinate->num_rows() > 0){
                        foreach($subordinate->result() as $row):?>
                          <div class="col-md-3">
                            <div class="checkbox check-primary checkbox-circle" >
                              <input name="peserta[]" class="checkbox1" type="checkbox" id="peserta<?php echo $row->id ?>" value="<?php echo $row->id ?>">
                                <label for="peserta<?php echo $row->id ?>"><?php echo get_name($row->id)?></label>
                              </div>
                          </div>
                        <?php endforeach;} ?>
                      <?php } ?>
                      </div>
                    </div> 

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Nama Program Pelatihan</label>
                      </div>
                      <div class="col-md-10">
                        <input name="training_name" id="form3LastName" type="text"  class="form-control" placeholder="Nama program pelatihan" value="" required>
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right">Tujuan Pelatihan</label>
                      </div>
                      <div class="col-md-10">
                        <input name="tujuan_training" id="form3LastName" type="text"  class="form-control" placeholder="Tujuan pelatihan" value="" required>
                      </div>
                    </div>

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="bold form-label text-right"><?php echo 'Approval' ?></label>
                      </div>
                    </div>

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right"><?php echo 'Supervisor' ?></label>
                      </div>
                      <div class="col-md-10">
                      <?php if(is_admin()){
                        $style_up='class="select2" style="width:100%" id="atasan1"';
                            echo form_dropdown('atasan1',array('0'=>'- Pilih Supervisor -'),'',$style_up);
                        }else{?>
                        <select name="atasan1" id="atasan1" class="select2" style="width:100%">
                            <option value="0">- Pilih Supervisor -</option>
                            <?php foreach ($user_atasan as $key => $up) : ?>
                              <option value="<?php echo $up['ID'] ?>"><?php echo $up['NAME']; ?></option>
                            <?php endforeach;?>
                          </select>
                            <?php }?>
                      </div>
                    </div>

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right"><?php echo 'Ka. Bagian' ?></label>
                      </div>
                      <div class="col-md-10">
                      <?php if(is_admin()){
                        $style_up='class="select2" style="width:100%" id="atasan2"';
                            echo form_dropdown('atasan2',array('0'=>'- Pilih Ka. Bagian -'),'',$style_up);
                        }else{?>
                        <select name="atasan2" id="atasan2" class="select2" style="width:100%">
                            <option value="0">- Pilih Ka. Bagian -</option>
                            <?php foreach ($user_atasan as $key => $up) : ?>
                            <option value="<?php echo $up['ID'] ?>"><?php echo $up['NAME']; ?></option>
                            <?php endforeach;?>
                        </select>
                      <?php }?>
                      </div>
                    </div>

                    <div class="row form-row">
                      <div class="col-md-2">
                        <label class="form-label text-right"><?php echo 'Atasan Lainnya' ?></label>
                      </div>
                      <div class="col-md-10">
                      <?php if(is_admin()){
                        $style_up='class="select2" style="width:100%" id="atasan3"';
                            echo form_dropdown('atasan3',array('0'=>'- Pilih Atasan Lainnya -'),'',$style_up);
                        }else{?>
                        <select name="atasan3" id="atasan3" class="select2" style="width:100%">
                            <option value="0">- Pilih Atasan Lainnya -</option>
                            <?php foreach ($user_atasan as $key => $up) : ?>
                            <option value="<?php echo $up['ID'] ?>"><?php echo $up['NAME']; ?></option>
                            <?php endforeach;?>
                        </select>
                            <?php }?>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="form-actions">
                  <div class="pull-right">
                    <button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
                    <a href="<?php echo site_url('form_training_group')?>"><button class="btn btn-white btn-cons" type="button">Cancel</button></a>
                  </div>
                </div>
              </form>
               
            </div>
          </div>
        </div>
      </div>
	          	
		
      </div>
		
	</div>  
	<!-- END PAGE --> 

<script type="text/javascript">

  function getDropDown()
    {
      tampilSubordinate();
      getAtasan1();
      getAtasan2();
      getAtasan3();
    }

  function tampilSubordinate()
  {
     empid = document.getElementById("emp").value;
     $.ajax({
         url:"<?php echo base_url();?>form_training_group/get_subordinate/"+empid+"",
         success: function(response){
         $("#peserta").html(response);
         },
         dataType:"html"
     });
     return false;
  }

  function getAtasan1()
     {
         emp = document.getElementById("emp").value;
         $.ajax({
             url:"<?php echo base_url();?>form_training/get_atasan/"+emp+"",
             success: function(response){
             $("#atasan1").html(response);
             },
             dataType:"html"
         });
         return false;
     }

     function getAtasan2()
     {
         emp = document.getElementById("emp").value;
         $.ajax({
             url:"<?php echo base_url();?>form_training/get_atasan/"+emp+"",
             success: function(response){
             $("#atasan2").html(response);
             },
             dataType:"html"
         });
         return false;
     }

     function getAtasan3()
     {
         emp = document.getElementById("emp").value;
         $.ajax({
             url:"<?php echo base_url();?>form_training/get_atasan/"+emp+"",
             success: function(response){
             $("#atasan3").html(response);
             },
             dataType:"html"
         });
         return false;
     }
 </script>