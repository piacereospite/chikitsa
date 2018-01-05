<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<div class="form_style">
    <h2><?php echo $header; ?></h2>
    <?php echo form_open('payment/add') ?>
    
    <input type="hidden" name="payment_type" value="<?php if($header == 'Advance Payment') { echo 'advanced';} if($header == 'Bill Payment') {echo 'bill_payment';} ?>" />
    <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" />
    <input type="hidden" name="bill_id" value="<?php if ($header == 'Bill Payment') { echo $bill_id;} ?>" />
    <input type="hidden" name="visit_id" value="<?php if ($header == 'Bill Payment') { echo $visit_id;} ?>" />
    <input type="hidden" name="pay_amount" value="<?php if ($header == 'Advance Payment') {echo currency_format($balance);} ?>" />        
    <label for="balance_amount">Balance Amount</label>
    <input type="text" disabled="disabled" value="<?php if ($header == 'Advance Payment') {echo currency_format($balance);}else {echo currency_format($total);}if($currency_postfix) echo $currency_postfix['currency_postfix']; ?>"/><br />
    <label for="title">Payment Amount</label>        
    <input type="text" name="payment_amount" id="payment_amount" value="" />       
    <input class="button" type="submit" value="Add" name="submit" /><br/><br/>
    <a href="<?=site_url('appointment/index'); ?>" class="button" >Back to Appointment</a><br/>
    </form>
    
</div>
