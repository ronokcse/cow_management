<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-card mt-3">
	<h1 class="form-title"><?php echo isset($row) ? 'বিনিয়োগ সম্পাদনা' : 'নতুন বিনিয়োগ'; ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="amount">টাকার পরিমাণ</label>
			<input type="text" class="form-control" name="amount" id="amount" required
				value="<?php echo set_value('amount', isset($row) ? $row->amount : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label" for="investment_date">তারিখ</label>
			<input type="date" class="form-control" name="investment_date" id="investment_date" required
				value="<?php echo set_value('investment_date', isset($row) ? $row->investment_date : date('Y-m-d')); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="description">বিবরণ (ঐচ্ছিক)</label>
			<input type="text" class="form-control" name="description" id="description"
				value="<?php echo set_value('description', isset($row) ? $row->description : ''); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add">সেভ</button>
			<a class="btn btn-secondary" href="<?php echo site_url('investments'); ?>">বাতিল</a>
		</div>
	<?php echo form_close(); ?>
</div>
