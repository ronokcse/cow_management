<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-card mt-3">
	<h1 class="form-title"><?php echo isset($row) ? 'খাদ্যের ধরন সম্পাদনা' : 'নতুন খাদ্যের ধরন'; ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="name">নাম</label>
			<input type="text" class="form-control" name="name" id="name" required
				value="<?php echo set_value('name', isset($row) ? $row->name : ''); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="sort_order">সাজানো (ছোট সংখ্যা আগে দেখাবে)</label>
			<input type="number" class="form-control" name="sort_order" id="sort_order"
				value="<?php echo set_value('sort_order', isset($row) ? $row->sort_order : '0'); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add">সেভ</button>
			<a class="btn btn-secondary" href="<?php echo site_url('food_types'); ?>">বাতিল</a>
		</div>
	<?php echo form_close(); ?>
</div>
