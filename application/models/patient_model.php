<?php
class Patient_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        /***Patient***/
        public function search_patient($name=null)
	{
            if ($name != null)
            {
                $this->db->like('first_name', $name);
                $this->db->or_like('middle_name', $name); 
                $this->db->or_like('last_name', $name); 
                $this->db->order_by('first_name', 'asc'); 
                $query = $this->db->get('view_patient');
                return $query->result_array();
            }
            $this->db->order_by('first_name', 'asc'); 
            $query = $this->db->get('view_patient');
            return $query->result_array();
	}
        public function get_patient()
        {
            $query = $this->db->get('view_patient');
            return $query->result_array();
        }
        public function find_patient()
	{
            $first_name = $this->input->post('first_name');
            $middle_name = $this->input->post('middle_name');
            $last_name = $this->input->post('last_name');
            if ($first_name != null && $middle_name != null && $last_name != null)
            {
                $this->db->order_by('first_name', 'asc'); 
                $this->db->like('first_name',$first_name); 
                $this->db->like('middle_name',$middle_name); 
                $this->db->like('last_name',$last_name); 
                $query = $this->db->get('view_patient');
                return $query->result_array();
            }elseif ($first_name != null && $last_name != null)
            {
                $this->db->order_by('first_name', 'asc'); 
                $this->db->like('first_name',$first_name); 
                $this->db->like('last_name',$last_name); 
                $query = $this->db->get('view_patient');
                return $query->result_array();
            }elseif ($first_name != null && $last_name == null)
            {
                $this->db->order_by('first_name', 'asc'); 
                $this->db->like('first_name',$first_name); 
                $query = $this->db->get('view_patient');
                return $query->result_array();
            }elseif ($first_name == null && $last_name != null)
            {
                $this->db->order_by('first_name', 'asc'); 
                $this->db->like('last_name',$last_name); 
                $query = $this->db->get('view_patient');
                return $query->result_array();
            }
            $this->db->order_by('first_name', 'asc'); 
            $query = $this->db->get('view_patient');
            return $query->result_array();
	}
        function insert_patient($contact_id)
        {
            $data['contact_id'] = $contact_id;
            $data['patient_since'] = date('Y-m-d');
            $this->db->insert('patient', $data);
            return $this->db->insert_id();
        }
        function delete_patient($patient_id)
        {
            $this->db->delete('patient', array('patient_id' => $patient_id)); 
        }
        public function get_patient_detail($patient_id){
            $query = $this->db->get_where('view_patient', array('patient_id' => $patient_id));
            return $query->row_array();
        }
        public function get_contact_id($patient_id){
            $query = $this->db->get_where('patient', array('patient_id' => $patient_id));
            $row = $query->row();
            if ($row)
                return $row->contact_id;
            else
                return 0;
        }
        /***Visit***/
        public function get_previous_visits($patient_id)
        {
            $this->db->order_by('visit_date', 'desc'); 
            $query = $this->db->get_where('visit', array('patient_id' => $patient_id));
            
            return $query->result_array();
        }
        public function insert_visit(){
            $data['patient_id'] = $this->input->post('patient_id');
            $data['notes'] = $this->input->post('notes');
            $data['type'] = $this->input->post('type');
            $data['visit_date'] = date('Y-m-d',strtotime($this->input->post('visit_date')));
            $data['visit_time'] = $this->input->post('visit_time');
            $this->db->insert('visit', $data);
        }
        public function get_patient_id($visit_id)
        {
            $query = $this->db->get_where('visit', array('visit_id' => $visit_id));
            $row = $query->row();
            if ($row)
                return $row->patient_id;
            else
                return 0;
        }
        /***Bill***/
        public function create_bill(){
            $data['bill_date'] = date('Y-m-d',strtotime($this->input->post('bill_date'))); 
            $data['patient_id'] = $this->input->post('patient_id');
            $data['visit_id'] = $this->input->post('visit_id');
            $this->db->insert('bill', $data);
            return $this->db->insert_id();
        }
        public function add_bill_item($bill_id){
            $data['bill_id'] = $bill_id;
            $data['particular'] = $this->input->post('particular');
            $data['amount'] = $this->input->post('amount');
            $this->db->insert('bill_detail', $data);
            
            $sql = 'update ' . $this->db->dbprefix('bill') . ' set total_amount = total_amount + ? where bill_id = ?;';
            $this->db->query($sql, array($this->input->post('amount'), $bill_id));
        }
        public function get_bill($visit_id)
        {
            $query = $this->db->get_where('bill', array('visit_id' => $visit_id));
            return $query->row_array();
        }
        public function get_bill_amount($bill_id)
        {
            $query = $this->db->get_where('bill', array('bill_id' => $bill_id));
            $row = $query->row();
            if ($row)
                return $row->amount;
            else
                return 0;
        }
        public function get_bill_id($visit_id)
        {
            $query = $this->db->get_where('bill', array('visit_id' => $visit_id));
            $row = $query->row();
            if ($row)
                return $row->bill_id;
            else
                return 0;
        }
        public function get_visit_id($bill_id)
        {
            $query = $this->db->get_where('bill', array('bill_id' => $bill_id));
            $row = $query->row();
            if ($row)
                return $row->visit_id;
            else
                return 0;
        }
        public function get_bill_detail($visit_id)
        {
            $bill_id = $this->get_bill_id($visit_id);
            $query = $this->db->get_where('bill_detail', array('bill_id' => $bill_id));
            return $query->result_array();
        }
        public function get_bill_detail_amount($bill_detail_id)
        {
            $query = $this->db->get_where('bill_detail', array('bill_detail_id' => $bill_detail_id));
            $row = $query->row();
            if ($row)
                return $row->amount;
            else
                return 0;
            
        }
        public function delete_bill_detail($bill_detail_id,$bill_id){
            $amount = $this->get_bill_detail_amount($bill_detail_id);
            $this->db->delete('bill_detail', array('bill_detail_id' => $bill_detail_id)); 
            
            $sql = 'update ' . $this->db->dbprefix('bill') . ' set total_amount = total_amount - ? where bill_id = ?;';
            $this->db->query($sql, array($amount, $bill_id));
        }
        
        /***Payment***/
        public function get_payment($bill_id)
        {
            $query = $this->db->get_where('payment', array('bill_id' => $bill_id));
            return $query->result_array();
        }
        public function insert_payment()
        {
            $data['bill_id'] = $this->input->post('bill_id');
            $data['pay_date'] = $this->input->post('pay_date');
            $data['pay_mode'] = $this->input->post('pay_mode');
            $data['amount'] = $this->input->post('amount');
            $data['cheque_no'] = $this->input->post('cheque_no');
            $this->db->insert('payment', $data);
            
            $sql = 'update ' . $this->db->dbprefix('bill') . ' set paid_amount = paid_amount + ? where bill_id = ?;';
            $this->db->query($sql, array($this->input->post('amount'), $this->input->post('bill_id')));
        }
        
}
?>
