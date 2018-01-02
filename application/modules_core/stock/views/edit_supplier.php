<div class="form_style">
    <?php echo form_open('stock/edit_supplier') ?>
            <input type="hidden" name="supplier_id" value="<?=$supplier['supplier_id']?>"/><br/>
            <label for="supplier_name">Supplier Name</label> 
            <input type="input" name="supplier_name" value="<?=$supplier['supplier_name']?>"/><br/>
            <label for="contact_number">Contact Number</label> 
            <input type="input" name="contact_number" value="<?=$supplier['contact_number']?>"/><br/>
            <div class="button_link">
                <button type="submit" name="submit" class="button" />Save</button>
            </div>
    </form>
</div>