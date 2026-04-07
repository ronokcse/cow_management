<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-card mt-3">
	<h1 class="form-title"><?php echo isset($row) ? 'খরচ সম্পাদনা' : 'নতুন খরচ'; ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="amount">টাকার পরিমাণ</label>
			<input type="text" class="form-control" name="amount" id="amount" required
				value="<?php echo set_value('amount', isset($row) ? $row->amount : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label" for="expense_date">তারিখ</label>
			<input type="date" class="form-control" name="expense_date" id="expense_date" required
				value="<?php echo set_value('expense_date', isset($row) ? $row->expense_date : date('Y-m-d')); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="description">বিবরণ (ঐচ্ছিক) — চিকিৎসা, শ্রমিক, পরিবহন ইত্যাদি</label>
			<input type="text" class="form-control" name="description" id="description"
				value="<?php echo set_value('description', isset($row) ? $row->description : ''); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add">সেভ</button>
			<a class="btn btn-secondary" href="<?php echo site_url('other_expenses'); ?>">বাতিল</a>
		</div>
	<?php echo form_close(); ?>
</div>
