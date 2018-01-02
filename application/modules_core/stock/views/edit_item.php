<div class="form_style">
    <span class="err"><?php echo validation_errors(); ?></span>

    <?php echo form_open('stock/edit_item') ?>
            <input type="hidden" name="item_id" value="<?=$item['item_id']?>"/><br/>
            <label for="item_name">Item Name</label> 
            <input type="input" name="item_name" value="<?=$item['item_name']?>"/><br/>
            <label for="desired_stock">Desired Stock</label> 
            <input type="input" name="desired_stock" value="<?=$item['desired_stock']?>"/><br/>
            <div class="button_link">
                <button type="submit" name="submit" class="button" />Save</button>
            </div>
    </form>
</div>