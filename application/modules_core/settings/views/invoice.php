<?php
    if(!$invoice)
    {
        $static_prefix = '';
        $left_pad = '';
        $currency_symbol = '';
        $currency_postfix = '';
    }
    else
    {
        $static_prefix = $invoice['static_prefix'];
        $left_pad = $invoice['left_pad'];
        $currency_symbol = $invoice['currency_symbol'];
        $currency_postfix = $invoice['currency_postfix'];
    }
?>
<div class="form_style">
<h2>Invoice Details</h2>
<span class="err"><?php echo validation_errors(); ?></span>
<?php echo form_open('settings/invoice') ?>
        <label for="static_prefix">Static Prefix</label> 
	<input type="input" name="static_prefix" value="<?=$static_prefix; ?>"/><br/>
        <label for="left_pad">Length of Invoice Number </label> 
	<input type="input" name="left_pad" value="<?=$left_pad; ?>"/><br/>
        <label for="currency_symbol">Currency Prefix</label> 
	<input type="input" name="currency_symbol" value="<?=$currency_symbol; ?>"/><br/>
        <label for="currency_postfix">Currency Postfix</label> 
	<input type="input" name="currency_postfix" value="<?=$currency_postfix; ?>"/><br/>
        <div class="button_link">
            <button type="submit" name="submit" class="button" />Save</button>
        </div>
</form>
</div>