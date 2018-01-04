<script type="text/javascript" charset="utf-8">
    $(function()
    {
        $(".confirmClick").click( function() { 
            if ($(this).attr('title')) {
                var question = 'Are you sure you want to ' + $(this).attr('title').toLowerCase() + '?';
            } else {
                var question = 'Are you sure you want to do this action?';
            }
            if ( confirm( question ) ) {
                [removed].href = this.src;
            } else {
                return false;
            }
        });
    
    });
$(function() {
        $( "#bill_date" ).datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
});
    $(function()
    {
        $("#particular").autocomplete({
            source: [<?php
$i = 0;
foreach ($items as $item) {
    if ($i > 0) {
        echo ",";
    }
    echo '{value:"' , $item['item_name'] , '",id:"' , $item['item_id'] , '"}'; //Avoid concatenations in echo statement
    $i++;
}
?>],
                minLength: 1,//search after one characters
                select: function(event,ui){
                    //do something
                    $("#item_id").val(ui.item ? ui.item.id : '');

                }
            });   
        });	
</script>
<?php
    $total = ($medicine + $treatment) - ((-1)*($balance));
?>
<div class="form_style">
<h2>New Bill</h2><br/>
    <a class="button" href="<?php echo base_url() . "/index.php/patient/visit/" . $patient_id; ?>">Back to Visit</a>
    <br/>
    <span class="err"><?php echo validation_errors(); ?></span>
<br/>
<?php echo form_open('patient/bill/' , $visit_id , '/' , $patient_id) ?> 

    <input type="hidden" name="visit_id" value="<?=$visit_id?>"/>
    <input type="hidden" name="patient_id" value="<?=$patient_id?>"/>
    <input type="hidden" name="bill_id" value="<?=$bill_id?>"/>
    <input type="hidden" name="item_id" id="item_id"/>
    <label for="patient">Patient</label>
    <input name="patient" value="<?=$patient['first_name'] . " " . $patient['middle_name']. " " . $patient['last_name']?>"/><br/>
    <label for="bill_date">Date</label> 
    <input name="bill_date" id="bill_date" value="<?php echo date('d-m-Y'); ?>"/><br/>
        
    <h3>Bill</h3><br/>
    <a class="button" title="Print" target="_blank" href="<?php echo site_url("patient/print_receipt/" . $visit_id); ?>">Print Receipt</a>
    <a class="button" title="Payment" href="<?php echo site_url("payment/bill_payment/" . $visit_id . "/" . $patient_id . "/" . $total . "/" . $bill_id); ?>">Bill Payment</a><br/>
        <br/>
        <table class="table_style">
            <tr><th>Medicine</th><th>Quantity</th><th>Action</th></tr>
            <tr><td><input name="particular" id="particular" value=""/></td>
                <td><input name="quantity" id="quantity"/></td>           
                <td><button class="button" type="submit" naem="submit" value="particular" />Add</button></td>
            </tr>
            
        </table>
        <input type="hidden" name="action" value="medicine">
        </form>
        <?php // echo form_open('patient/bill/' . $visit_id . '/' . $patient_id) ?>

<!--        <table class="table_style">
            <tr><th>Treatment</th><th>Amount</th><th>Action</th></tr>
            <tr><td><input name="treatment" id="treatment" value=""/></td>
                <td><input name="amount" id="amount"/></td>

                <td><button class="button" type="submit" name="submit" value="treatment"/>Add</button></td>
            </tr>
        </table>
        <input type="hidden" name="action" value="treatment">
        </form>-->

        <table class="table_style">
            <tr><th>Particular</th><th>Quantity</th><th>M.R.P.</th><th>Amount</th><th>Action</th></tr>
            <?php if ($bill_details != null) {                 
                    $i=1;
                    $current_type='';
                    foreach ($bill_details as $bill_detail) {                     
                        if ($current_type=='') {
                            $current_type=$bill_detail['type'];                            
                            }
                        elseif($current_type <> $bill_detail['type'])
                        { 
            ?>
            <tr>
                <th style="text-align:left;" colspan="3">Treatment</th>
                <th style="text-align:right;"><?=currency_format($treatment);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
                <td></td>
            </tr>
            <?php
                $current_type=$bill_detail['type'];
                        }
                    ?>
                    <tr <?php
                          $var = 0; //avoid literals in methods calls					
					      if ($i % 2 == $var) { echo "class='alt'";} ?> >
                    <td><?php echo $bill_detail['particular'] ?></td>
                    
                    <td style="text-align:right;"><?php echo $bill_detail['quantity'] ?></td>                   
                    <td style="text-align:right;"><?php echo currency_format($bill_detail['mrp']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
                    <td style="text-align:right;"><?php echo currency_format($bill_detail['amount']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
                    <td><a class="button confirmClick" style="<?php if($bill_detail['type'] == 'treatment') echo 'display: none'; ?>" title="<?php echo "Delete : " . $bill_detail['particular'] ?>" href="<?php echo site_url("patient/delete_bill_detail/" . $bill_detail['bill_detail_id'] . "/" . $bill_id . "/" . $visit_id . "/" . $patient_id); ?>">Delete</a></td>
                </tr>
                <?php $i++; ?>
                <?php } 
                    if($bill_detail['type']=='medicine')
                    { ?>
                        <tr>
                            <th style="text-align:left;" colspan="3">Medicine</th>
                            <th style="text-align:right;"><?=currency_format($medicine);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
                            <td></td>
                        </tr>
                    <?php } elseif ($bill_detail['type']=='treatment') { ?>
                        <tr>
                            <th style="text-align:left;" colspan="3">Treatment</th>
                            <th style="text-align:right;"><?=currency_format($treatment);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
                            <td></td>
                        </tr>
                   <?php } ?>
                 <tr>
                    <?php if($balance < 0) { ?>
                    <th style="text-align:left;" colspan="3">Previous Balance</th>
                    <?php } else { ?>
                    <th style="text-align:left;" colspan="3">Previous Dues</th>
                    <?php } ?>
                    <th style="text-align:right;"><?= currency_format((-1)*$balance);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
                    <td></td>
                </tr>
                <tr class='total'>
                    <th style="text-align:left;" colspan="3">Total</th>
                    <th style="text-align:right;"><?= currency_format($total);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
                    <td></td>
                </tr>
                <tr>
                    <th style="text-align: left;" colspan="3">Paid Amount</th>
                    <th style="text-align: right;"><?= currency_format($paid_amount);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></th>
                    <td></td>
                </tr>
            <?php } ?>
        </table>


</div>
<?php //echo $balance; ?>