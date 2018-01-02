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
        public function delete_item($item_id)
        {
            $this->db->delete('item', array('item_id' => $item_id)); 
        }
        public function update_item()
        {   
            $item_id = $this->input->post('item_id');
            $data['item_id'] = $this->input->post('item_id');
            $data['item_name'] = $this->input->post('item_name');
            $data['desired_stock'] = $this->input->post('desired_stock');
            $this->db->update('item', $data, array('item_id' =>  $item_id));
        }
        //Suppliers
        public function get_suppliers()
        {
            $query = $this->db->get('supplier');
            return $query->result_array();
        }
        public function get_supplier($supplier_id)
        {
            $query = $this->db->get_where('supplier', array('supplier_id' => $supplier_id));
            return $query->row_array();
        }
        public function save_supplier()
        {
            $data['supplier_name'] = $this->input->post('supplier_name');
            $data['contact_number'] = $this->input->post('contact_number');
            $this->db->insert('supplier', $data);
        }
        public function delete_supplier($supplier_id)
        {
            $this->db->delete('supplier', array('supplier_id' => $supplier_id)); 
        }
        public function update_supplier()
        {   
            $supplier_id = $this->input->post('supplier_id');
            $data['supplier_id'] = $this->input->post('supplier_id');
            $data['supplier_name'] = $this->input->post('supplier_name');
            $data['contact_number'] = $this->input->post('contact_number');
            $this->db->update('supplier', $data, array('supplier_id' =>  $supplier_id));
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
        public function delete_purchase($purchase_id)
        {
            $this->db->delete('purchase', array('purchase_id' => $purchase_id)); 
        }
        public function insert_sell()
        {
            $data['sell_date'] = date("Y-m-d",strtotime($this->input->post('sell_date')));
            $data['patient_id'] = $this->input->post('patient_id');
            $this->db->insert('sell', $data);
            $sell_id = $this->db->insert_id();
            return $sell_id;
        }
        public function update_sell_amount($sell_id,$amount)
        {
            $query = $this->db->get_where('sell', array('sell_id' => $sell_id));
            $row = $query->row();
            if ($row)
                $sell_amount = $row->sell_amount;
            else
                $sell_amount = 0;
            
            $data['sell_amount'] = $amount + $sell_amount;
            $this->db->update('sell', $data, array('sell_id' =>  $sell_id));
            return $this->db->insert_id();
        }
        public function insert_sell_detail($sell_id)
        {
            $data['sell_id'] = $sell_id;
            $data['item_id'] = $this->input->post('item_id');
            $data['quantity'] = $this->input->post('quantity');
            $data['sell_price'] = $this->input->post('sell_price');
            $data['sell_amount'] = $this->input->post('sell_price') * $this->input->post('quantity');
            $amount = $data['sell_amount'];
            $this->db->insert('sell_detail', $data);
            $this->update_sell_amount($sell_id,$amount);
        }
        public function get_sell_details($sell_id)
        {
            $sql = 'SELECT a.sell_detail_id,b.item_name,a.quantity,a.sell_price,a.sell_amount FROM sell_detail as a,item as b WHERE a.item_id = b.item_id AND a.sell_id = ?';
            $query = $this->db->query($sql,$sell_id);
            return $query->result_array();
        }
        public function get_sells()
        {
            $sql = 'Select a.sell_id,a.sell_date,a.patient_id,a.sell_amount,c.first_name,c.middle_name,c.last_name
                      from ' . $this->db->dbprefix('sell') . ' as a 
                           LEFT OUTER JOIN ' . $this->db->dbprefix('patient') . ' as b ON a.patient_id = b.patient_id
                           LEFT OUTER JOIN ' . $this->db->dbprefix('contacts') . ' as c ON c.contact_id = b.contact_id';
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        public function get_sell($sell_id)
        {
            $sql = 'Select a.sell_id,a.sell_date,a.patient_id,a.sell_amount,c.first_name,c.middle_name,c.last_name
                      from ' . $this->db->dbprefix('sell') . ' as a 
                           LEFT OUTER JOIN ' . $this->db->dbprefix('patient') . ' as b ON a.patient_id = b.patient_id
                           LEFT OUTER JOIN ' . $this->db->dbprefix('contacts') . ' as c ON c.contact_id = b.contact_id
                     where a.sell_id=' . $sell_id;
            $query = $this->db->query($sql);
            return $query->row_array();
        }
        public function delete_sell_detail($sell_detail_id)
        {
            $this->db->delete('sell_detail', array('sell_detail_id' => $sell_detail_id)); 
        }
        public function get_stock_report()
        {
            $query = $this->db->get('view_stock');
            return $query->result_array();
        }
}
?>
