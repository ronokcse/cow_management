<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-card">
	<h1 class="form-title"><?php echo isset($row) ? t('edit_food_type') : t('new_food_type'); ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="name"><?php echo t('name'); ?></label>
			<input type="text" class="form-control" name="name" id="name" required
				value="<?php echo set_value('name', isset($row) ? $row->name : ''); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="sort_order"><?php echo t('sort_order_hint'); ?></label>
			<input type="number" class="form-control" name="sort_order" id="sort_order"
				value="<?php echo set_value('sort_order', isset($row) ? $row->sort_order : '0'); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add"><i class="bi bi-check2-circle me-1"></i><?php echo t('save'); ?></button>
			<a class="btn btn-secondary" href="<?php echo site_url('food_types'); ?>"><?php echo t('cancel'); ?></a>
		</div>
	<?php echo form_close(); ?>
</div>
