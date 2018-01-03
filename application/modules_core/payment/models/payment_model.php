<?php

class Payment_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function add_payment() {

        $patient_id = $this->input->post('patient_id');
        $payment_type = $this->input->post('payment_type');
        $amount = $this->input->post('payment_amount');                          /* Advance or Due Amount */
        //$pay_amount = $this->input->post('pay_amount');

        if ($payment_type == 'advanced') {

            //$diff = $amount + $pay_amount;
            $bill_id = null;
        }
        if ($payment_type == 'bill_payment') {
            $bill_id = $this->input->post('bill_id');
            $visit_id = $this->input->post('visit_id');
            //$diff = $amount - $pay_amount;

            $data['visit_id'] = $visit_id;
        }
        //echo $amount . " " . $patient_id;
        $data['patient_id'] = $patient_id;
        $data['amount'] = $amount;
        $data['payment_type'] = $payment_type;
        $data['bill_id'] = $bill_id;
//        $data2['pay_amount'] = $diff;
//        $this->db->update('payment', $data2, array('patient_id' => $patient_id));
        $this->db->insert('payment_transaction', $data);

        //echo '$amount = ' . $amount;
        //echo '$diff = ' . $diff;
        return $data;
    }

    function get_balance_amount($bill_id) {
        //$this->db->select_sum('pay_amount');
        //
        //Fetch all payments done till now.
//        $query = $this->db->query("SELECT SUM( amount ) as payment_amount FROM ".$this->db->dbprefix('payment_transaction') ." WHERE patient_id = ".$patient_id);
//        $row = $query->row_array();
//        $payment_amount= $row['payment_amount'];        
//        
//        //All Bill total till now , exclude current bill 
//        $today = date('Y-m-d');        
//        $query = $this->db->query("SELECT SUM( total_amount ) as bill_amount FROM ".$this->db->dbprefix('bill') ." WHERE patient_id = ".$patient_id . " AND bill_date != '". $today ."'" );
//        $row = $query->row_array();
//        $bill_amount= $row['bill_amount'];    
//        return $payment_amount - $bill_amount;

        $this->db->select('due_amount');
        $query = $this->db->get_where('bill', array('bill_id' => $bill_id));
        $result = $query->row();        
        if ($result) {
            $result = $query->row();
            $pre_due_amount = $result->due_amount;
        } else {
            $pre_due_amount = 0;
        }
        
        return $pre_due_amount;
    }

    public function get_paid_amount($bill_id) {
        $this->db->select('amount');
        $query = $this->db->get_where('payment_transaction', array('bill_id' => $bill_id, 'payment_type' => 'bill_payment'));
        $result = $query->row();
        if ($result) {
            $result = $query->row();
            $paid_amount = $result->amount;
        } else {
            $paid_amount = 0;
        }
        return $paid_amount;
    }
}

?>
