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
              <h4>Detail Rekapitulasi <span class="semi-bold"><a href="<?php echo site_url('form_medical')?>">Rawat Jalan & Inap</a></span></h4>
            </div>
            <div class="grid-body no-border">
            <h6 class="bold">BAGIAN : <?php echo $bagian?></h6>
              <form class="form-no-horizontal-spacing" id="formMedical"> 
                <div class="row column-seperation">

                  <hr/>
                  <?php if(($creator_id == $sess_id || $user_id == $sess_id) && $app_status_id_lv1 != 1){?>
                    <div class="row form-row">
                      <div class="col-md-12">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submitMedicalModal"><i class="icon-edit"></i>&nbsp;Update Data Rekapitulasi</button>
                      </div>
                    </div><br/> 
                    <?php } ?>
                  <h5 class="text-center"><span class="semi-bold">Rekapitulasi Rawat Jalan & Inap Yang Diajukan</span></h5>
                    <table id="dataTable" class="table table-bordered">
		    	            <thead>
                        <tr>
                          <th width="5%">NIK</th>
                          <th width="25%">Nama</th>
                          <th width="25%">Nama Pasien</th>
                          <th width="15%">Hubungan</th>
                          <th width="13%">Jenis Pemeriksaan</th>
                          <th width="12%">Rupiah</th>
                        </tr>
                      </thead>
		                  <tbody>
      					        <?php 
        					        if(!empty($detail)){
                             $total = $detail[0]['rupiah'];
                             $approved = assets_url('img/approved_stamp.png');
                             $rejected = assets_url('img/rejected_stamp.png');
        					        	  for($i=0;$i<sizeof($detail);$i++):
                              ?>
      						        <tr>
      						        	<td><?php echo get_nik($detail[$i]['karyawan_id'])?></td>
      						        	<td><?php echo get_name($detail[$i]['karyawan_id'])?></td>
      						        	<td><?php echo $detail[$i]['pasien']?></td>
      						        	<td><?php echo $detail[$i]['hubungan']?></td>
      						        	<td><?php echo $detail[$i]['jenis']?></td>
      						        	<td><?php echo  'Rp. '.number_format($detail[$i]['rupiah'], 0)?></td>
      						        </tr>
                            <?php /*
                              if(sizeof($detail)>1){?>
                                <?php if($detail[$i]['karyawan_id'] != $detail[$i+1]['karyawan_id']){
                                    $sub_total = $detail[$i]['rupiah'] + $detail[$i+1]['rupiah']
                                  ?>
                                  <tr>
                                    <td align="right" colspan="5">Total <?php echo $detail[$i]['karyawan_id']?>: </td><td><?php echo $sub_total?></td>
                                  </tr>
                                  <?php } ?>
                            <?php };*/?>
        						        <?php
                            if(sizeof($detail)>1 && isset($detail[$i+1])){
                            $total = $total + $detail[$i+1]['rupiah'];
                            }
                            endfor;}
                            ?>
                            <tr>
                            <td align="right" colspan="5">Total : </td><td><?php echo 'Rp. '.number_format($total, 0)?></td>
                            </tr>
      					        </tbody>
		                  </table>

                      <?php if(!empty($note_lv1)):?>
                      <div class="row form-row">
                        <div class="col-md-12">
                          <label class="form-label text-left">Note (Supervisor) : </label>
                        </div>
                        <div class="col-md-12">
                          <textarea name="note_lv1" class="form-control" placeholder="" disabled="disabled"><?php echo $note_lv1?></textarea>
                        </div>
                      </div>
                    <?php endif; ?>

                  <?php if($is_app_hrd!=0){?>
                  <hr/>
                    <?php if($this->approval->approver('medical') == $sess_nik){?>
                    <div class="row form-row">
                      <div class="col-md-12">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submitMedicalModalHrd"><i class="icon-edit"></i>&nbsp;Update Data Rekapitulasi</button>
                      </div>
                    </div><br/> 
                    <?php } ?>
                  <h5 class="text-center"><span class="semi-bold">Rekapitulasi Rawat Jalan & Inap Yang Disetujui HRD</span></h5>
                    <table id="dataTable" class="table table-bordered">
                      <thead>
                        <tr>
                          <th width="5%">NIK</th>
                          <th width="25%">Nama</th>
                          <th width="25%">Nama Pasien</th>
                          <th width="15%">Hubungan</th>
                          <th width="13%">Jenis Pemeriksaan</th>
                          <th width="12%">Rupiah</th>
                          <th width="12%">Disetujui</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          if(!empty($detail_hrd)){
                             $total = $detail_hrd[0]['rupiah'];
                              for($i=0;$i<sizeof($detail_hrd);$i++):
                              $is_approve = ($detail_hrd[$i]['is_approve'] == 1) ? "<i class='icon-ok-sign' title = 'Ya'></i>":"<i class='icon-remove-sign' title = 'Tidak'></i>";
                              ?>
                          <tr>
                            <td><?php echo get_nik($detail_hrd[$i]['karyawan_id'])?></td>
                            <td><?php echo get_name($detail_hrd[$i]['karyawan_id'])?></td>
                            <td><?php echo $detail_hrd[$i]['pasien']?></td>
                            <td><?php echo $detail_hrd[$i]['hubungan']?></td>
                            <td><?php echo $detail_hrd[$i]['jenis']?></td>
                            <td><?php echo  'Rp. '.number_format($detail_hrd[$i]['rupiah'], 0)?></td>
                            <td align="center"><?php echo $is_approve?></td>
                          </tr>
                            <?php
                            endfor;}
                            ?>
                            <tr>
                            <td align="right" colspan="5">Total yang disetujui HRD: </td><td><?php echo 'Rp. '.number_format($total_medical_hrd, 0)?></td>
                            </tr>
                        </tbody>
                      </table>
                      <?php } ?>
                      <?php if(!empty($note_hrd)):?>
                      <div class="row form-row">
                        <div class="col-md-12">
                          <label class="form-label text-left">Note (HRD) : </label>
                        </div>
                        <div class="col-md-12">
                          <textarea name="note_hrd" class="form-control" placeholder="" disabled="disabled"><?php echo $note_hrd?></textarea>
                        </div>
                      </div>
                    <?php endif; ?>
                      <div class="col-md-12">
                        <label class="form-label text-left">Attachment : </label>
                      </div>
                      <?php for($i=0;$i<sizeof($attachment);$i++):
                            if(file_exists('./uploads/'.$user_folder.$attachment[$i])){
                      ?>
                      <div class="col-md-12">
                        <label class="form-label text-left"><a href="<?php echo site_url('uploads/'.$user_folder.$attachment[$i])?>"><?php echo '* '.$attachment[$i]?></a></label>
                      </div>
                    <?php }endfor; ?>
                    </div>
                  </div>
                </div>
                <?php if($_num_rows>0){
                  foreach($form_medical as $row):?>
                <div class="form-actions text-center">

                <div class="row form-row">
                    <div class="col-md-12 text-center">
                      <?php  if($row->is_app_lv1 == 1 && get_nik($sess_id) == $row->user_app_lv1){?>
                        <div class='btn btn-info btn-small text-center' title='Edit Approval' data-toggle="modal" data-target="#submitMedicalModalLv1"><i class='icon-edit'> Edit Approval</i></div>
                      <?php } ?>
                    </div>
                </div>

                    <!-- <div class="col-md-12 text-center"> -->
                      <div class="row wf-spd">
                        <div class="col-md-4">
                          <p>Hormat Kami,</p>
                          <p class="wf-submit">
                          <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="semi-bold"><?php echo get_name($row->user_id) ?></span><br/>
                            <span class="semi-bold"><?php echo (!empty(get_user_position(get_nik($row->user_id)))) ? get_user_position(get_nik($row->user_id)) : ''?></span><br/>
                            <span class="small"><?php echo dateIndo($row->created_on) ?></span><br/>
                          </p>
                        </div>

                        <div class="col-md-4">
                          <p>Disetujui,</p>
                          <p class="wf-approve-sp">
                          <?php if($row->is_app_hrd==1) {
                            echo "<img class=approval_img src=$approved>"?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="semi-bold"><?php echo get_name($row->user_app_hrd) ?></span><br/>
                            <span class="semi-bold"></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_hrd) ?></span><br/>
                            <?php }elseif($this->approval->approver('medical') == $sess_nik && $row->is_app_hrd==0){?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <button type="button" id="" class="btn btn-success btn-cons" data-toggle="modal" data-target="#submitMedicalModalHrd"><i class="icon-ok"></i>Submit</button>
                            <p class="">(HRD)</p>
                            <?php }else{?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="small"></span><br/>
                            <p class="">(HRD)</p>
                            <?php } ?>
                          </p>
                        </div>

                        <?php if(!empty($row->user_app_lv1)){?>
                        <div class="col-md-4">
                          <p>Mengetahui,</p>
                          <p class="wf-approve-sp">
                          <?php if($row->is_app_lv1==1) {
                            echo ($row->app_status_id_lv1 == 1)?"<img class=approval_img src=$approved>":(($row->app_status_id_lv1 == 2) ? "<img class=approval_img src=$rejected>":'<span class="small"></span><br/>');?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="semi-bold"><?php echo get_name($row->user_app_lv1) ?></span><br/>
                            <span class="semi-bold"><?php echo (!empty($row->user_app_lv1)) ? get_user_position($row->user_app_lv1) : ''?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_lv1) ?></span><br/>
                            <?php }elseif($row->is_app_lv1==0 && $sess_nik == $row->user_app_lv1){?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <button type="button" data-toggle="modal" data-target="#submitMedicalModalLv1" class="btn btn-success btn-cons"><i class="icon-ok"></i>Submit</button>
                            <p class="">...............................</p>
                            <?php }else{?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="small"></span><br/>
                            <p class="">...............................</p>
                            <?php } ?>
                          </p>
                        </div>
                        <?php } ?>
                      </div>
                    <!-- /div> -->
                    <?php if(!empty($row->user_app_lv2)){?>
                        <div class="col-md-7">
                          <p>Mengetahui,</p>
                          <p class="wf-approve-sp">
                          <?php if($row->is_app_lv2==1) {
                            echo "<img class=approval-img-sm src=$approved>"?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="semi-bold"><?php echo get_name($row->user_app_lv2) ?></span><br/>
                            <span class="semi-bold"><?php echo (!empty($row->user_app_lv2)) ? get_user_position($row->user_app_lv2) : ''?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_lv2) ?></span><br/>
                            <?php }elseif($row->is_app_lv2==0 && $sess_nik == $row->user_app_lv2){?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <button id="btn_app_lv2" class="btn btn-success btn-cons" data-loading-text="Loading..."><i class="icon-ok"></i>Submit</button>
                            <p class="">...............................</p>
                            <?php }else{?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="small"></span><br/>
                            <p class="">...............................</p>
                            <?php } ?>
                          </p>
                        </div>
                        <?php } ?>

                        <?php if(!empty($row->user_app_lv3)){?>
                        <div class="col-md-2">
                          <p>Mengetahui,</p>
                          <p class="wf-approve-sp">
                          <?php if($row->is_app_lv3==1) {
                            echo "<img class=approval-img-sm src=$approved>"?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="semi-bold"><?php echo get_name($row->user_app_lv3) ?></span><br/>
                            <span class="semi-bold"><?php echo (!empty($row->user_app_lv3)) ? get_user_position($row->user_app_lv3) : ''?></span><br/>
                            <span class="small"><?php echo dateIndo($row->date_app_lv3) ?></span><br/>
                            <?php }elseif($row->is_app_lv3==0 && $sess_nik == $row->user_app_lv3){?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <button id="btn_app_lv3" class="btn btn-success btn-cons" data-loading-text="Loading..."><i class="icon-ok"></i>Submit</button>
                            <p class="">...............................</p>
                            <?php }else{?>
                            <span class="semi-bold"></span><br/>
                            <span class="small"></span><br/>
                            <span class="small"></span><br/>
                            <p class="">...............................</p>
                            <?php } ?>
                          </p>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach;}?>
              </form>
             </div>  
            </div>
          </div>
        </div>
      </div>
	          	
		
      </div>
		
	</div>  
	<!-- END PAGE -->

  <!--approval medical Modal Lv1 -->
<div class="modal fade" id="submitMedicalModalLv1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" id="modaldialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Approval Form medical - Supervisor</h4>
      </div>
      <p class="error_msg" id="MsgBad" style="background: #fff; display: none;"></p>
      <div class="modal-body">
        <form class="form-no-horizontal-spacing"  id="formAppLv1">
            <div class="row form-row">
              <div class="col-md-12">
                <label class="form-label text-left">Status Approval </label>
              </div>
              <div class="col-md-12">
                <div class="radio">
                  <?php 
                  if($approval_status->num_rows() > 0){
                    foreach($approval_status->result() as $app){
                      $checked = ($app->id <> 0 && $app->id == $row->app_status_id_lv1) ? 'checked = "checked"' : '';
                      ?>
                  <input id="app_status_lv1<?php echo $app->id?>" type="radio" name="app_status_id_lv1" value="<?php echo $app->id?>" <?php echo $checked?>>
                  <label for="app_status_lv1<?php echo $app->id?>"><?php echo $app->title?></label>
                  <?php }}else{?>
                  <input id="app_status" type="radio" name="app_status_id_lv1" value="0">
                  <label for="app_status">No Data</label>
                    <?php } ?>
                </div>
              </div>
            </div>
            <div class="row form-row">
              <div class="col-md-12">
                <label class="form-label text-left">Note (Supervisor) : </label>
              </div>
              <div class="col-md-12">
                <textarea name="note_lv1" class="custom-txtarea-form" placeholder="Note Supervisor isi disini"><?php echo $row->note_lv1?></textarea>
              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove"></i>&nbsp;<?php echo lang('close_button')?></button> 
        <button id="btn_app_lv1"  class="btn btn-success btn-cons" data-loading-text="Loading..."><i class="icon-ok-sign"></i>&nbsp;<?php echo lang('save_button')?></button>
      </div>
        <?php echo form_close()?>
    </div>
  </div>
</div>
<!--end approve modal lv1--> 


<!-- edit admin Medical -->
<div class="modal fade" id="submitMedicalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" id="modaldialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Form Rekapitulasi Medical</h4>
      </div>
      <div class="modal-body">
        <form class="form-no-horizontal-spacing" id="formEdit">
         <div class="row">
         <div class="col-md-12">
            <table id="dataTable" class="table table-bordered">
              <thead>
                <tr>
                  <th width="4%">NIK</th>
                  <th width="20%">Nama</th>
                  <th width="20%">Nama Pasien</th>
                  <th width="15%">Hubungan</th>
                  <th width="15%" class="text-center">Jenis Pemeriksaan</th>
                  <th width="20%">Rupiah</th>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if(!empty($detail)){
                     $total = $detail[0]['rupiah'];
                     $approved = assets_url('img/approved_stamp.png');
                     $rejected = assets_url('img/rejected_stamp.png');
                      for($i=0;$i<sizeof($detail);$i++):
                      ?>
                  <tr>
                    <input type="hidden" name="detail_id[]" value="<?php echo $detail[$i]['id']?>">
                    <td><?php echo get_nik($detail[$i]['karyawan_id'])?></td>
                    <td><?php echo get_name($detail[$i]['karyawan_id'])?></td>
                    <td><?php echo $detail[$i]['pasien']?></td>
                    <td><?php echo $detail[$i]['hubungan']?></td>
                    <td><?php echo $detail[$i]['jenis']?></td>
                    <td>
                      <div id="rupiah<?php echo $i?>"><?php echo  'Rp. '.number_format($detail[$i]['rupiah'], 0).' '?>
                        <button type="button" id="edit<?php echo $i?>" class='btn btn-info btn-small text-right' title='Edit' onclick="edit<?php echo get_nik($detail[$i]['karyawan_id']).$i?>()"><i class='icon-edit'></i></button>
                      </div>
                      <input name="rupiah_update[]" type="text" id="rupiah_update<?php echo $i?>" value="<?php echo $detail[$i]['rupiah']?>" style="display:none"> 
                    </td>
                  </tr>
                    <?php /*
                      if(sizeof($detail)>1){?>
                        <?php if($detail[$i]['karyawan_id'] != $detail[$i+1]['karyawan_id']){
                            $sub_total = $detail[$i]['rupiah'] + $detail[$i+1]['rupiah']
                          ?>
                          <tr>
                            <td align="right" colspan="5">Total <?php echo $detail[$i]['karyawan_id']?>: </td><td><?php echo $sub_total?></td>
                          </tr>
                          <?php } ?>
                    <?php };*/?>
                    <?php
                    if(sizeof($detail)>1 && isset($detail[$i+1])){
                    $total = $total + $detail[$i+1]['rupiah'];
                    }
                    endfor;}
                    ?>
                    <tr>
                    <td align="right" colspan="5">Total : </td><td><?php echo 'Rp. '.number_format($total, 0)?></td>
                    </tr>
                </tbody>
              </table>
              </div>
          </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove"></i>&nbsp;<?php echo lang('close_button')?></button> 
        <button id="btn_edit" class="btn btn-success btn-cons" data-loading-text="Loading..."><i class="icon-ok-sign"></i>&nbsp;<?php echo lang('save_button')?></button>
      </div>
        <?php echo form_close()?>
    </div>
  </div>
</div>
<!--end modal--> 


<!-- Submit HRD Medical -->
<div class="modal fade" id="submitMedicalModalHrd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" id="modaldialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Approval Form Rekapitulasi Medical</h4>
      </div>
      <div class="modal-body">
        <form class="form-no-horizontal-spacing" id="formAppHrd">
         <div class="row">
         <div class="col-md-12">
            <table id="dataTable" class="table table-bordered">
              <thead>
                <tr>
                  <th width="4%">NIK</th>
                  <th width="20%">Nama</th>
                  <th width="20%">Nama Pasien</th>
                  <th width="15%">Hubungan</th>
                  <th width="15%" class="text-center">Jenis Pemeriksaan</th>
                  <th width="20%">Rupiah</th>
                  <th class="text-center"><div>Disetujui</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if(!empty($detail)){
                     $total = $detail[0]['rupiah'];
                     $approved = assets_url('img/approved_stamp.png');
                     $rejected = assets_url('img/rejected_stamp.png');
                      for($i=0;$i<sizeof($detail);$i++):
                      ?>
                  <tr>
                    <input type="hidden" name="detail_id[]" value="<?php echo $detail[$i]['id']?>">
                    <td><?php echo get_nik($detail[$i]['karyawan_id'])?></td>
                    <td><?php echo get_name($detail[$i]['karyawan_id'])?></td>
                    <td><?php echo $detail[$i]['pasien']?></td>
                    <td><?php echo $detail[$i]['hubungan']?></td>
                    <td><?php echo $detail[$i]['jenis']?></td>
                    <td>
                      <div id="rupiah_hrd<?php echo $i?>"><?php echo  'Rp. '.number_format($detail[$i]['rupiah'], 0).' '?>
                        <button type="button" id="edit_hrd<?php echo $i?>" class='btn btn-info btn-small text-right' title='Edit' onclick="edit_hrd<?php echo get_nik($detail[$i]['karyawan_id']).$i?>()"><i class='icon-edit'></i></button>
                      </div>
                      <input name="rupiah_update[]" type="text" id="rupiah_hrd_update<?php echo $i?>" value="<?php echo $detail[$i]['rupiah']?>" style="display:none"> 
                    </td>
                    <td class="text-center" valign="middle" class="small-cell">
                      <input type="checkbox" name="checkbox1_checkbox[]" id="checkbox1_checkbox" class="checkbox1" />
                      <input type="hidden" name="checkbox1[]" value="0" />
                    </td>
                  </tr>
                    <?php /*
                      if(sizeof($detail)>1){?>
                        <?php if($detail[$i]['karyawan_id'] != $detail[$i+1]['karyawan_id']){
                            $sub_total = $detail[$i]['rupiah'] + $detail[$i+1]['rupiah']
                          ?>
                          <tr>
                            <td align="right" colspan="5">Total <?php echo $detail[$i]['karyawan_id']?>: </td><td><?php echo $sub_total?></td>
                          </tr>
                          <?php } ?>
                    <?php };*/?>
                    <?php
                    if(sizeof($detail)>1 && isset($detail[$i+1])){
                    $total = $total + $detail[$i+1]['rupiah'];
                    }
                    endfor;}
                    ?>
                    <tr>
                    <td align="right" colspan="5">Total : </td><td><?php echo 'Rp. '.number_format($total, 0)?></td>
                    </tr>
                </tbody>
              </table>

            <div class="row form-row">
              <div class="col-md-12">
                <label class="form-label text-left">Note (HRD) : </label>
              </div>
              <div class="col-md-12">
                <textarea name="note_hrd" class="custom-txtarea-form" placeholder="Note HRD isi disini"><?php echo $row->note_hrd?></textarea>
              </div>
            </div>

              </div>
          </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove"></i>&nbsp;<?php echo lang('close_button')?></button> 
        <button id="btn_app_hrd" class="btn btn-success btn-cons" data-loading-text="Loading..."><i class="icon-ok-sign"></i>&nbsp;<?php echo lang('save_button')?></button>
      </div>
        <?php echo form_close()?>
    </div>
  </div>
</div>
<!--end modal--> 
<script type="text/javascript">
<?php for($i=0;$i<sizeof($detail);$i++): ?>
  function edit<?php echo get_nik($detail[$i]['karyawan_id']).$i?>(){
      $("#rupiah<?php echo $i?>").hide();
      $('#rupiah_update<?php echo $i?>').show();
    }

    function edit_hrd<?php echo get_nik($detail[$i]['karyawan_id']).$i?>(){
      $("#rupiah_hrd<?php echo $i?>").hide();
      $('#rupiah_hrd_update<?php echo $i?>').show();
    }
  <?php endfor; ?>
</script>