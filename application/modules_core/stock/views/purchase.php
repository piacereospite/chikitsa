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
$(function()
{
    $("#supplier_name").autocomplete({
        source: [<?php
                $i=0;
                foreach ($suppliers as $supplier){
    if ($i > 0) {
        echo ",";
    }
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
<div class="form_style">
<h2>Purchase</h2>
<?php echo form_open('stock/purchase') ?>
    <label for="purchase_date">Purchase Date</label> 
    <input type="input" name="purchase_date" id="purchase_date"/><br/>
    <span class="err"><?php echo form_error('purchase_date'); ?></span>
    
    <label for="bill_no">Bill No.</label> 
    <input type="input" name="bill_no" id="bill_no"/><br/>
    <span class="err"><?php echo form_error('bill_no'); ?></span>
    
    <input type="hidden" name="item_id" id="item_id"/>
    <label for="item_name">Item</label> 
    <input type="input" name="item_name" id="item_name"/><br/>
    <span class="err"><?php echo form_error('item_name'); ?></span>
    
    <label for="quantity">Quantity</label> 
    <input type="input" name="quantity"/><br/>
    <span class="err"><?php echo form_error('quantity'); ?></span>
    
    <input type="hidden" name="supplier_id" id="supplier_id"/>
    <label for="supplier_name">Supplier</label> 
    <input type="input" name="supplier_name" id="supplier_name"/><br/>
    <span class="err"><?php echo form_error('supplier_name'); ?></span>
    
    <label for="cost_price">Cost Price</label> 
    <input type="input" name="cost_price"/><br/>
    <span class="err"><?php echo form_error('cost_price'); ?></span>
    
    <label for="m_r_p">M.R.P.</label> 
    <input type="input" name="m_r_p" id="m_r_p"/><br/>
    <span class="err"><?php echo form_error('m_r_p'); ?></span>
    
    <div class="button_link">
        <button type="submit" name="submit" class="button" />Save</button>
    </div>
</form>
</div>
<div id="example_wrapper" class="dataTables_wrapper" role="grid">
<table id="item_table" class="display">
    <thead>
            <tr><th>ID</th><th>Purchase Date</th><th>Bill No.</th><th>Item</th><th>Quantity</th><th>Supplier</th><th>Cost Price</th><th>M.R.P.</th><th>Edit</th><th>Delete</th></tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($purchases as $purchase):  ?>
    <tr>
        <td><?php echo $purchase['purchase_id'] ?></td>
                    <td><?php echo date("d-m-Y",strtotime($purchase['purchase_date']));?></td>
                    <td><?php echo $purchase['bill_no'] ?></td>
        <td><?php echo $purchase['item_name'] ?></td>
        <td><?php echo $purchase['quantity'] ?></td>
        <td><?php echo $purchase['supplier_name'] ?></td>
        <td class="right"><?php echo currency_format($purchase['cost_price']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
        <td class="right"><?php echo currency_format($purchase['mrp']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
        <td><a class="button" title="Edit" href="<?php echo site_url("stock/edit_purchase/" . $purchase['purchase_id']); ?>">Edit</a></td>
        <td><a class="button confirmClick" title="<?php echo "Delete Purchase";?>" href="<?php echo site_url("stock/delete_purchase/" . $purchase['purchase_id']); ?>">Delete</a></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach ?>
    </tbody>
</table>
</div>
