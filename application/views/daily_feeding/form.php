<?php defined('BASEPATH') OR exit('No direct script access allowed');
$opts = array('' => t('select_option'));
foreach ($food_types as $ft) {
	$opts[$ft->id] = $ft->name;
}
?>
<div class="form-card">
	<h1 class="form-title"><?php echo isset($row) ? t('edit_daily_feeding') : t('new_daily_feeding'); ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="food_type_id"><?php echo t('type'); ?></label>
			<?php echo form_dropdown('food_type_id', $opts, set_value('food_type_id', isset($row) ? $row->food_type_id : ''), 'class="form-select" id="food_type_id" required'); ?>
		</div>
		<div class="mb-3">
			<label class="form-label" for="quantity_kg"><?php echo t('kg'); ?></label>
			<input type="number" step="0.01" class="form-control" name="quantity_kg" id="quantity_kg" required
				value="<?php echo set_value('quantity_kg', isset($row) ? $row->quantity_kg : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label" for="feeding_date"><?php echo t('date'); ?></label>
			<input type="date" class="form-control" name="feeding_date" id="feeding_date" required
				value="<?php echo set_value('feeding_date', isset($row) ? $row->feeding_date : date('Y-m-d')); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="notes"><?php echo t('notes_opt'); ?></label>
			<input type="text" class="form-control" name="notes" id="notes"
				value="<?php echo set_value('notes', isset($row) ? $row->notes : ''); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add"><i class="bi bi-check2-circle me-1"></i><?php echo t('save'); ?></button>
			<a class="btn btn-secondary" href="<?php echo site_url('daily_feeding'); ?>"><?php echo t('cancel'); ?></a>
		</div>
	<?php echo form_close(); ?>
</div>
