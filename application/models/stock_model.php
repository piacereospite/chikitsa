<?php
class Stock_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        //Items
        public function get_items()
        {
            $query = $this->db->get('item');
            return $query->result_array();
        }
        public function get_item($item_id)
        {
            $query = $this->db->get_where('item', array('item_id' => $item_id));
            return $query->row_array();
        }
        public function save_items()
        {
            $data['item_name'] = $this->input->post('item_name');
            $data['desired_stock'] = $this->input->post('desired_stock');
            $this->db->insert('item', $data);
        }
        
        //Purchase
        public function get_purchases()
        {
            $query = $this->db->get('view_purchase');
            return $query->result_array();
        }
        public function get_purchase($purchase_id)
        {
            $query = $this->db->get_where('view_purchase', array('purchase_id' => $purchase_id));
            return $query->row_array();
        }
        public function save_purchase()
        {
            $data['purchase_date'] = date("Y-m-d",strtotime($this->input->post('purchase_date')));
            $data['item_id'] = $this->input->post('item_id');
            $data['quantity'] = $this->input->post('quantity');
            $data['supplier_id'] = $this->input->post('supplier_id');
            $data['cost_price'] = $this->input->post('cost_price');
            $this->db->insert('purchase', $data);
        }
        public function update_purchase()
        {   
            $purchase_id = $this->input->post('purchase_id');
            
            $data['purchase_id'] = $this->input->post('purchase_id');
            $data['purchase_date'] = $this->input->post('purchase_date');
            $data['item_id'] = $this->input->post('item_id');
            $data['quantity'] = $this->input->post('quantity');
            $data['supplier_id'] = $this->input->post('supplier_id');
            $data['cost_price'] = $this->input->post('cost_price');
            $this->db->update('purchase', $data, array('purchase_id' =>  $purchase_id));
        }
}
?>
