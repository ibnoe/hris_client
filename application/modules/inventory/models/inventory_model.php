<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class form_exit_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function form_exit($id = null)
    {
        $sess_id = $this->session->userdata('user_id');
            
        if(!empty(is_have_subordinate(get_nik($sess_id)))){
        $sub_id = get_subordinate($sess_id);
        }else{
            $sub_id = '';
        }

        $admin = $this->ion_auth->is_admin()||$this->ion_auth->is_admin_bagian();

        //$this->db->select('users_exit.id as id, users_exit.user_id, exit_type.title as exit_type, users_exit.date_exit, users_exit.created_on as date_created, users_exit.is_app,users_exit.user_app, users_exit.date_app,users_exit.note_app, users_exit.is_app_mgr, users_exit.user_app_mgr, users_exit.date_app_mgr, users_exit.is_app_koperasi, users_exit.user_app_koperasi, users_exit.date_app_koperasi,users_exit.is_app_perpus, users_exit.user_app_perpus, users_exit.date_app_perpus,users_exit.is_app_hrd, users_exit.user_app_hrd, users_exit.date_app_hrd, users_exit_inventaris.*, users_exit_rekomendasi.*');
        $this->db->select('users_exit.*, exit_type.title as exit_type');
        $this->db->from('users_exit');
        $this->db->join('users', 'users.id = users_exit.user_id', 'LEFT');
        $this->db->join('exit_type', 'users_exit.exit_type_id = exit_type.id', 'LEFT');
        

        $this->db->where('users_exit.is_deleted', 0);
        if($admin!=1){
        $this->db->where("(users_exit.user_id= $sess_id $sub_id)",null, false);
        }
        if($id!=null){
            $this->db->where('users_exit.id', $id);
        }

        $this->db->where('is_purposed', 1);
        //$this->db->where('users_exit.user_id', $sess_id);
        $this->db->order_by('users_exit.id', 'desc');
        $q = $this->db->get();

        return $q;

    }

    function form_exit_detail($id, $user_id)
    {
        $this->db->select('users_exit.*,users_exit.id as id,users_inventory.*, users_exit_rekomendasi.*, exit_type.title as exit_type');
        $this->db->from('users_exit');
        $this->db->join('users', 'users.id = users_exit.user_id', 'LEFT');
        $this->db->join('exit_type', 'users_exit.exit_type_id = exit_type.id', 'LEFT');                                                                                                                                                                                                                                                                                                                                                                              
        $this->db->join('users_exit_rekomendasi', 'users_exit.user_exit_rekomendasi_id = users_exit_rekomendasi.user_exit_id', 'LEFT');                                                                                                                                                                                                                                                                                                                                                                               
        $this->db->join('users_inventory', 'users_exit.id = users_inventory.user_exit_id', 'LEFT');                                                                                                                                                                                                                                                                                                                                                                               
        
        $this->db->where('users_inventory.user_exit_id', $id)->where('users_exit.user_id', $user_id);

        

        $this->db->where('users_exit.is_deleted', 0);
        
        $q = $this->db->get();

        return $q;

    }

    function add($data1, $data2, $data3)
    {
        $this->db->insert('users_exit', $data1);
        $this->db->insert('users_exit_inventaris', $data2);
        $this->db->insert('users_exit_rekomendasi', $data3);
        return true;
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('users_exit', $data);

        return TRUE;
    }

}