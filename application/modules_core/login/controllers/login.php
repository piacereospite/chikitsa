<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        //$this->load->helper('form', 'url');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model('login_model');
    }

    function index() {
        if ($this->session->userdata('user_name') != '') {
            $this->home();
        } else {
            $this->load->view('templates/header');
            $this->load->view('login/login_signup');
            $this->load->view('templates/footer');
        }
    }

    function home() {
        if ($this->session->userdata('user_name') == '') {
            $this->index();
        } else {
            redirect('/appointment/index', 'refresh');
        }
    }

    function valid_signin() {
//        $this->form_validation->set_rules('level', 'Level', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $this->login();
        }
    }

    function login() {
//        $level = $this->input->post('level');
        $username = $this->input->post('username');
        $password = base64_encode($this->input->post('password'));
        $result = $this->login_model->login($username, $password);
        if ($result) {
            $this->home();
        } else {
            $data['username'] = $this->input->post('username');
            $data['level'] = $this->input->post('level');
            $this->load->view('templates/header');
            //$this->load->view('templates/menu');
            $this->load->view('signin_fail', $data);
            $this->load->view('templates/footer');
        }
    }

    public function logout() {
        $newdata = array('name' => '', 'user_name' => '', 'category' => '', 'logged_in' => false,);
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        $this->index();
    }

}

?>
