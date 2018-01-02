<?php

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model('admin_model');
        $this->load->model('login/login_model');
    }

    function index() {
        $newdata = array('user_name' => '', 'logged_in' => false,);
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        $this->load->view('templates/header');
        $this->load->view('admin_login');
        $this->load->view('templates/footer');
    }

    function home() {
        if ($this->session->userdata('user_name') == '') {
            $this->index();
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('welcome');
            $this->load->view('templates/footer');
        }
    }

    function valid_signin() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $this->login();
        }
    }

    function login() {

        $level = 'Administrator';
        $username = $this->input->post('username');
        $password = base64_encode($this->input->post('password'));

        $result = $this->admin_model->login($username, $password, $level);
        if ($result) {
            $this->home();
        } else {
            $data['username'] = $this->input->post('username');
            $this->load->view('templates/header');
            //$this->load->view('templates/menu');
            $this->load->view('admin/admin_signin_fail', $data);
            $this->load->view('templates/footer');
        }
    }

    function users() {
        if ($this->session->userdata('user_name') == '') {
            $this->index();
        } else {
            $this->form_validation->set_rules('level', 'Level', 'trim|required');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[200]|xss_clean');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
            if ($this->form_validation->run() == false) {
                
            } else {
                $this->admin_model->add_user();
            }
            $data['user'] = $this->admin_model->get_users();
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('users_list', $data);
            $this->load->view('templates/footer');
        }
    }

    function delete($id) {
        if ($this->session->userdata('user_name') == '') {
            $this->index();
        } else {
            $this->admin_model->delete_user($id);
            $this->users();
        }
    }

    function edit($uid) {
        if ($this->session->userdata('user_name') == '') {
            $this->index();
        } else {
            $data['user'] = $this->admin_model->get_edit_user($uid);
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('user_edit', $data);
            $this->load->view('templates/footer');
        }
    }

    function edit_user($uid) {
        if ($this->session->userdata('user_name') == '') {
            $this->index();
        } else {
            $this->form_validation->set_rules('level', 'Level', 'trim|required');
            $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|matches[passconf]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->edit($uid);
            }
            $this->admin_model->edit_user_data($uid);
            $this->users();
        }
    }

    public function change_profile() {
        if ($this->session->userdata('user_name') == '') {
            $this->index();
        } else {
            $user_id = $this->session->userdata('id');            

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $data['user'] = $this->admin_model->get_edit_user($user_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('edit_profile', $data);
                $this->load->view('templates/footer');
            } else {
                if ($this->input->post('newpassword') == '') {
                    $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[200]|xss_clean');
                    if ($this->form_validation->run() == false) {
                        $data['user'] = $this->admin_model->get_edit_user($user_id);
                        $this->load->view('templates/header');
                        $this->load->view('templates/menu');
                        $this->load->view('edit_profile', $data);
                        $this->load->view('templates/footer');
                    }else{
                        $this->admin_model->change_profile($user_id);
                        redirect('appointment/index');
                    }
                } else {
                    $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[200]|xss_clean');
                    $this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required|xss_clean|callback_password_check['.$user_id.']');                    
                    $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|matches[passconf]');
                    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
                    if ($this->form_validation->run() == false) {
                        $data['user'] = $this->admin_model->get_edit_user($user_id);
                        $this->load->view('templates/header');
                        $this->load->view('templates/menu');
                        $this->load->view('edit_profile', $data);
                        $this->load->view('templates/footer');
                    }else{
                        $this->admin_model->change_password($user_id);
                        redirect('appointment/index');
                    }                    
                }
            }
        }
    }

    function password_check($str , $user_id){
        $data['user'] = $this->admin_model->get_edit_user($user_id);        
        $password = base64_decode($data['user']['password']);
        if($str == $password){
            return true;
        }else{
            $this->form_validation->set_message('password_check', 'Old Password Not Matched');
            return false;
        }
    }
}

?>
