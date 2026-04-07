<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-card mt-3">
	<h1 class="form-title"><?php echo isset($row) ? 'আয় সম্পাদনা' : 'নতুন আয়'; ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="amount">টাকার পরিমাণ</label>
			<input type="text" class="form-control" name="amount" id="amount" required
				value="<?php echo set_value('amount', isset($row) ? $row->amount : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label" for="income_date">তারিখ</label>
			<input type="date" class="form-control" name="income_date" id="income_date" required
				value="<?php echo set_value('income_date', isset($row) ? $row->income_date : date('Y-m-d')); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="description">বিবরণ (ঐচ্ছিক) — দুধ বিক্রি, গরু বিক্রি ইত্যাদি</label>
			<input type="text" class="form-control" name="description" id="description"
				value="<?php echo set_value('description', isset($row) ? $row->description : ''); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add">সেভ</button>
			<a class="btn btn-secondary" href="<?php echo site_url('incomes'); ?>">বাতিল</a>
		</div>
	<?php echo form_close(); ?>
</div>
