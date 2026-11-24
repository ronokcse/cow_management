<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-toolbar">
	<h1 class="page-title"><?php echo t('food_types'); ?></h1>
	<div class="d-flex gap-2">
		<button type="button" onclick="window.print()" class="btn btn-outline-secondary"><i class="bi bi-printer me-1"></i><?php echo t('print_report'); ?></button>
		<a class="btn btn-success btn-add" href="<?php echo site_url('food_types/add'); ?>"><i class="bi bi-plus-lg me-1"></i><?php echo t('add_new'); ?></a>
	</div>
</div>
<div class="table-wrap">
	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead>
				<tr>
					<th><?php echo t('name'); ?></th>
					<th class="text-end"><?php echo t('purchased_kg'); ?></th>
					<th class="text-end"><?php echo t('consumed_kg'); ?></th>
					<th class="text-end"><?php echo t('stock_kg'); ?></th>
					<th class="text-end"><?php echo t('sort_order'); ?></th>
					<th class="text-end no-print" style="width:160px"><?php echo t('actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($rows)): ?>
					<tr><td colspan="6" class="text-muted text-center py-4"><?php echo t('no_data'); ?></td></tr>
				<?php else: ?>
					<?php foreach ($rows as $r):
						$stk = isset($r->stock_kg) ? (float) $r->stock_kg : 0.0;
					?>
						<tr>
							<td class="fw-semibold"><?php echo html_escape($r->name); ?></td>
							<td class="text-end"><?php echo money_fmt(isset($r->purchased_kg) ? $r->purchased_kg : 0); ?></td>
							<td class="text-end"><?php echo money_fmt(isset($r->consumed_kg) ? $r->consumed_kg : 0); ?></td>
							<td class="text-end fw-bold <?php echo $stk <= 0 ? 'text-danger' : 'text-success'; ?>"><?php echo money_fmt($stk); ?></td>
							<td class="text-end text-muted"><?php echo (int) $r->sort_order; ?></td>
							<td class="text-end no-print">
								<div class="d-inline-flex flex-nowrap gap-1 justify-content-end">
									<a class="btn btn-sm btn-outline-primary" href="<?php echo site_url('food_types/edit/'.$r->id); ?>"><i class="bi bi-pencil"></i> <?php echo t('edit'); ?></a>
									<a class="btn btn-sm btn-outline-danger" href="<?php echo site_url('food_types/delete/'.$r->id); ?>" onclick="return confirm('<?php echo t('confirm_delete'); ?>');"><i class="bi bi-trash"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
