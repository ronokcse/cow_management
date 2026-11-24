<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-toolbar">
	<h1 class="page-title"><?php echo t('daily_feeding'); ?></h1>
	<div class="d-flex gap-2">
		<button type="button" onclick="window.print()" class="btn btn-outline-secondary"><i class="bi bi-printer me-1"></i><?php echo t('print_report'); ?></button>
		<a class="btn btn-success btn-add" href="<?php echo site_url('daily_feeding/add'); ?>"><i class="bi bi-plus-lg me-1"></i><?php echo t('add_new'); ?></a>
	</div>
</div>
<?php $this->load->view('partials/date_filter', compact('filter_meta', 'form_action')); ?>
<div class="filter-summary px-3 py-2 mb-3 small shadow-sm d-flex flex-wrap justify-content-between align-items-center gap-2">
	<div>
		<span class="text-muted"><?php echo t('active_filter'); ?>:</span> <strong><?php echo html_escape($filter_meta['label']); ?></strong>
		<span class="text-muted mx-2">|</span>
		<span class="text-muted"><?php echo t('records_count'); ?>:</span> <strong><?php echo count($rows); ?></strong>
	</div>
	<div>
		<span class="text-muted"><?php echo t('total_kg'); ?>:</span> <strong class="text-dark fs-6"><?php echo money_fmt($filter_sum); ?> KG</strong>
	</div>
</div>
<div class="table-wrap">
	<div class="table-responsive">
		<table class="table table-hover mb-0 <?php echo ! empty($rows) ? 'cow-datatable' : ''; ?>">
			<thead>
				<tr>
					<th><?php echo t('date'); ?></th>
					<th><?php echo t('type'); ?></th>
					<th class="text-end"><?php echo t('kg'); ?></th>
					<th><?php echo t('notes'); ?></th>
					<th class="text-end no-print" style="width:160px"><?php echo t('actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($rows)): ?>
					<tr><td colspan="5" class="text-muted text-center py-4"><?php echo t('no_data'); ?></td></tr>
				<?php else: ?>
					<?php foreach ($rows as $r): ?>
						<tr>
							<td><?php echo html_escape($r->feeding_date); ?></td>
							<td class="fw-semibold"><?php echo html_escape($r->food_type_name); ?></td>
							<td class="text-end fw-semibold"><?php echo money_fmt($r->quantity_kg); ?></td>
							<td><?php echo $r->notes ? html_escape($r->notes) : '—'; ?></td>
							<td class="text-end no-print">
								<div class="d-inline-flex flex-nowrap gap-1 justify-content-end">
									<a class="btn btn-sm btn-outline-primary" href="<?php echo site_url('daily_feeding/edit/'.$r->id); ?>"><i class="bi bi-pencil"></i> <?php echo t('edit'); ?></a>
									<a class="btn btn-sm btn-outline-danger" href="<?php echo site_url('daily_feeding/delete/'.$r->id); ?>" onclick="return confirm('<?php echo t('confirm_delete'); ?>');"><i class="bi bi-trash"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
