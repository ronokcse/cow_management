<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-toolbar mt-3">
	<h1 class="page-title mb-0">খাদ্যের ধরন</h1>
	<a class="btn btn-success btn-add" href="<?php echo site_url('food_types/add'); ?>">+ নতুন</a>
</div>
<div class="table-wrap">
	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead class="table-light">
				<tr>
					<th>নাম</th>
					<th class="text-end">সাজানো</th>
					<th class="text-end" style="width:160px">কাজ</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($rows)): ?>
					<tr><td colspan="3" class="text-muted">কোনো ধরন নেই।</td></tr>
				<?php else: ?>
					<?php foreach ($rows as $r): ?>
						<tr>
							<td><?php echo html_escape($r->name); ?></td>
							<td class="text-end"><?php echo (int) $r->sort_order; ?></td>
							<td class="text-end">
								<div class="d-inline-flex flex-nowrap gap-1 justify-content-end">
									<a class="btn btn-sm btn-outline-primary" href="<?php echo site_url('food_types/edit/'.$r->id); ?>">সম্পাদনা</a>
									<a class="btn btn-sm btn-outline-danger" href="<?php echo site_url('food_types/delete/'.$r->id); ?>" onclick="return confirm('মুছে ফেলবেন?');">মুছুন</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
