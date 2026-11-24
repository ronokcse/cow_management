<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-card">
	<h1 class="form-title"><?php echo isset($row) ? t('edit_investment') : t('new_investment'); ?></h1>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
	<?php echo form_open(); ?>
		<div class="mb-3">
			<label class="form-label" for="amount"><?php echo t('amount'); ?></label>
			<input type="number" step="0.01" class="form-control" name="amount" id="amount" required
				value="<?php echo set_value('amount', isset($row) ? $row->amount : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label" for="investment_date"><?php echo t('date'); ?></label>
			<input type="date" class="form-control" name="investment_date" id="investment_date" required
				value="<?php echo set_value('investment_date', isset($row) ? $row->investment_date : date('Y-m-d')); ?>">
		</div>
		<div class="mb-4">
			<label class="form-label" for="description"><?php echo t('description_opt'); ?></label>
			<input type="text" class="form-control" name="description" id="description"
				value="<?php echo set_value('description', isset($row) ? $row->description : ''); ?>">
		</div>
		<div class="d-flex flex-wrap gap-2">
			<button type="submit" class="btn btn-success btn-add"><i class="bi bi-check2-circle me-1"></i><?php echo t('save'); ?></button>
			<a class="btn btn-secondary" href="<?php echo site_url('investments'); ?>"><?php echo t('cancel'); ?></a>
		</div>
	<?php echo form_close(); ?>
</div>
