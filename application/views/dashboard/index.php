<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="dash-hero">
	<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 position-relative" style="z-index:1;">
		<div>
			<h1><?php echo t('dash_hero_title'); ?></h1>
			<p><?php echo t('dash_hero_sub'); ?></p>
		</div>
		<div class="quick-actions">
			<a href="<?php echo site_url('daily_feeding/add'); ?>" class="quick-btn"><i class="bi bi-plus-circle"></i> <?php echo t('quick_add_feed'); ?></a>
			<a href="<?php echo site_url('food_purchases/add'); ?>" class="quick-btn"><i class="bi bi-bag-plus"></i> <?php echo t('quick_buy_feed'); ?></a>
			<a href="<?php echo site_url('incomes/add'); ?>" class="quick-btn"><i class="bi bi-graph-up-arrow"></i> <?php echo t('quick_add_income'); ?></a>
			<a href="<?php echo site_url('other_expenses/add'); ?>" class="quick-btn"><i class="bi bi-receipt"></i> <?php echo t('quick_add_expense'); ?></a>
		</div>
	</div>
</div>

<?php $this->load->view('partials/date_filter', compact('filter_meta', 'form_action')); ?>

<div class="filter-summary px-3 py-2 mb-3 small shadow-sm d-flex flex-wrap justify-content-between align-items-center gap-2">
	<div>
		<span class="text-muted"><?php echo t('active_filter'); ?>:</span>
		<strong class="text-dark"><?php echo html_escape($filter_meta['label']); ?></strong>
	</div>
	<button type="button" onclick="window.print()" class="btn btn-sm btn-outline-secondary no-print">
		<i class="bi bi-printer me-1"></i><?php echo t('print_report'); ?>
	</button>
</div>

<div class="row g-3 stat-grid">
	<div class="col-sm-6 col-xl-4">
		<div class="card stat-card stat-card--invest h-100">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label"><?php echo t('total_investment'); ?></div>
					<div class="stat-value">৳ <?php echo money_fmt($total_investment); ?></div>
				</div>
				<div class="stat-icon"><i class="bi bi-bank2"></i></div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-4">
		<div class="card stat-card stat-card--food h-100">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label"><?php echo t('total_food_cost'); ?></div>
					<div class="stat-value">৳ <?php echo money_fmt($total_food_cost); ?></div>
				</div>
				<div class="stat-icon"><i class="bi bi-bag-check-fill"></i></div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-4">
		<div class="card stat-card stat-card--other h-100">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label"><?php echo t('total_other_cost'); ?></div>
					<div class="stat-value">৳ <?php echo money_fmt($total_other); ?></div>
				</div>
				<div class="stat-icon"><i class="bi bi-receipt-cutoff"></i></div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-4">
		<div class="card stat-card stat-card--ops h-100">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label"><?php echo t('total_ops_expense'); ?></div>
					<div class="stat-value">৳ <?php echo money_fmt($total_expense_ops); ?></div>
					<div class="small text-muted mt-1"><?php echo t('ops_formula'); ?></div>
				</div>
				<div class="stat-icon"><i class="bi bi-calculator-fill"></i></div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-4">
		<div class="card stat-card stat-card--income h-100">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label"><?php echo t('total_income'); ?></div>
					<div class="stat-value">৳ <?php echo money_fmt($total_income); ?></div>
				</div>
				<div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-4">
		<div class="card stat-card stat-card--net h-100 <?php echo $net_profit >= 0 ? 'stat-card--profit' : 'stat-card--loss'; ?>">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label"><?php echo t('net_profit_loss'); ?></div>
					<div class="stat-value">৳ <?php echo money_fmt($net_profit); ?></div>
					<div class="small text-muted mt-1"><?php echo t('profit_formula'); ?></div>
				</div>
				<div class="stat-icon">
					<i class="bi <?php echo $net_profit >= 0 ? 'bi-graph-up-arrow' : 'bi-graph-down-arrow'; ?>"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Feed Inventory / Stock Summary -->
<div class="section-head">
	<div class="section-head-left">
		<span class="section-dot" aria-hidden="true"></span>
		<h2><?php echo t('feed_stock_title'); ?></h2>
	</div>
	<a href="<?php echo site_url('food_types'); ?>" class="btn btn-sm btn-outline-secondary no-print"><?php echo t('food_types'); ?> &rarr;</a>
</div>
<div class="table-wrap mb-4">
	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead>
				<tr>
					<th><?php echo t('type'); ?></th>
					<th class="text-end"><?php echo t('purchased_kg'); ?></th>
					<th class="text-end"><?php echo t('consumed_kg'); ?></th>
					<th class="text-end"><?php echo t('stock_kg'); ?></th>
					<th class="text-center"><?php echo t('status'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($stock_summary)): ?>
					<tr><td colspan="5" class="text-muted py-4 text-center"><?php echo t('no_data'); ?></td></tr>
				<?php else: ?>
					<?php foreach ($stock_summary as $st):
						$stk = (float) $st->stock_kg;
						if ($stk <= 0) {
							$badge = 'bg-danger-subtle text-danger border border-danger-subtle';
							$lbl = t('out_of_stock');
						} elseif ($stk < 25) {
							$badge = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
							$lbl = t('low_stock');
						} else {
							$badge = 'bg-success-subtle text-success border border-success-subtle';
							$lbl = t('in_stock');
						}
					?>
						<tr>
							<td class="fw-semibold"><?php echo html_escape($st->name); ?></td>
							<td class="text-end"><?php echo money_fmt($st->purchased_kg); ?></td>
							<td class="text-end"><?php echo money_fmt($st->consumed_kg); ?></td>
							<td class="text-end fw-bold <?php echo $stk <= 0 ? 'text-danger' : 'text-dark'; ?>"><?php echo money_fmt($stk); ?></td>
							<td class="text-center"><span class="badge rounded-pill <?php echo $badge; ?>"><?php echo $lbl; ?></span></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row g-4">
	<div class="col-lg-6">
		<div class="section-head">
			<div class="section-head-left">
				<span class="section-dot" aria-hidden="true"></span>
				<h2><?php echo t('today_feeding'); ?> (<?php echo html_escape($today); ?>)</h2>
			</div>
		</div>
		<div class="table-wrap">
			<table class="table table-sm table-striped mb-0">
				<thead>
					<tr>
						<th><?php echo t('type'); ?></th>
						<th class="text-end"><?php echo t('kg'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($today_rows)): ?>
						<tr><td colspan="2" class="text-muted py-4 text-center"><?php echo t('no_today_entry'); ?></td></tr>
					<?php else: ?>
						<?php foreach ($today_rows as $r): ?>
							<tr>
								<td><?php echo html_escape($r->food_type_name); ?></td>
								<td class="text-end fw-semibold"><?php echo money_fmt($r->quantity_kg); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="section-head">
			<div class="section-head-left">
				<span class="section-dot" aria-hidden="true"></span>
				<h2><?php echo t('last_30_days_feed'); ?></h2>
			</div>
		</div>
		<div class="table-wrap">
			<table class="table table-sm table-striped mb-0">
				<thead>
					<tr>
						<th><?php echo t('type'); ?></th>
						<th class="text-end"><?php echo t('total_kg'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($consumption_30d)): ?>
						<tr><td colspan="2" class="text-muted py-4 text-center"><?php echo t('no_data'); ?></td></tr>
					<?php else: ?>
						<?php foreach ($consumption_30d as $r): ?>
							<tr>
								<td><?php echo html_escape($r->food_type_name); ?></td>
								<td class="text-end fw-semibold"><?php echo money_fmt($r->total_kg); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="section-head mt-4">
	<div class="section-head-left">
		<span class="section-dot" aria-hidden="true"></span>
		<h2><?php echo t('recent_feeding_entries'); ?></h2>
	</div>
	<a href="<?php echo site_url('daily_feeding'); ?>" class="btn btn-sm btn-outline-secondary no-print"><?php echo t('daily_feeding'); ?> &rarr;</a>
</div>
<div class="table-wrap">
	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead>
				<tr>
					<th><?php echo t('date'); ?></th>
					<th><?php echo t('type'); ?></th>
					<th class="text-end"><?php echo t('kg'); ?></th>
					<th><?php echo t('notes'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($recent_feeding)): ?>
					<tr><td colspan="4" class="text-muted py-4 text-center"><?php echo t('no_data'); ?></td></tr>
				<?php else: ?>
					<?php foreach ($recent_feeding as $r): ?>
						<tr>
							<td><?php echo html_escape($r->feeding_date); ?></td>
							<td class="fw-medium"><?php echo html_escape($r->food_type_name); ?></td>
							<td class="text-end fw-semibold"><?php echo money_fmt($r->quantity_kg); ?></td>
							<td class="text-muted"><?php echo $r->notes ? html_escape($r->notes) : '—'; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
