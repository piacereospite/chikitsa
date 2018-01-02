<?php

class Stock extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('stock_model');
            $this->load->model('patient_model');
        }
        public function item()
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['items'] = $this->stock_model->get_items();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/item',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->stock_model->save_items();
                $data['items'] = $this->stock_model->get_items();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/item',$data);
                $this->load->view('templates/footer');
            }
	}
        public function delete_item($item_id)
        {
            $this->stock_model->delete_item($item_id);
            $this->item();
        }
        public function edit_item($item_id)
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['item'] = $this->stock_model->get_item($item_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/edit_item',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->stock_model->update_item();
                $data['items'] = $this->stock_model->get_items();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/item',$data);
                $this->load->view('templates/footer');
            }
	}
        public function supplier()
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/supplier',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->stock_model->save_supplier();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/supplier',$data);
                $this->load->view('templates/footer');
            }
	}
        public function edit_supplier($supplier_id)
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['supplier'] = $this->stock_model->get_supplier($supplier_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/edit_supplier',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->stock_model->update_supplier();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/supplier',$data);
                $this->load->view('templates/footer');
            }
	}
        public function delete_supplier($supplier_id)
        {
            $this->stock_model->delete_supplier($supplier_id);
            $this->supplier();
        }
        public function purchase()
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['items'] = $this->stock_model->get_items();
                $data['purchases'] = $this->stock_model->get_purchases();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/purchase',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->stock_model->save_purchase();
                
                $data['items'] = $this->stock_model->get_items();
                $data['purchases'] = $this->stock_model->get_purchases();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/purchase',$data);
                $this->load->view('templates/footer');
            }
	}
        public function edit_purchase($purchase_id)
	{
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['items'] = $this->stock_model->get_items();
                $data['purchase'] = $this->stock_model->get_purchase($purchase_id);
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/edit_purchase',$data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->stock_model->update_purchase();
                $data['items'] = $this->stock_model->get_items();
                $data['purchases'] = $this->stock_model->get_purchases();
                $data['suppliers'] = $this->stock_model->get_suppliers();
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/purchase',$data);
                $this->load->view('templates/footer');
            }
	}
        public function delete_purchase($purchase_id)
        {
            $this->stock_model->delete_purchase($purchase_id);
            $this->purchase();
        }
        public function delete_sell_detail($sell_detail_id,$sell_id)
        {
            $this->stock_model->delete_sell_detail($sell_detail_id);
            $this->sell($sell_id);
        }
        public function sell($sell_id = null)
        {
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('item_id', 'Item', 'required');
            
            if ($this->form_validation->run() === false)
            {
                $data['patients'] = $this->patient_model->get_patient();
                $data['items'] = $this->stock_model->get_items();
                if ($sell_id != null)
                    $data['sell'] = $this->stock_model->get_sell($sell_id);
                $data['sell_details'] = $this->stock_model->get_sell_details($sell_id);
                $this->load->view('templates/header');
                $this->load->view('templates/menu');
                $this->load->view('stock/sell',$data);
                $this->load->view('templates/footer');
            }
            else
            {
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
                $this->load->view('stock/sell',$data);
                $this->load->view('templates/footer');
            }
        }
        public function stock_report()
        {
            $data['stock_report'] = $this->stock_model->get_stock_report();
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('stock/stock_report',$data);
            $this->load->view('templates/footer');
        }
        public function all_sell()
        {
            
            $data['sells'] = $this->stock_model->get_sells();
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('stock/all_sell',$data);
            $this->load->view('templates/footer');
        }
            
}
?>