<?php

class Stock extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('currency_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('stock_model');
        $this->load->model('patient/patient_model');
        $this->load->model('settings/settings_model');
    }

    public function item() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
            $data['items'] = $this->stock_model->get_items();

            if ($this->form_validation->run() === false) {
                
            } else {
                $this->stock_model->save_items();
                $data['items'] = $this->stock_model->get_items();
            }
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('stock/item', $data);
            $this->load->view('templates/footer');
        }
    }

    public function delete_item($item_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->stock_model->delete_item($item_id);
            $this->item();
        }
    }

    public function edit_item($item_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');

            if ($this->form_validation->run() === false) {
                $data['item'] = $this->stock_model->get_item($item_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/edit_item', $data);
                $this->load->view('templates/footer');
            } else {
                $this->stock_model->update_item();
                $data['items'] = $this->stock_model->get_items();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/item', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function supplier() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');

            if ($this->form_validation->run() === false) {
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/supplier', $data);
                $this->load->view('templates/footer');
            } else {
                $this->stock_model->save_supplier();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/supplier', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function edit_supplier($supplier_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');

            if ($this->form_validation->run() === false) {
                $data['supplier'] = $this->stock_model->get_supplier($supplier_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/edit_supplier', $data);
                $this->load->view('templates/footer');
            } else {
                $this->stock_model->update_supplier();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/supplier', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function delete_supplier($supplier_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->stock_model->delete_supplier($supplier_id);
            $this->supplier();
        }
    }

    public function purchase() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required');
            $this->form_validation->set_rules('bill_no', 'Bill No', 'required');
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required');
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
            $this->form_validation->set_rules('cost_price', 'Cost Price', 'required');
            $this->form_validation->set_rules('m_r_p', 'M.R.P.', 'required');

            $data['currency_postfix'] = $this->settings_model->get_currency_postfix();
            if ($this->form_validation->run() === false) {
                
            } else {
                $this->stock_model->save_purchase();
            }

            $data['items'] = $this->stock_model->get_items();
            $data['purchases'] = $this->stock_model->get_purchases();
            $data['suppliers'] = $this->stock_model->get_suppliers();

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('purchase', $data);
            $this->load->view('templates/footer');
        }
    }

    public function purchase_report() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $data['currency_postfix'] = $this->settings_model->get_currency_postfix();
            $data['purchases'] = $this->stock_model->get_purchases();
            $data['bill_totals'] = $this->stock_model->get_bill_total();
            $level = $this->session->userdata('category');
            if ($level == 'Administrator') {
                $this->load->view('purchase_report', $data);
            } else {
                $this->load->view('purchase', $data);
            }
        }
    }

    public function edit_purchase($purchase_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required');
            $this->form_validation->set_rules('bill_no', 'Bill No', 'required');
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required');
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
            $this->form_validation->set_rules('cost_price', 'Cost Price', 'required');
            $this->form_validation->set_rules('m_r_p', 'M.R.P.', 'required');

            if ($this->form_validation->run() === false) {
                $data['items'] = $this->stock_model->get_items();
                $data['purchase'] = $this->stock_model->get_purchase($purchase_id);
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/edit_purchase', $data);
                $this->load->view('templates/footer');
            } else {
                $this->stock_model->update_purchase();
                $data['items'] = $this->stock_model->get_items();
                $data['purchases'] = $this->stock_model->get_purchases();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/purchase', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function delete_purchase($purchase_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->stock_model->delete_purchase($purchase_id);
            $this->purchase();
        }
    }

    public function delete_sell_detail($sell_detail_id = null, $sell_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->stock_model->delete_sell_detail($sell_detail_id);
            $this->sell($sell_id);
        }
    }

    public function sell($sell_id = null) {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $this->form_validation->set_rules('item_id', 'Item', 'required');

            if ($this->form_validation->run() === false) {
                $data['patients'] = $this->patient_model->get_patient();
                $data['items'] = $this->stock_model->get_items();
                if ($sell_id != null)
                    $data['sell'] = $this->stock_model->get_sell($sell_id);
                $data['sell_details'] = $this->stock_model->get_sell_details($sell_id);

                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/sell', $data);
                $this->load->view('templates/footer');
            } else {
                $sell_id = $this->input->post('sell_id');
                if ($sell_id == null)
                    $sell_id = $this->stock_model->insert_sell();
                $this->stock_model->insert_sell_detail($sell_id);
                $data['patients'] = $this->patient_model->get_patient();
                $data['items'] = $this->stock_model->get_items();
                $data['sell'] = $this->stock_model->get_sell($sell_id);
                $data['sell_details'] = $this->stock_model->get_sell_details($sell_id);

                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/sell', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function stock_report() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $data['stock_report'] = $this->stock_model->get_stock_report();
            $data['currency_postfix'] = $this->settings_model->get_currency_postfix();
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('stock_report', $data);
            $this->load->view('templates/footer');
        }
    }

    public function all_sell() {
        if ($this->session->userdata('user_name') == '') {
            redirect('login/index');
        } else {
            $data['sells'] = $this->stock_model->get_sells();

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('stock/all_sell', $data);
            $this->load->view('templates/footer');
        }
    }

}

?>