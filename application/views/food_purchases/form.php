<?php defined('BASEPATH') OR exit('No direct script access allowed');
$opts = array('' => '— নির্বাচন করুন —');
foreach ($food_types as $ft) {
	$opts[$ft->id] = $ft->name;
}
?>
<div class="form-card mt-3">
	<h1 class="form-title"><?php echo isset($row) ? 'খাদ্য ক্রয় সম্পাদনা' : 'নতুন খাদ্য ক্রয়'; ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="food_type_id">খাদ্যের ধরন</label>
			<?php echo form_dropdown('food_type_id', $opts, set_value('food_type_id', isset($row) ? $row->food_type_id : ''), 'class="form-select" id="food_type_id" required'); ?>
		</div>
		<div class="mb-3">
			<label class="form-label" for="quantity_kg">পরিমাণ (কেজি)</label>
			<input type="text" class="form-control" name="quantity_kg" id="quantity_kg" required
				value="<?php echo set_value('quantity_kg', isset($row) ? $row->quantity_kg : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label" for="total_amount">মোট টাকা</label>
			<input type="text" class="form-control" name="total_amount" id="total_amount" required
				value="<?php echo set_value('total_amount', isset($row) ? $row->total_amount : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label" for="purchase_date">ক্রয়ের তারিখ</label>
			<input type="date" class="form-control" name="purchase_date" id="purchase_date" required
				value="<?php echo set_value('purchase_date', isset($row) ? $row->purchase_date : date('Y-m-d')); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="notes">নোট (ঐচ্ছিক)</label>
			<input type="text" class="form-control" name="notes" id="notes"
				value="<?php echo set_value('notes', isset($row) ? $row->notes : ''); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add">সেভ</button>
			<a class="btn btn-secondary" href="<?php echo site_url('food_purchases'); ?>">বাতিল</a>
		</div>
	<?php echo form_close(); ?>
</div>
