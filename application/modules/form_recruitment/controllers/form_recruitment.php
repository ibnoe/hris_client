<?php defined('BASEPATH') OR recruitment('No direct script access allowed');

class Form_recruitment extends MX_Controller {

  public $data;

    function __construct()
    {
        parent::__construct();
        $this->load->library('authentication', NULL, 'ion_auth');
        $this->load->library('form_validation');
        $this->load->library('approval');
        $this->load->helper('url');
        
        $this->load->database();
        $this->load->model('recruitment_model');
    
        $this->lang->load('auth');
        $this->load->helper('language');

        
    }

    function index($ftitle = "fn:",$sort_by = "users_recruitment.id", $sort_order = "asc", $offset = 0)
    {
        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->data['sess_id'] = $sess_id = $this->session->userdata('user_id');
        $this->data['sess_nik'] = get_nik($sess_id);
        //$admin = cek_subordinate(is_have_subordinate($this->data['session_id']),'id', 30);print_mz(lq());
        //set sort order
        $this->data['sort_order'] = $sort_order;
        
        //set sort by
        $this->data['sort_by'] = $sort_by;
       
        //set filter by title
        $this->data['ftitle_param'] = $ftitle; 
        $exp_ftitle = explode(":",$ftitle);
        $ftitle_re = str_replace("_", " ", $exp_ftitle[1]);
        $ftitle_post = (strlen($ftitle_re) > 0) ? array('users.username'=>$ftitle_re) : array() ;
        
        //set default limit in var $config['list_limit'] at application/config/ion_auth.php 
        $this->data['limit'] = $limit = (strlen($this->input->post('limit')) > 0) ? $this->input->post('limit') : 10 ;

        $this->data['offset'] = 6;

        //list of filterize all recruitment  
        $this->data['recruitment_all'] = $this->recruitment_model->like($ftitle_post)->where('is_deleted',0)->recruitment()->result();
        
        $this->data['num_rows_all'] = $this->recruitment_model->like($ftitle_post)->where('is_deleted',0)->recruitment()->num_rows();
        
        $this->data['recruitment'] = $this->recruitment_model->like($ftitle_post)->where('is_deleted',0)->limit($limit)->offset($offset)->order_by($sort_by, $sort_order)->recruitment()->result();

        //list of filterize limit recruitment for pagination  d();
        $this->data['_num_rows'] = $this->recruitment_model->like($ftitle_post)->where('is_deleted',0)->limit($limit)->offset($offset)->order_by($sort_by, $sort_order)->recruitment()->num_rows();

         //config pagination
         $config['base_url'] = base_url().'recruitment/index/fn:'.$exp_ftitle[1].'/'.$sort_by.'/'.$sort_order.'/';
         $config['total_rows'] = $this->data['num_rows_all'];
         $config['per_page'] = $limit;
         $config['uri_segment'] = 6;

        //inisialisasi config
         $this->pagination->initialize($config);

        //create pagination
        $this->data['halaman'] = $this->pagination->create_links();

        $this->data['ftitle_search'] = array(
            'name'  => 'title',
            'id'    => 'title',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('title'),
        );
        
        $this->_render_page('form_recruitment/index');
    }

    function keywords(){
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            $ftitle_post = (strlen($this->input->post('title')) > 0) ? strtolower(url_title($this->input->post('title'),'_')) : "" ;

            redirect('form_recruitment/index/fn:'.$ftitle_post, 'refresh');
        }
    }

    function input()
    {
        $sess_id = $this->session->userdata('user_id');
        $nik = get_nik($sess_id);
        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }elseif(!is_spv($nik)&&!is_admin()&&!is_admin_bagian()){
            return show_error('You must be an administrator to view this page.');
        }else{
        $this->data['jurusan'] = getAll('recruitment_jurusan', array('is_deleted' => 'where/0'));
        $this->data['ipk'] = getAll('ipk', array('is_deleted' => 'where/0'));
        $this->data['toefl'] = getAll('toefl', array('is_deleted' => 'where/0'));
        $this->data['status'] = getAll('recruitment_status', array('is_deleted' => 'where/0'));
        $this->data['urgensi'] = getAll('recruitment_urgensi', array('is_deleted' => 'where/0'));
        $this->data['jenis_kelamin'] = getAll('jenis_kelamin', array('is_deleted' => 'where/0'));
        $this->data['pendidikan'] = getAll('recruitment_pendidikan', array('is_deleted' => 'where/0'));
        $this->data['komputer'] = getAll('recruitment_komputer', array('is_deleted' => 'where/0'));
        $this->data['brevet'] = getAll('recruitment_brevet', array('is_deleted' => 'where/0'));
        $this->data['sess_id'] = $this->session->userdata('user_id');
        $this->data['all_users'] = getAll('users', array('active'=>'where/1', 'username'=>'order/asc'), array('!=id'=>'1'));
        $this->get_bu();
        $this->get_user_atasan();

        $this->_render_page('form_recruitment/input', $this->data);
        }
    }

    function add()
    {
       if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        
            /*$this->form_validation->set_rules('bu', 'Unit Bisnis', 'trim|required');
            $this->form_validation->set_rules('parent_org', 'Departement', 'trim|required');
            $this->form_validation->set_rules('org', 'Bagian', 'trim|required');
            $this->form_validation->set_rules('pos', 'Posisi', 'trim|required');
            */
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
            //$this->form_validation->set_rules('urgensi', 'Kebutuhan / Urgensi', 'trim|required');
            //$this->form_validation->set_rules('jnskelamin', 'Jenis Kelamin', 'trim|required');
            //$this->form_validation->set_rules('pendidikan', 'Pendidikan', 'trim|required');
            //$this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required');
            //$this->form_validation->set_rules('ipk', 'IPK', 'trim|required');
            /*$this->form_validation->set_rules('toefl', 'TOEFL', 'trim');
            $this->form_validation->set_rules('komputer', 'Komputer', 'trim');
            $this->form_validation->set_rules('komunikasi', 'Koumikasi', 'trim');
            $this->form_validation->set_rules('grafika', 'Grafika', 'trim');
            $this->form_validation->set_rules('desain', 'Desain', 'trim');
            $this->form_validation->set_rules('brevet', 'Brevet', 'trim');
            $this->form_validation->set_rules('lain_lain', 'Lain-Lain', 'trim');
            $this->form_validation->set_rules('portofolio', 'Portofolio', 'trim');
            $this->form_validation->set_rules('pengalaman', 'pengalaman', 'trim');
            $this->form_validation->set_rules('lama_pengalaman', 'lama_pengalaman', 'trim');
            $this->form_validation->set_rules('job_desc', 'Job Desc', 'trim');
            */
            if($this->form_validation->run() == FALSE)
            {
                //echo json_encode(array('st'=>0, 'errors'=>validation_errors('<div class="alert alert-danger" role="alert">', '</div>')));
                redirect('form_recruitment/input', 'refresh');
            }
            else
            {
                $num_rows = getAll('users_recruitment')->num_rows();

                if($num_rows>0){
                    $recruitment_id = $this->db->select('id')->order_by('id', 'asc')->get('users_recruitment')->last_row();
                    $recruitment_id = $recruitment_id->id+1;
                }else{
                    $recruitment_id = 1;
                }
                
                $user_id = $this->session->userdata('user_id');
                $data1 = array(
                    'id_comp_session' => 1,
                    'user_id'       => $user_id,
                    'bu_id'       => $this->input->post('bu'),
                    'parent_organization_id'       => $this->input->post('parent_org'),
                    'organization_id'     => $this->input->post('org'),
                    'position_id'           => $this->input->post('pos'),
                    'jumlah'           => $this->input->post('jumlah'),
                    'status_id'           => $this->input->post('status'),
                    'urgensi_id'           => $this->input->post('urgensi'),
                    'user_kualifikasi_id'           => $recruitment_id,
                    'user_kemampuan_id'           => $recruitment_id,
                    'user_app_lv1'          => $this->input->post('atasan1'),
                    'user_app_lv2'          => $this->input->post('atasan2'),
                    'user_app_lv3'          => $this->input->post('atasan3'),
                    'created_on'            => date('Y-m-d',strtotime('now')),
                    'created_by'            => $this->session->userdata('user_id')
                );
                
                $data2 = array(
                    'jenis_kelamin_id' => implode(',',$this->input->post('jenis_kelamin')),
                    'pendidikan_id' => implode(',',$this->input->post('pendidikan')),
                    'jurusan' => $this->input->post('jurusan'),
                    'ipk' => $this->input->post('ipk'),
                    'toefl' => $this->input->post('toefl'),
                    'user_recruitment_id' => $recruitment_id,
                    'created_on'            => date('Y-m-d',strtotime('now')),
                    'created_by'            => $this->session->userdata('user_id')
                );

                $data3 = array(
                        'user_recruitment_id' => $recruitment_id,
                        'komputer' => implode(',',$this->input->post('komputer')),
                        'bahasa_pemrograman' => $this->input->post('pemrograman'),
                        'komunikasi' => $this->input->post('komunikasi'),
                        'grafika' => $this->input->post('grafika'),
                        'desain' => $this->input->post('desain'),
                        'brevet_id' => $this->input->post('brevet'),
                        'lain_lain' => $this->input->post('lain-lain'),
                        'portofolio' => $this->input->post('portofolio'),
                        'pengalaman' => $this->input->post('pengalaman'),
                        'lama_Pengalaman' => $this->input->post('lama_pengalaman'),
                        'job_desc' => $this->input->post('job_desc'),
                        'note_pengaju' => $this->input->post('note_pengaju'),
                        'created_on'            => date('Y-m-d',strtotime('now')),
                        'created_by'            => $this->session->userdata('user_id')
                    );

                $this->recruitment_model->create_($data1, $data2, $data3);
                
                     $recruitment_id = $this->db->insert_id();
                     $user_app_lv1 = getValue('user_app_lv1', 'users_recruitment', array('id'=>'where/'.$recruitment_id));
                     $isi_email = get_name($user_id).' mengajukan Permohonan recruitment, untuk melihat detail silakan <a href='.base_url().'form_recruitment/detail/'.$recruitment_id.'>Klik Disini</a><br />';

                     if(!empty($user_app_lv1)):
                        if(!empty(getEmail($user_app_lv1)))$this->send_email(getEmail($user_app_lv1), 'Pengajuan Permohonan Recruitment', $isi_email);
                        $this->approval->request('lv1', 'recruitment', $recruitment_id, $user_id, $this->detail_email($recruitment_id));
                     else:
                        if(!empty(getEmail($this->approval->approver('recruitment'))))$this->send_email(getEmail($this->approval->approver('recruitment')), 'Pengajuan Permohonan Recruitment', $isi_email);
                        $this->approval->request('hrd', 'recruitment', $recruitment_id, $user_id, $this->detail_email($recruitment_id));
                     endif;
                     redirect('form_recruitment','refresh');
                    //echo json_encode(array('st' =>1, 'recruitment_url' => $recruitment_url));    
                
            } 
    }
    
    function detail($id)
    { 
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_userdata('last_link', $this->uri->uri_string());
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $sess_id= $this->data['sess_id'] = $this->session->userdata('user_id');
        $this->data['sess_nik'] = $sess_nik = get_nik($sess_id);
        $this->data['recruitment'] = $this->recruitment_model->recruitment($id)->result();
        $this->data['_num_rows'] = $this->recruitment_model->recruitment($id)->num_rows();
        $this->data['status'] = getAll('recruitment_status', array('is_deleted' => 'where/0'));
        $this->data['urgensi'] = getAll('recruitment_urgensi', array('is_deleted' => 'where/0'));
        $jk = explode(',', getAll('users_recruitment_kualifikasi', array('id' => 'where/'.$id))->row('jenis_kelamin_id'));
        $pendidikan = explode(',', getAll('users_recruitment_kualifikasi', array('id' => 'where/'.$id))->row('pendidikan_id'));
        $komputer = explode(',', getAll('users_recruitment_kemampuan', array('id' => 'where/'.$id))->row('komputer'));
        $this->data['jenis_kelamin'] = $this->recruitment_model->get_jk($jk);
        $this->data['pendidikan'] = $this->recruitment_model->get_pendidikan($pendidikan);
        $this->data['komputer'] = $this->recruitment_model->get_komputer($komputer);
        $this->data['position_pengaju'] = $this->get_user_position($this->recruitment_model->recruitment($id)->row_array()['user_id']);
        $this->data['approval_status'] = GetAll('approval_status', array('is_deleted'=>'where/0'));
        $this->_render_page('form_recruitment/detail', $this->data);
    }
    
    function do_approve($id, $type)
    {
        if(!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            $user_id = get_nik($this->session->userdata('user_id'));
            $date_now = date('Y-m-d');

            $data = array(
            'is_app_'.$type => 1, 
            'approval_status_id_'.$type => $this->input->post('app_status_'.$type),
            'user_app_'.$type => $user_id, 
            'date_app_'.$type => $date_now,
            'note_'.$type => $this->input->post('note_'.$type)
            );
            $approval_status = $this->input->post('app_status_'.$type);
            $this->recruitment_model->update($id,$data);
            $approval_status_mail = getValue('title', 'approval_status', array('id'=>'where/'.$approval_status));
            $user_recruitment_id = getValue('user_id', 'users_recruitment', array('id'=>'where/'.$id));
            $isi_email = 'Status pengajuan recruitment anda '.$approval_status_mail. ' oleh '.get_name($user_id).' untuk detail silakan <a href='.base_url().'form_recruitment/detail/'.$id.'>Klik Disini</a><br />';
            $isi_email_request = get_name($user_recruitment_id).' mengajukan Permohonan recruitment, untuk melihat detail silakan <a href='.base_url().'form_recruitment/detail/'.$id.'>Klik Disini</a><br />';
            
           if($is_app==0){
                $this->approval->approve('recruitment', $id, $approval_status, $this->detail_email($id));
                if(!empty(getEmail($user_recruitment_id)))$this->send_email(getEmail($user_recruitment_id), 'Status Pengajuan Permohonan Recruitment dari Atasan', $isi_email);
            }else{
                $this->approval->update_approve('recruitment', $id, $approval_status, $this->detail_email($id));
                if(!empty(getEmail($user_recruitment_id)))$this->send_email(getEmail($user_recruitment_id), 'Perubahan Status Pengajuan Permohonan Recruitment dari Atasan', $isi_email);
            }
            if($type !== 'hrd' && $approval_status == 1){
                $lv = substr($type, -1)+1;
                $lv_app = 'lv'.$lv;
                $user_app = ($lv<4) ? getValue('user_app_'.$lv_app, 'users_recruitment', array('id'=>'where/'.$id)):0;
                if(!empty($user_app)):
                    if(!empty(getEmail($user_app)))$this->send_email(getEmail($user_app), 'Pengajuan Permohonan Recruitment', $isi_email_request);
                    $this->approval->request($lv_app, 'recruitment', $id, $user_recruitment_id, $this->detail_email($id));
                else:
                    if(!empty(getEmail($this->approval->approver('recruitment'))))$this->send_email(getEmail($this->approval->approver('recruitment')), 'Pengajuan Permohonan Recruitment', $isi_email_request);
                    $this->approval->request('hrd', 'recruitment', $id, $user_recruitment_id, $this->detail_email($id));
                endif;
            }else{
                $email_body = "Status pengajuan permohonan recruitment yang diajukan oleh ".get_name($user_recruitment_id).' '.$approval_status_mail. ' oleh '.get_name($user_id).' untuk detail silakan <a href='.base_url().'form_recruitment/detail/'.$id.'>Klik Disini</a><br />';
                switch($type){
                    case 'lv1':
                        //$this->approval->not_approve('recruitment', $id, )
                    break;

                    case 'lv2':
                        $receiver_id = getValue('user_app_lv1', 'users_recruitment', array('id'=>'where/'.$id));
                        $this->approval->not_approve('recruitment', $id, $receiver_id, $approval_status ,$this->detail_email($id));
                        if(!empty(getEmail($receiver_id)))$this->send_email(getEmail($receiver_id), 'Status Pengajuan Permohonan recruitment Dari Atasan', $email_body);
                    break;

                    case 'lv3':
                        $receiver_lv2 = getValue('user_app_lv2', 'users_recruitment', array('id'=>'where/'.$id));
                        $this->approval->not_approve('recruitment', $id, $receiver_lv2, $approval_status ,$this->detail_email($id));
                        if(!empty(getEmail($receiver_lv2)))$this->send_email(getEmail($receiver_lv2), 'Status Pengajuan Permohonan recruitment Dari Atasan', $email_body);

                        $receiver_lv1 = getValue('user_app_lv1', 'users_recruitment', array('id'=>'where/'.$id));
                        $this->approval->not_approve('recruitment', $id, $receiver_lv1, $approval_status ,$this->detail_email($id));
                        if(!empty(getEmail($receiver_lv1)))$this->send_email(getEmail($receiver_lv1), 'Status Pengajuan Permohonan recruitment Dari Atasan', $email_body);
                    break;

                    case 'hrd':
                        $receiver_lv3 = getValue('user_app_lv3', 'users_recruitment', array('id'=>'where/'.$id));
                        if(!empty($receiver_lv3)):
                            $this->approval->not_approve('recruitment', $id, $receiver_lv3, $approval_status ,$this->detail_email($id));
                            if(!empty(getEmail($receiver_lv3)))$this->send_email(getEmail($receiver_lv3), 'Status Pengajuan Permohonan recruitment Dari Atasan', $email_body);
                        endif;
                        $receiver_lv2 = getValue('user_app_lv2', 'users_recruitment', array('id'=>'where/'.$id));
                        if(!empty($receiver_lv2)):
                            $this->approval->not_approve('recruitment', $id, $receiver_lv2, $approval_status ,$this->detail_email($id));
                            if(!empty(getEmail($receiver_lv2)))$this->send_email(getEmail($receiver_lv2), 'Status Pengajuan Permohonan recruitment Dari Atasan', $email_body);
                        endif;
                        $receiver_lv1 = getValue('user_app_lv1', 'users_recruitment', array('id'=>'where/'.$id));
                        if(!empty($receiver_lv1)):
                            $this->approval->not_approve('recruitment', $id, $receiver_lv1, $approval_status ,$this->detail_email($id));
                        if(!empty(getEmail($receiver_lv1)))$this->send_email(getEmail($receiver_lv1), 'Status Pengajuan Permohonan recruitment Dari Atasan', $email_body);
                        endif;
                    break;
                }
            }
               redirect('form_recruitment/approval/'.$id, 'refresh');
        }
    }

    function detail_email($id)
    {
        $sess_id= $this->data['sess_id'] = $this->session->userdata('user_id');
        $this->data['sess_nik'] = $sess_nik = get_nik($sess_id);
        $this->data['recruitment'] = $this->recruitment_model->recruitment($id)->result();
        $this->data['_num_rows'] = $this->recruitment_model->recruitment($id)->num_rows();
        $this->data['status'] = getAll('recruitment_status', array('is_deleted' => 'where/0'));
        $this->data['urgensi'] = getAll('recruitment_urgensi', array('is_deleted' => 'where/0'));
        $jk = explode(',', getAll('users_recruitment_kualifikasi', array('id' => 'where/'.$id))->row('jenis_kelamin_id'));
        $pendidikan = explode(',', getAll('users_recruitment_kualifikasi', array('id' => 'where/'.$id))->row('pendidikan_id'));
        $komputer = explode(',', getAll('users_recruitment_kemampuan', array('id' => 'where/'.$id))->row('komputer'));
        $this->data['jenis_kelamin'] = $this->recruitment_model->get_jk($jk);
        $this->data['pendidikan'] = $this->recruitment_model->get_pendidikan($pendidikan);
        $this->data['komputer'] = $this->recruitment_model->get_komputer($komputer);
        $this->data['position_pengaju'] = $this->get_user_position($this->recruitment_model->recruitment($id)->row_array()['user_id']);
        $this->data['approval_status'] = GetAll('approval_status', array('is_deleted'=>'where/0'));
        return $this->load->view('form_recruitment/recruitment_mail', $this->data, TRUE);
    }

    function get_bu()
    {
            $url = get_api_key().'users/bu/format/json';
            $headers = get_headers($url);
            $response = substr($headers[0], 9, 3);
            if ($response != "404") {
                $getbu = file_get_contents($url);
                $bu = json_decode($getbu, true);
                foreach ($bu as $row)
            {
                $result['']= '- Pilih BU -';
                if($row['NUM'] != null){
                $result[$row['NUM']]= ucwords(strtolower($row['DESCRIPTION']));
                }
            }
                return $this->data['bu'] = $result;
            } else {
                return $this->data['bu'] = '';
            }
    }

    public function get_parent_org($id)
    {
        $url = get_api_key().'users/parent_org_from_bu/BUID/'.$id.'/format/json';
        //print_r($url);
            $headers = get_headers($url);
            $response = substr($headers[0], 9, 3);
            if ($response != "404") {
                $getuser_info = file_get_contents($url);
                $user_info = json_decode($getuser_info, true);
                 foreach ($user_info as $row)
        {
            $result[$row['ID']]= ucwords(strtolower($row['DESCRIPTION']));
        }
        } else {
           $result['']= '- Belum Ada Departement -';
        }
        $data['result']=$result;
        $this->load->view('dropdown_parent_org',$data);
    }

    public function get_org($id)
    {
        $url = get_api_key().'users/org_from_parent_org/ORGID/'.$id.'/format/json';
        //print_r($url);
            $headers = get_headers($url);
            $response = substr($headers[0], 9, 3);
            if ($response != "404") {
                $getuser_info = file_get_contents($url);
                $user_info = json_decode($getuser_info, true);
                 foreach ($user_info as $row)
        {
            $result[$row['ID']]= ucwords(strtolower($row['DESCRIPTION']));
        }
        } else {
           $result['']= '- Belum Ada Bagian -';
        }
        $data['result']=$result;
        $this->load->view('dropdown_org',$data);
    }

    function get_pos($id)
    {
        $url = get_api_key().'users/pos_from_org/ORGID/'.$id.'/format/json';
            $headers = get_headers($url);
            $response = substr($headers[0], 9, 3);
            if ($response != "404") {
                $getuser_info = file_get_contents($url);
                $user_info = json_decode($getuser_info, true);
                 foreach ($user_info as $row)
        {
            $result[$row['ID']]= ucwords(strtolower($row['DESCRIPTION']));
        }
        } else {
           $result['']= '- Belum Ada Jabatan -';
        }
        $data['result']=$result;
        $this->load->view('dropdown_pos',$data);
    }
    
    function get_user_position($user_id)
    {
            $url = get_api_key().'users/employement/EMPLID/'.get_nik($user_id).'/format/json';
            $headers = get_headers($url);
            $response = substr($headers[0], 9, 3);
            if ($response != "404") {
                $getuser_info = file_get_contents($url);
                $user_info = json_decode($getuser_info, true);
                return $user_info['POSITION'];
            } else {
                return '-';
            }
    }

    function recruitment_pdf($id)
    {
        $sess_id = $this->session->userdata('user_id');
        $user_id = $this->db->select('user_id')->from('users_recruitment')->where('id', $id)->get()->row('user_id');

        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        else
        {
             //$this->get_user_info($user_id);
            
            //$this->data['comp_session'] = $this->recruitment_model->render_session()->result();
            
            if(is_admin()){
                $form_recruitment = $this->data['form_recruitment'] = $this->recruitment_model->recruitment($id);
            }else{
            $form_recruitment = $this->data['form_recruitment'] = $this->recruitment_model->recruitment($id);
            }

        $this->data['recruitment'] = $this->recruitment_model->recruitment($id)->result();
        $this->data['status'] = getAll('recruitment_status', array('is_deleted' => 'where/0'));
        $this->data['urgensi'] = getAll('recruitment_urgensi', array('is_deleted' => 'where/0'));
        $jk = explode(',', getAll('users_recruitment_kualifikasi', array('id' => 'where/'.$id))->row('jenis_kelamin_id'));
        $pendidikan = explode(',', getAll('users_recruitment_kualifikasi', array('id' => 'where/'.$id))->row('pendidikan_id'));
        $komputer = explode(',', getAll('users_recruitment_kemampuan', array('id' => 'where/'.$id))->row('komputer'));
        $this->data['jenis_kelamin'] = $this->recruitment_model->get_jk($jk);
        $this->data['pendidikan'] = $this->recruitment_model->get_pendidikan($pendidikan);
        $this->data['komputer'] = $this->recruitment_model->get_komputer($komputer);

        $this->data['position_pengaju'] = $this->get_user_position(getAll('users_recruitment', array('id' => 'where/'.$id))->row_array()['user_id']);
        //print_mz(getAll('users_recruitment', array('id' => 'where/'.$id))->row_array()['user_id']);
        $this->data['id'] = $id;
        $title = $this->data['title'] = 'Form Permintaan SDM Baru-'.get_name($user_id);
        $this->load->library('mpdf60/mpdf');
        $html = $this->load->view('recruitment_pdf', $this->data, true); 
        $mpdf = new mPDF();
        $mpdf = new mPDF('A4');
        $mpdf->AddPage('p', // L - landscape, P - portrait
            '', '', '', '',
            30, // margin_left
            30, // margin right
            10, // margin top
            10, // margin bottom
            10, // margin header
            10); // margin footer
        $mpdf->WriteHTML($html);
        $mpdf->Output($id.'-'.$title.'.pdf', 'I');
        }
    }

    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('template');

                if(in_array($view, array('form_recruitment/index')))
                {
                    $this->template->set_layout('default');

                    $this->template->add_js('jquery.sidr.min.js');
                    $this->template->add_js('breakpoints.js');
                    $this->template->add_js('core.js');
                    $this->template->add_js('select2.min.js');

                    $this->template->add_js('form_index.js');

                    $this->template->add_css('jquery-ui-1.10.1.custom.min.css');
                    $this->template->add_css('plugins/select2/select2.css');
                    
                }
                elseif(in_array($view, array('form_recruitment/input',
                                             'form_recruitment/detail',)))
                {

                    $this->template->set_layout('default');

                    $this->template->add_js('jquery.sidr.min.js');
                    $this->template->add_js('breakpoints.js');
                    $this->template->add_js('select2.min.js');

                    $this->template->add_js('core.js');
                    $this->template->add_js('purl.js');

                    $this->template->add_js('respond.min.js');

                    $this->template->add_js('jquery.bootstrap.wizard.min.js');
                    $this->template->add_js('jquery.validate.min.js');
                    $this->template->add_js('bootstrap-datepicker.js');
                    //$this->template->add_js('emp_dropdown.js');
                    $this->template->add_js('form_recruitment.js');
                    
                    $this->template->add_css('jquery-ui-1.10.1.custom.min.css');
                    $this->template->add_css('plugins/select2/select2.css');
                    $this->template->add_css('datepicker.css');
                    $this->template->add_css('approval_img.css');
                     
                }

            if ( ! empty($data['title']))
            {
                $this->template->set_title($data['title']);
            }

            $this->template->load_view($view, $data);
        }
        else
        {
            return $this->load->view($view, $data, TRUE);
        }
    }
}   