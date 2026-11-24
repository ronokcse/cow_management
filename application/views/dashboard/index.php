<?php defined('BASEPATH') OR exit('No direct script access allowed');
$lang = cow_lang();
$f = $filter_meta['filter'];
$now_y = (int) date('Y');
$now_m = (int) date('n');
$is_today_active = ($f === 'day' && $filter_meta['fd'] === $today);
$is_month_active = ($f === 'month' && (int) $filter_meta['fm'] === $now_m && (int) $filter_meta['fy'] === $now_y);
$is_year_active = ($f === 'year' && (int) $filter_meta['fy'] === $now_y);
?>

<!-- Clean Compact Dashboard Header & Period Switcher -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
	<div>
		<h1 class="page-title mb-1"><?php echo t('dashboard'); ?></h1>
		<div class="small text-muted d-flex align-items-center gap-2">
			<span><i class="bi bi-calendar3 me-1"></i><?php echo html_escape($today); ?></span>
			<span>&middot;</span>
			<span class="fw-semibold text-dark"><?php echo html_escape($filter_meta['label']); ?></span>
		</div>
	</div>

	<div class="d-flex flex-wrap align-items-center gap-2 no-print">
		<div class="dash-seg-control">
			<a href="<?php echo site_url('dashboard?filter=all'); ?>" class="seg-item <?php echo $f === 'all' ? 'active' : ''; ?>"><?php echo $lang === 'en' ? 'All' : 'সব'; ?></a>
			<a href="<?php echo site_url('dashboard?filter=day&fd='.$today); ?>" class="seg-item <?php echo $is_today_active ? 'active' : ''; ?>"><?php echo $lang === 'en' ? 'Today' : 'আজ'; ?></a>
			<a href="<?php echo site_url('dashboard?filter=month&fm='.$now_m.'&fy='.$now_y); ?>" class="seg-item <?php echo $is_month_active ? 'active' : ''; ?>"><?php echo $lang === 'en' ? 'Month' : 'মাস'; ?></a>
			<a href="<?php echo site_url('dashboard?filter=year&fy='.$now_y); ?>" class="seg-item <?php echo $is_year_active ? 'active' : ''; ?>"><?php echo $lang === 'en' ? 'Year' : 'বছর'; ?></a>
		</div>
		<button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#dashCustomFilterCollapse" aria-expanded="false" title="<?php echo t('filter_by_date'); ?>">
			<i class="bi bi-sliders"></i>
		</button>
		<button type="button" onclick="window.print()" class="btn btn-sm btn-outline-secondary" title="<?php echo t('print_report'); ?>">
			<i class="bi bi-printer"></i>
		</button>
	</div>
</div>

<div class="collapse mb-4 no-print" id="dashCustomFilterCollapse">
	<?php $this->load->view('partials/date_filter', compact('filter_meta', 'form_action')); ?>
</div>

<!-- Clean 6 KPI Cards -->
<div class="row g-3 mb-4">
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
		<div class="card stat-card stat-card--ops h-100">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label"><?php echo t('total_ops_expense'); ?></div>
					<div class="stat-value">৳ <?php echo money_fmt($total_expense_ops); ?></div>
				</div>
				<div class="stat-icon"><i class="bi bi-calculator"></i></div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-4">
		<div class="card stat-card stat-card--net h-100 <?php echo $net_profit >= 0 ? 'stat-card--profit' : 'stat-card--loss'; ?>">
			<div class="card-body d-flex align-items-center justify-content-between">
				<div>
					<div class="stat-label d-flex align-items-center gap-2">
						<span><?php echo t('net_profit_loss'); ?></span>
						<span class="badge rounded-pill <?php echo $net_profit >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>" style="font-size:0.65rem;">
							<?php echo $net_profit >= 0 ? ($lang === 'en' ? 'Profit' : 'লাভ') : ($lang === 'en' ? 'Loss' : 'ঘাটতি'); ?>
						</span>
					</div>
					<div class="stat-value">৳ <?php echo money_fmt($net_profit); ?></div>
				</div>
				<div class="stat-icon">
					<i class="bi <?php echo $net_profit >= 0 ? 'bi-graph-up-arrow' : 'bi-graph-down-arrow'; ?>"></i>
				</div>
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
				<div class="stat-icon"><i class="bi bi-bag-check"></i></div>
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
				<div class="stat-icon"><i class="bi bi-receipt"></i></div>
			</div>
		</div>
	</div>

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
</div>

<!-- Feed Stock Table -->
<div class="section-head">
	<div class="section-head-left">
		<span class="section-dot" aria-hidden="true"></span>
		<h2><?php echo t('feed_stock_title'); ?></h2>
	</div>
	<a href="<?php echo site_url('food_types'); ?>" class="small text-decoration-none fw-semibold no-print" style="color:var(--brand);"><?php echo t('food_types'); ?> &rarr;</a>
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
							$badge = 'bg-danger-subtle text-danger';
							$lbl = t('out_of_stock');
						} elseif ($stk < 25) {
							$badge = 'bg-warning-subtle text-warning-emphasis';
							$lbl = t('low_stock');
						} else {
							$badge = 'bg-success-subtle text-success';
							$lbl = t('in_stock');
						}
					?>
						<tr>
							<td class="fw-semibold"><?php echo html_escape($st->name); ?></td>
							<td class="text-end text-muted"><?php echo money_fmt($st->purchased_kg); ?></td>
							<td class="text-end text-muted"><?php echo money_fmt($st->consumed_kg); ?></td>
							<td class="text-end fw-bold <?php echo $stk <= 0 ? 'text-danger' : 'text-dark'; ?>"><?php echo money_fmt($stk); ?> KG</td>
							<td class="text-center"><span class="badge rounded-pill <?php echo $badge; ?>"><?php echo $lbl; ?></span></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Today Feeding & Last 30 Days -->
<div class="row g-4 mb-4">
	<div class="col-lg-6">
		<div class="section-head">
			<div class="section-head-left">
				<span class="section-dot" aria-hidden="true"></span>
				<h2><?php echo t('today_feeding'); ?></h2>
			</div>
			<span class="small text-muted fw-semibold"><?php echo money_fmt($today_total_kg); ?> KG</span>
		</div>
		<div class="table-wrap">
			<table class="table table-hover mb-0">
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
			<table class="table table-hover mb-0">
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

<!-- Recent Feeding & Recent Incomes/Expenses -->
<div class="row g-4">
	<div class="col-lg-7">
		<div class="section-head">
			<div class="section-head-left">
				<span class="section-dot" aria-hidden="true"></span>
				<h2><?php echo t('recent_feeding_entries'); ?></h2>
			</div>
			<a href="<?php echo site_url('daily_feeding'); ?>" class="small text-decoration-none fw-semibold no-print" style="color:var(--brand);"><?php echo t('daily_feeding'); ?> &rarr;</a>
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
									<td class="text-muted small"><?php echo html_escape($r->feeding_date); ?></td>
									<td class="fw-medium"><?php echo html_escape($r->food_type_name); ?></td>
									<td class="text-end fw-semibold"><?php echo money_fmt($r->quantity_kg); ?></td>
									<td class="text-muted small"><?php echo $r->notes ? html_escape($r->notes) : '—'; ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-lg-5">
		<div class="section-head">
			<div class="section-head-left">
				<span class="section-dot" aria-hidden="true"></span>
				<h2><?php echo $lang === 'en' ? 'Recent Incomes & Expenses' : 'সাম্প্রতিক আয় ও খরচ'; ?></h2>
			</div>
			<a href="<?php echo site_url('incomes'); ?>" class="small text-decoration-none fw-semibold no-print" style="color:var(--brand);"><?php echo t('incomes'); ?> &rarr;</a>
		</div>
		<div class="table-wrap">
			<div class="table-responsive">
				<table class="table table-hover mb-0">
					<thead>
						<tr>
							<th><?php echo t('date'); ?></th>
							<th><?php echo t('description'); ?></th>
							<th class="text-end"><?php echo t('amount'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($recent_transactions)): ?>
							<tr><td colspan="3" class="text-muted py-4 text-center"><?php echo t('no_data'); ?></td></tr>
						<?php else: ?>
							<?php foreach ($recent_transactions as $tx): ?>
								<tr>
									<td class="small text-muted"><?php echo html_escape($tx->date); ?></td>
									<td class="small fw-medium"><?php echo html_escape($tx->description); ?></td>
									<?php if ($tx->type === 'income'): ?>
										<td class="text-end fw-bold text-success">+৳ <?php echo money_fmt($tx->amount); ?></td>
									<?php else: ?>
										<td class="text-end fw-semibold text-danger">−৳ <?php echo money_fmt($tx->amount); ?></td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
