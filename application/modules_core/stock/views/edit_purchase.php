<script type="text/javascript" charset="utf-8">
$(function() {
        $( "#purchase_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
});
$(function()
{
    $("#item_name").autocomplete({
        source: [<?php
                $i=0;
                foreach ($items as $item){
                    if ($i>0) {echo ',';}
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
$(function()
{
    $("#supplier_name").autocomplete({
        source: [<?php
                $i=0;
                foreach ($suppliers as $supplier){
                    if ($i>0) {echo ',';}
                    echo '{value:"' , $supplier['supplier_name'] , '",id:"' , $supplier['supplier_id'] , '"}'; //Avoid concatenations in echo statement
                    $i++;
                }
            ?>],
        minLength: 1,//search after one characters
        select: function(event,ui){
            //do something
            $("#supplier_id").val(ui.item ? ui.item.id : '');

        }
    });   
});	
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

$(document).ready(function() {
    oTable = $('#item_table').dataTable({
        "aaSorting": [[ 1, "asc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
} );
</script>
<h2>Purchase</h2>
<div class="form_style">
    <span class="err"><?php echo validation_errors(); ?></span>

<?php echo form_open('stock/edit_purchase/', $purchase['purchase_id']) ?> 
    <input type="hidden" name="purchase_id" id="purchase_id" value="<?=$purchase['purchase_id']?>"/>
    <label for="purchase_date">Purchase Date</label> 
    <input type="input" name="purchase_date" id="purchase_date" value="<?php echo date('d-m-Y',strtotime($purchase['purchase_date']));?>"/><br/>
    <label for="bill_no">Bill No.</label> 
    <input type="input" name="bill_no" id="bill_no" value="<?=$purchase['bill_no']?>"/><br/>
    <input type="hidden" name="item_id" id="item_id" value="<?=$purchase['item_id']?>"/>
    <label for="item_name">Item</label> 
    <input type="input" name="item_name" id="item_name" value="<?=$purchase['item_name']?>"/><br/>
    <label for="quantity">Quantity</label> 
    <input type="input" name="quantity" value="<?=$purchase['quantity']?>"/><br/>
    <input type="hidden" name="supplier_id" id="supplier_id" value="<?=$purchase['supplier_id']?>"/>
    <label for="supplier_name">Supplier</label> 
    <input type="input" name="supplier_name" id="supplier_name" value="<?=$purchase['supplier_name']?>"/><br/>
    <label for="cost_price">Cost Price</label> 
    <input type="input" name="cost_price" value="<?=$purchase['cost_price']?>"/><br/>
    <label for="m_r_p">M.R.P.</label> 
    <input type="input" name="m_r_p" id="m_r_p" value="<?=$purchase['mrp']?>"/><br/>
    <div class="button_link">
        <button type="submit" name="submit" class="button" />Save</button>
    </div>
</form>

</div>