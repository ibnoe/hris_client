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
              <div class="grid simple ">
                <div class="grid-title no-border">
                  <h4><?php echo lang('list_of_submission'); ?> <span class="semi-bold"><?php echo lang('form_cuti_subheading'); ?></span></h4>
                  <div class="tools"> 
                    <a href="<?php echo site_url('form_cuti/input'); ?>" class="config"></a>
                  </div>
                  <div class="grid-body no-border">
                          <table class="table table-striped table-flip-scroll cf">
                              <thead>
                                <tr>
                                  <th width="20%"><?php echo 'Nama Pengaju' ?></th>
                                  <th width="15%"><?php echo lang('date') ?></th>
                                  <th width="20%"><?php echo lang('reason') ?></th>
                                  <th width="10%"><?php echo lang('count_cuti') ?></th>
                                  <th width="10%" style="text-align:center;">appr. spv</th>
                                  <th width="10%" style="text-align:center;">appr. ka. bag</th>
                                  <th width="10%" style="text-align:center;">appr. HRD</th>
                                  <th width="10%" style="align:center;">cetak</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if ($_num_rows > 0) {
                                  foreach ($form_cuti as $user) :
                                  $id_cuti = $user->id;
                                  $session_id = get_nik($this->session->userdata('user_id'));
                                  $id_user = $this->session->userdata('user_id');
                                  $txt_app_lv1 = $txt_app_lv2 = $txt_app_lv3 = "-";
                                  
                                  // approval cuti
                                  //Approval Level 1
                                  
                                  if(!empty(is_have_subordinate($session_id)))
                                  {
                                    if(cek_subordinate(is_have_subordinate($session_id),'id', $user->user_id)){
                                          if($user->is_app_lv1 == 0){
                                              $txt_app_lv1 = "<a href='".site_url('form_cuti/approval_spv/'.$user->id)."''>
                                                  <button type='button' class='btn btn-info btn-small' title='Make Approval'><i class='icon-paste'></i></button>
                                              </a>";
                                          }else{
                                            $txt_app_lv1 =  "<a href='".site_url('form_cuti/approval_spv/'.$user->id)."''>$user->approval_status_lv1</a>";
                                            
                                          }
                                      }elseif($user->is_app_lv1== 1){
                                        $txt_app_lv1 =  "<a href='".site_url('form_cuti/approval_spv/'.$user->id)."''>$user->approval_status_lv1</a>";
                                      }elseif($user->is_app_lv1== 0){
                                         $txt_app_lv1 = '-';
                                      }
                                  }else{
                                    if ($user->is_app_lv1== 1){
                                    $txt_app_lv1 =  "<a href='".site_url('form_cuti/approval_spv/'.$user->id)."''>$user->approval_status_lv1</a>";
                                    }
                                  }

                                  //ApprovalLevel 2
                                  
                                  if(!empty(is_have_subsubordinate($id_user)))
                                  {
                                    if(cek_subordinate(is_have_subsubordinate($id_user),'id', $user->user_id)){
                                          if($user->is_app_lv2 == 0){
                                              $txt_app_lv2 = "<a href='".site_url('form_cuti/approval_kbg/'.$user->id)."''>
                                                  <button type='button' class='btn btn-info btn-small' title='Make Approval'><i class='icon-paste'></i></button>
                                              </a>";
                                          }else{
                                            $txt_app_lv2 =  "<a href='".site_url('form_cuti/approval_kbg/'.$user->id)."''>$user->approval_status_lv2</a>";
                                            
                                          }
                                     }else{
                                     
                                     }
                                  }else{
                                    if ($user->is_app_lv2== 1){
                                    $txt_app_lv2 =  "<a href='".site_url('form_cuti/approval_kbg/'.$user->id)."''>$user->approval_status_lv2</a>";
                                    }
                                  }

                                  //Approval Level 3
                                    if(is_admin()){
                                          if($user->is_app_lv3 == 0){
                                              $txt_app_lv3 = "<a href='".site_url('form_cuti/approval_hrd/'.$user->id)."''>
                                                  <button type='button' class='btn btn-info btn-small' title='Make Approval'><i class='icon-paste'></i></button>
                                              </a>";
                                          }else{
                                            $txt_app_lv3 =  "<a href='".site_url('form_cuti/approval_hrd/'.$user->id)."''>$user->approval_status_lv3</a>";
                                            
                                          }
                                      }elseif($user->is_app_lv3== 1){
                                        $txt_app_lv3 =  "<a href='".site_url('form_cuti/approval_hrd/'.$user->id)."''>$user->approval_status_lv3</a>";
                                      }


                                  // date cuti
                                  $date_now = date('Y-m-d');

                                  $datetime1 = new DateTime($date_now);
                                  $datetime2 = new DateTime($user->date_selesai_cuti);
                                  $interval = $datetime1->diff($datetime2);
                                  $sisa_cuti = $interval->format('%a');
                                  if ($datetime2 <= $datetime1) {
                                    $sisa_cuti = 0;
                                  }
                                  
                                  // user pengganti name
                                  $user_pengganti = $user->name;
                                  ?>
                                  <tr class="itemcuti" id="<?php echo $id_cuti; ?>">
                                  <td>
                                      <a href="#" id="viewcuti-<?php echo $id_cuti; ?>"><?php echo $user->name; ?></a>
                                    </td>
                                    <td>
                                      <?php echo date('d-m-Y',strtotime($user->date_mulai_cuti)); ?>
                                    </td>
                                    <td>
                                      <?php echo $user->alasan_cuti; ?>
                                    </td>
                                    
                                    <td>
                                      <?php echo $user->jumlah_hari; ?> hari
                                    </td>
                                    <td style="text-align:center;">
                                      <?php echo $txt_app_lv1;?>
                                    </td>
                                    <td style="text-align:center;">
                                      <?php echo $txt_app_lv2; ?>
                                    </td>
                                    <td style="text-align:center;">
                                      <?php echo $txt_app_lv3; ?>
                                    </td>
                                    <td class="text-center">
                                    <?php if($user->is_app_lv1 == 1 && $user->is_app_lv2 == 1 && $user->is_app_lv3 == 1){?>
                                            <a href="<?php echo site_url('form_cuti/form_cuti_pdf/'.$user->id)?>"><i class="icon-print"></i></a>
                                          <?php }else{ ?>
                                            <i class="icon-print"></i>
                                          <?php } ?>
                                    </td>
                                  </tr>
                                  <tr id="cutidetail-<?php echo $id_cuti; ?>" style="display:none">
                                    <td class="detail" colspan="6">
                                      <div class="row">
                                        <form action="#" method="enctype">
                                          <div class="col-md-12">
                                            <h4>ID : #<?php echo $id_cuti; ?></h4>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('count_cuti') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="courseid" id="courseid" type="text"  class="form-control" placeholder="courseid" value="<?php echo $user->jumlah_hari; ?>" disabled="disabled">
                                              </div>
                                            </div>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('year') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="description" id="description" type="text"  class="form-control" placeholder="Description" value="<?php echo $user->comp_session; ?>" disabled="disabled">
                                              </div>
                                            </div>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('start_cuti') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="registration_date" id="registration_date" type="text"  class="form-control" placeholder="Registration Date" value="<?php echo date('d-m-Y',strtotime($user->date_mulai_cuti)); ?>" disabled="disabled">
                                              </div>
                                            </div>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('end_cuti') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="status" id="status" type="text"  class="form-control" placeholder="Status" value="<?php echo date('d-m-Y',strtotime($user->date_selesai_cuti)); ?>" disabled="disabled">
                                              </div>
                                            </div>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('count_day') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="status" id="status" type="text"  class="form-control" placeholder="Status" value="<?php echo $user->jumlah_hari; ?> hari" disabled="disabled">
                                              </div>
                                            </div>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('reason') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="status" id="status" type="text"  class="form-control" placeholder="Status" value="<?php echo $user->alasan_cuti; ?>" disabled="disabled">
                                              </div>
                                            </div>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('replacement') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="status" id="status" type="text"  class="form-control" placeholder="Status" value="<?php echo get_pengganti($user->id); ?>" disabled="disabled">
                                              </div>
                                            </div>
                                            <div class="row form-row">
                                              <div class="col-md-2">
                                                <label class="form-label text-right"><?php echo lang('addr_cuti') ?></label>
                                              </div>
                                              <div class="col-md-10">
                                                <input name="status" id="status" type="text"  class="form-control" placeholder="Status" value="<?php echo $user->alamat_cuti; ?>" disabled="disabled">
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                    </div>
                                  </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php } ?> 
                              </tbody>
                          </table>
                  </div>
              </div>
          </div>
        </div>
      </div>
	          	
		
      </div>
		
	</div>  
	<!-- END PAGE -->