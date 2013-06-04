<!-- file path View/Advertisements/get_by_category.ctp -->
<option value="">--Seçiniz--</option>
<?php foreach ($selectBoxResult as $key => $value): ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php endforeach; ?>