<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-toolbar mt-3">
	<h1 class="page-title mb-0">আয়</h1>
	<a class="btn btn-success btn-add" href="<?php echo site_url('incomes/add'); ?>">+ নতুন</a>
</div>
<div class="table-wrap">
	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead class="table-light">
				<tr>
					<th>তারিখ</th>
					<th class="text-end">টাকা</th>
					<th>বিবরণ</th>
					<th class="text-end" style="width:140px">কাজ</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($rows)): ?>
					<tr><td colspan="4" class="text-muted">কোনো আয় নেই।</td></tr>
				<?php else: ?>
					<?php foreach ($rows as $r): ?>
						<tr>
							<td><?php echo html_escape($r->income_date); ?></td>
							<td class="text-end">৳ <?php echo money_fmt($r->amount); ?></td>
							<td><?php echo $r->description ? html_escape($r->description) : '—'; ?></td>
							<td class="text-end">
								<div class="d-inline-flex flex-nowrap gap-1 justify-content-end">
									<a class="btn btn-sm btn-outline-primary" href="<?php echo site_url('incomes/edit/'.$r->id); ?>">সম্পাদনা</a>
									<a class="btn btn-sm btn-outline-danger" href="<?php echo site_url('incomes/delete/'.$r->id); ?>" onclick="return confirm('মুছে ফেলবেন?');">মুছুন</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
