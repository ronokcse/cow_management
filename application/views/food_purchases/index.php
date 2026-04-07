<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-toolbar mt-3">
	<h1 class="page-title mb-0">খাদ্য ক্রয়</h1>
	<a class="btn btn-success btn-add" href="<?php echo site_url('food_purchases/add'); ?>">+ নতুন</a>
</div>
<?php $this->load->view('partials/date_filter', compact('filter_meta', 'form_action')); ?>
<div class="filter-summary rounded-3 border bg-white px-3 py-2 mb-3 small shadow-sm">
	<span class="text-muted">ফিল্টার:</span> <strong><?php echo html_escape($filter_meta['label']); ?></strong>
	<span class="text-muted ms-2">|</span>
	<span class="text-muted ms-2">মোট ক্রয় (টাকা):</span> <strong class="text-dark">৳ <?php echo money_fmt($filter_sum); ?></strong>
</div>
<div class="table-wrap">
	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead class="table-light">
				<tr>
					<th>তারিখ</th>
					<th>ধরন</th>
					<th class="text-end">কেজি</th>
					<th class="text-end">মোট টাকা</th>
					<th>নোট</th>
					<th class="text-end" style="width:150px">কাজ</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($rows)): ?>
					<tr><td colspan="6" class="text-muted">কোনো ক্রয় নেই।</td></tr>
				<?php else: ?>
					<?php foreach ($rows as $r): ?>
						<tr>
							<td><?php echo html_escape($r->purchase_date); ?></td>
							<td><?php echo html_escape($r->food_type_name); ?></td>
							<td class="text-end"><?php echo money_fmt($r->quantity_kg); ?></td>
							<td class="text-end">৳ <?php echo money_fmt($r->total_amount); ?></td>
							<td><?php echo $r->notes ? html_escape($r->notes) : '—'; ?></td>
							<td class="text-end">
								<div class="d-inline-flex flex-nowrap gap-1 justify-content-end">
									<a class="btn btn-sm btn-outline-primary" href="<?php echo site_url('food_purchases/edit/'.$r->id); ?>">সম্পাদনা</a>
									<a class="btn btn-sm btn-outline-danger" href="<?php echo site_url('food_purchases/delete/'.$r->id); ?>" onclick="return confirm('মুছে ফেলবেন?');">মুছুন</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
