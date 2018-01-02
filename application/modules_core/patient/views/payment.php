<script type="text/javascript" charset="utf-8">
$(function() {
        $( "#pay_date" ).datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
});
</script>
<script type="text/javascript">
function changetextbox()
{
    if (document.getElementById("pay_mode").value === "Cash") {
        document.getElementById("cheque_no").disabled=true;
    } else {
        document.getElementById("cheque_no").disabled=false;
    }
}
</script>
<div class="form_style">
<h2>Payment</h2><br/>

<span class="err"><?php echo validation_errors(); ?></span>

<?php echo form_open('patient/payment/' . $visit_id ) ?>
        <input type="hidden" name="bill_id" value="<?=$bill_id?>"/>
        <label for="pay_date">Date</label> 
        <input name="pay_date" id="bill_date" class="date-pick dp-applied" value="<?php echo date('d-m-Y'); ?>"/><br/>
        <label for="pay_mode">Payment Mode</label>
        <select name="pay_mode" id="pay_mode" onchange="changetextbox();">
            <option>Cash</option>
            <option>Cheque</option>
        </select><br/>
        <label for="cheque_no">Cheque No</label>
        <input name="cheque_no" id="cheque_no" disabled="disabled"/><br/>
        <label for="amount">Amount</label>
        <input name="amount"/><br/>
        <br/>
        <div class="button_link">
            <button class="button" type="submit" name="submit" />Save</button>
        </div>
</form>

</div>