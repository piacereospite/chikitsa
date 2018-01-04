<?php

class Gallery extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model('contact/contact_model');
        $this->load->model('patient/patient_model');
        //$this->load->model('settings/settings_model');
        $this->load->model('gallery_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index($p, $v, $error = array()) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $patient_id = $p;
            $visit_id = $v;
            $data['images'] = $this->gallery_model->get_images($patient_id);
            $data['patient'] = $this->gallery_model->get_displayid($patient_id);
            $data['patient_id'] = $patient_id;
            $data['visit_id'] = $visit_id;
            $data['upload_error'] = $error;
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('gallery_view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function add_image() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $p_id = $this->input->post('patient_id');
            $d_id = $this->input->post('display_id');
            $v_id = $this->input->post('visit_id');

            /* GET UPLOADED FILE NAME IN $FAILE_NAME VARIABLE */
            $file_name = $this->do_upload($p_id, $v_id, $d_id);                           // Call Upload File Function
            //echo $file_name;
            // Check Upload Function value
            if (is_array($file_name)) {                                      // If False Then Return To Index
                $this->index($p_id, $v_id, $file_name);
            } else {                                                        // If True Then Insert Path Of Image, patient Id and Visit Id
                $this->gallery_model->insert_image($file_name, $p_id, $v_id);
                $this->index($p_id, $v_id);
            }
        }
    }

    function do_upload($p_id, $v_id, $d_id) {
        //echo "Hi";
		$p_id=$p_id + 1; $v_id=$v_id + 1;
        $config['upload_path'] = './patient_images/';
        $config['allowed_types'] = 'jpg';
        //$config['max_size'] = '100';
        $config['overwrite'] = false;
		$var = 800; //avoid literals in methods calls
        $config['max_width'] = $var;
        $config['max_height'] = $var;
        $config['file_name'] = $d_id . "_" . date("dmY");


        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            $error = array('error' => $this->upload->display_errors());
//
            //$this->index($p_id, $v_id, $error);
            return $error;
        } else {

            $data = array('upload_data' => $this->upload->data());
            //echo $data['upload_data']['file_name'];
            //$this->load->view('upload_success', $data);
            return $data['upload_data']['file_name'];
        }
    }

    function image_compare() {
        $data['images'] = $this->input->post('patient_image');
        $this->load->view('templates/header');
        $this->load->view('templates/menu');
        $this->load->view('image_compare', $data);
        $this->load->view('templates/footer');
    }

}

?>
