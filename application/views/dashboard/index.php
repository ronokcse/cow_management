<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="dash-hero mt-3">
	<h1>ড্যাশবোর্ড</h1>
	<p>খামারের সারাংশ, লাভ-ক্ষতি ও সাম্প্রতিক খাদ্য এন্ট্রি — এক নজরে।</p>
</div>

<div class="row g-3 stat-grid">
	<div class="col-md-6 col-xl-4">
		<div class="card stat-card stat-card--invest h-100">
			<div class="card-body">
				<div class="stat-icon" aria-hidden="true">📊</div>
				<div class="stat-label">মোট বিনিয়োগ</div>
				<div class="stat-value">৳ <?php echo money_fmt($total_investment); ?></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card stat-card stat-card--food h-100">
			<div class="card-body">
				<div class="stat-icon" aria-hidden="true">🌾</div>
				<div class="stat-label">মোট খাদ্য ক্রয় (টাকায়)</div>
				<div class="stat-value">৳ <?php echo money_fmt($total_food_cost); ?></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card stat-card stat-card--other h-100">
			<div class="card-body">
				<div class="stat-icon" aria-hidden="true">📋</div>
				<div class="stat-label">অন্যান্য খরচ</div>
				<div class="stat-value">৳ <?php echo money_fmt($total_other); ?></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card stat-card stat-card--income h-100">
			<div class="card-body">
				<div class="stat-icon" aria-hidden="true">💰</div>
				<div class="stat-label">মোট আয়</div>
				<div class="stat-value">৳ <?php echo money_fmt($total_income); ?></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card stat-card stat-card--net h-100 <?php echo $net_profit >= 0 ? 'stat-card--profit' : 'stat-card--loss'; ?>">
			<div class="card-body">
				<div class="stat-icon" aria-hidden="true"><?php echo $net_profit >= 0 ? '📈' : '📉'; ?></div>
				<div class="stat-label">নেট লাভ / ক্ষতি</div>
				<div class="stat-value">৳ <?php echo money_fmt($net_profit); ?></div>
				<div class="small mt-2" style="color: var(--text-muted); font-weight: 500;">সূত্র: আয় − (খাদ্য ক্রয় + অন্যান্য খরচ)</div>
			</div>
		</div>
	</div>
</div>

<div class="row g-4">
	<div class="col-lg-6">
		<div class="section-head">
			<span class="section-dot" aria-hidden="true"></span>
			<h2>আজকের খাদ্য (<?php echo html_escape($today); ?>)</h2>
		</div>
		<div class="table-wrap">
			<table class="table table-sm table-striped mb-0">
				<thead>
					<tr>
						<th>ধরন</th>
						<th class="text-end">কেজি</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($today_rows)): ?>
						<tr><td colspan="2" class="text-muted py-4 text-center">আজকের কোনো এন্ট্রি নেই।</td></tr>
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
			<span class="section-dot" aria-hidden="true"></span>
			<h2>গত ৩০ দিন — ধরন অনুযায়ী (কেজি)</h2>
		</div>
		<div class="table-wrap">
			<table class="table table-sm table-striped mb-0">
				<thead>
					<tr>
						<th>ধরন</th>
						<th class="text-end">মোট কেজি</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($consumption_30d)): ?>
						<tr><td colspan="2" class="text-muted py-4 text-center">কোনো ডেটা নেই।</td></tr>
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

<div class="section-head mt-5">
	<span class="section-dot" aria-hidden="true"></span>
	<h2>সাম্প্রতিক দৈনিক খাদ্য এন্ট্রি</h2>
</div>
<div class="table-wrap">
	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead>
				<tr>
					<th>তারিখ</th>
					<th>খাদ্যের ধরন</th>
					<th class="text-end">কেজি</th>
					<th>নোট</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($recent_feeding)): ?>
					<tr><td colspan="4" class="text-muted py-4 text-center">কোনো এন্ট্রি নেই। <a href="<?php echo site_url('daily_feeding/add'); ?>">এন্ট্রি যোগ করুন</a></td></tr>
				<?php else: ?>
					<?php foreach ($recent_feeding as $r): ?>
						<tr>
							<td><?php echo html_escape($r->feeding_date); ?></td>
							<td><?php echo html_escape($r->food_type_name); ?></td>
							<td class="text-end fw-semibold"><?php echo money_fmt($r->quantity_kg); ?></td>
							<td class="text-muted"><?php echo $r->notes ? html_escape($r->notes) : '—'; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
