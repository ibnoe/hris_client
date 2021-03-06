<form class="form-no-horizontal-spacing" id="formAppLv3"> 
                  <div class="row column-seperation">
                    <div class="col-md-5">
                      <h4>Informasi karyawan</h4>
                      <?php if ($_num_rows > 0) {
                      foreach ($form_cuti as $user) :
                      $cur_sess = date('Y');
                      // convert date time
                      $user_nik = get_nik($user->user_id);
                      $submission_date = dateIndo($user->created_on);
                      $date_start_cuti = dateIndo($user->date_mulai_cuti);
                      $date_end_cuti = dateIndo($user->date_selesai_cuti);

                     ?>
                       <div class="row form-row">
                      <div class="col-md-4">
                        <label class="form-label text-right">No</label>
                        
                      </div>
                      <div class="col-md-8">
                        <input name="no" id="no" type="text"  class="form-control" placeholder="No" value="<?php echo $user->id; ?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-4">
                        <label class="form-label text-right"><?php echo lang('start_working') ?></label>
                      </div>
                      <div class="col-md-8">
                        <input name="seniority_date" id="seniority_date" type="text"  class="form-control" placeholder="Lama Bekerja" value="<?php echo dateIndo(get_user_sen_date($user_nik)); ?>" disabled="disabled">
                      </div>
                    </div>          
                    <div class="row form-row">
                      <div class="col-md-4">
                        <label class="form-label text-right"><?php echo lang('name') ?></label>
                      </div>
                      <div class="col-md-8">
                        <input name="name" id="name" type="text"  class="form-control" placeholder="Nama" value="<?php echo get_name($user_nik); ?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-4">
                        <label class="form-label text-right"><?php echo lang('dept_div') ?></label>
                      </div>
                      <div class="col-md-8">
                        <input name="organization" id="organization" type="text"  class="form-control" placeholder="Organization" value="<?php echo get_user_organization($user_nik); ?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-4">
                        <label class="form-label text-right"><?php echo lang('position') ?></label>
                      </div>
                      <div class="col-md-8">
                        <input name="position" id="position" type="text"  class="form-control" placeholder="Jabatan" value="<?php echo get_user_position($user_nik); ?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-4">
                        <label class="form-label text-right"><?php echo lang('cuti_remain') ?></label>
                      </div>
                      <div class="col-md-8">
                        <input name="sisa_cuti" id="sisa_cuti" type="text"  class="form-control" placeholder="Sisa Cuti" value="<?php echo $sisa_cuti; ?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="row form-row">
                      <div class="col-md-4">
                        <label class="form-label text-right">Tanggal pengajuan</label>
                      </div>
                      <div class="col-md-8">
                        <input name="tgl_pengajuan" id="tgl_pengajuan" type="text"  class="form-control" placeholder="Tanggal Pengajuan" value="<?php echo $submission_date; ?>" disabled="disabled">
                      </div>
                    </div>  
                    </div>

                    <div class="col-md-7">
                      <h4>Cuti yang akan diambil</h4>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Tahun</label>
                        </div>
                        <div class="col-md-8">
                          <input name="tahuncuti" id="tahuncuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $user->session_year; ?>" disabled="disabled">
                        </div>
                      </div>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Tgl. mulai cuti</label>
                        </div>
                        <div class="col-md-3">
                          <input name="start_cuti" id="start_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $date_start_cuti; ?>" disabled="disabled">
                        </div>
                        <div class="col-md-1">
                          <label class="form-label text-center">s/d</label>
                        </div>
                        <div class="col-md-3">
                          <input name="end_cuti" id="end_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $date_end_cuti; ?>" disabled="disabled">
                        </div>
                      </div>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Jml. Hari</label>
                        </div>
                        <div class="col-md-2">
                          <input name="form3PostalCode" id="form3PostalCode" type="text"  class="form-control" placeholder="Jml. Hari" value="<?php echo $user->jumlah_hari; ?>" disabled="disabled">
                        </div>
                      </div>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Alasan</label>
                        </div>
                        <div class="col-md-8">
                          <input name="alasan" id="alasan" type="text"  class="form-control" placeholder="alasan" value="<?php echo $user->alasan_cuti?>" disabled>
                        </div>
                      </div>
                     <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right"><?php echo 'Remarks' ?></label>
                        </div>
                        <div class="col-md-8">
                          <input name="remarks" id="remarks" type="text"  class="form-control" placeholder="remarks" value="<?php echo $user->remarks?>" disabled>
                        </div>
                      </div>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Pengganti</label>
                        </div>
                        <div class="col-md-8">
                          <input name="pengganti_cuti" id="pengganti_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo get_name($user->user_pengganti) ?>" disabled="disabled">
                        </div>
                      </div>
                      
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right"><?php echo 'No. HP' ?></label>
                        </div>
                        <div class="col-md-8">
                          <input name="contact" id="contact" type="text"  class="form-control" placeholder="contact" value="<?php echo $user->contact?>" disabled>
                        </div>
                      </div>
                    
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Alamat selama cuti</label>
                        </div>
                        <div class="col-md-8">
                          <input name="alamat_cuti" id="alamat_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $user->alamat_cuti; ?>" disabled="disabled">
                        </div>
                      </div>
                      <?php if(!empty($user->approval_status_id_lv1)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Approval Status SPV</label>
                        </div>
                        <div class="col-md-8">
                          <input name="alamat_cuti" id="alamat_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $user->approval_status_lv1; ?>" disabled="disabled">
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($user->note_app_lv1)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Note (spv): </label>
                        </div>
                        <div class="col-md-8">
                          <textarea name="notes_spv" class="custom-txtarea-form" placeholder="Note supervisor isi disini" disabled="disabled"><?php echo $user->note_app_lv1 ?></textarea>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($user->approval_status_id_lv2)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Approval Status Ka. Bag</label>
                        </div>
                        <div class="col-md-8">
                          <input name="alamat_cuti" id="alamat_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $user->approval_status_lv2; ?>" disabled="disabled">
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($user->note_app_lv2)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Note (ka. bag): </label>
                        </div>
                        <div class="col-md-8">
                          <textarea name="notes_kbg" class="custom-txtarea-form" placeholder="Note ka. bagian isi disini" disabled="disabled"><?php echo $user->note_app_lv2 ?></textarea>
                        </div>
                      </div>
                      <?php } ?>

                      <input type="text" name="app_status" value="1" style="display:none" />

                      <?php if(!empty($user->approval_status_id_lv3)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Approval Status Atasan Lainnya</label>
                        </div>
                        <div class="col-md-8">
                          <input name="alamat_cuti" id="alamat_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $user->approval_status_lv3; ?>" disabled="disabled">
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($user->note_app_lv3)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Note (Atasan Lainnya): </label>
                        </div>
                        <div class="col-md-8">
                          <textarea name="notes_hrd" placeholder="Note hrd isi disini" class="custom-txtarea-form" disabled="disabled"><?php echo $user->note_app_lv3 ?></textarea>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($user->approval_status_id_hrd)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Approval Status HRD</label>
                        </div>
                        <div class="col-md-8">
                          <input name="alamat_cuti" id="alamat_cuti" type="text"  class="form-control" placeholder="Nama" value="<?php echo $user->approval_status_hrd; ?>" disabled="disabled">
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($user->note_app_hrd)){?>
                      <div class="row form-row">
                        <div class="col-md-4">
                          <label class="form-label text-right">Note (HRD): </label>
                        </div>
                        <div class="col-md-8">
                          <textarea name="notes_hrd" placeholder="Note hrd isi disini" class="custom-txtarea-form" disabled="disabled"><?php echo $user->note_app_hrd ?></textarea>
                        </div>
                      </div>
                      <?php } ?>


                    </div>
                  </div>
                </form>
                <?php endforeach; ?>
                <?php } ?>