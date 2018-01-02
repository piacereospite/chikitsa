<?php
class Contact_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        public function get_contacts($id)
	{
            $query = $this->db->get_where('contacts', array('contact_id' => $id));
            return $query->row_array();
	}
        public function get_contact_address($contact_id)
	{
            $query = $this->db->get_where('address', array('contact_id' => $contact_id));
            return $query->row_array();
	}
        public function view_contact_address($contact_id)
	{
            $query = $this->db->get_where('view_address', array('contact_id' => $contact_id));
            return $query->result_array();
	}
        public function search_contacts($name=null,$phone=null)
	{
            if ($phone != null)
            {
                $this->db->like('phone_number', $phone);
                $query = $this->db->get('view_contacts');
                return $query->result_array();
            }
            if ($name != null)
            {
                $this->db->like('first_name', $name);
                $this->db->or_like('middle_name', $name); 
                $this->db->or_like('last_name', $name); 
                
                $query = $this->db->get('view_contacts');
                return $query->result_array();
            }
            $query = $this->db->get('view_contacts');
            return $query->result_array();
	}
        function insert_contact()
        {
            $data['first_name'] = $this->input->post('first_name');
            $data['middle_name'] = $this->input->post('middle_name');
            $data['last_name'] = $this->input->post('last_name');
            $data['phone_number'] = $this->input->post('phone_number');
            $this->db->insert('contacts', $data);
            return $this->db->insert_id();
        }
        
        function update_contact()
        {
            $data->first_name   = $this->input->post('first_name');
            $data->middle_name  = $this->input->post('middle_name');
            $data->last_name    = $this->input->post('last_name');
            $data->phone_number = $this->input->post('phone_number');
            $this->db->update('contacts', $data, array('contact_id' =>  $this->input->post('contact_id')));
        }
        function update_address()
        {
            $data->contact_id       = $this->input->post('contact_id');
            $data->type             = $this->input->post('type');
            $data->address_line_1   = $this->input->post('address_line_1');
            $data->address_line_2   = $this->input->post('address_line_2');
            $data->city             = $this->input->post('city');
            $data->state            = $this->input->post('state');
            $data->postal_code      = $this->input->post('postal_code');
            $data->country          = $this->input->post('country');
            $this->db->update('address', $data, array('address_id' =>  $this->input->post('address_id')));
        }
        function delete_contact($id)
        {
            $this->db->delete('contacts', array('contact_id' => $id)); 
        }
        /**Address*/
        function insert_address($id)
        {
            $data['contact_id'] = $id;
            $data['type'] = $this->input->post('type');
            $data['address_line_1'] = $this->input->post('address_line_1');
            $data['address_line_2'] = $this->input->post('address_line_2');
            $data['city'] = $this->input->post('city');
            $data['state'] = $this->input->post('state');
            $data['postal_code'] = $this->input->post('postal_code');
            $data['country'] = $this->input->post('country');
            $this->db->insert('address', $data);
        }
        function delete_address($id)
        {
            $this->db->delete('address', array('contact_id' => $id)); 
        }
        /** Emails*/
        public function get_contact_email($id)
	{
            $query = $this->db->get_where('contact_details', array('contact_id' => $id,'type'=>'email'));
            return $query->result_array();
	}
        function insert_email($id)
        {

            $sql = "INSERT into contact_details (contact_id,type,detail) Values (?,'email',?)"; 
            
            $emails = $this->input->post('email');
            $i=0;
            foreach($emails as $email)
            {
                $this->db->query($sql, array($id,$email));
                $i++;
            }
        }
        function update_emails()
        {
            $sql_update = "UPDATE contact_details SET detail = ?  WHERE contact_detail_id = ?"; 
            $sql_insert = "INSERT into contact_details (contact_id,type,detail) Values (?,'email',?)"; 

            $id = $this->input->post('contact_id');
            $emails = $this->input->post('email');
            $email_ids = $this->input->post('email_id');
            $i=0;
            
            foreach($emails as $email)
            {
                if ($email_ids[$i]!=null)
                {
                    $this->db->query($sql_update, array($email,$email_ids[$i]));
                }
                else
                {
                    $this->db->query($sql_insert, array($id,$email,1));
                }
                $i++;
            }
            
        }
      
}
?>
