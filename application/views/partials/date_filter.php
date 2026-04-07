<?php defined('BASEPATH') OR exit('No direct script access allowed');
$f = $filter_meta['filter'];
$fd = $filter_meta['fd'];
$fm = (int) $filter_meta['fm'];
$fy = (int) $filter_meta['fy'];
$y_min = (int) date('Y') - 15;
$y_max = (int) date('Y') + 1;
?>
<div class="date-filter-card card border-0 shadow-sm mb-4">
	<div class="card-body py-3">
		<div class="small text-muted fw-semibold text-uppercase mb-2" style="letter-spacing: .06em;">তারিখ অনুযায়ী ফিল্টার</div>
		<?php echo form_open($form_action, array('method' => 'get', 'class' => 'row g-2 g-md-3 align-items-end', 'id' => 'cowDateFilterForm')); ?>
			<div class="col-12 col-sm-auto">
				<label class="form-label small mb-1" for="cowFilterMode">ধরন</label>
				<select name="filter" class="form-select form-select-sm" id="cowFilterMode" aria-label="ফিল্টার ধরন">
					<option value="all" <?php echo $f === 'all' ? 'selected' : ''; ?>>সব তারিখ</option>
					<option value="day" <?php echo $f === 'day' ? 'selected' : ''; ?>>নির্দিষ্ট দিন</option>
					<option value="month" <?php echo $f === 'month' ? 'selected' : ''; ?>>নির্দিষ্ট মাস</option>
					<option value="year" <?php echo $f === 'year' ? 'selected' : ''; ?>>নির্দিষ্ট বছর</option>
				</select>
			</div>
			<div class="col-12 col-sm-auto cow-fl-day <?php echo $f === 'day' ? '' : 'd-none'; ?>">
				<label class="form-label small mb-1" for="cowFd">দিন</label>
				<input type="date" class="form-control form-control-sm" name="fd" id="cowFd" value="<?php echo html_escape($fd); ?>">
			</div>
			<div class="col-6 col-sm-auto cow-fl-fm <?php echo $f === 'month' ? '' : 'd-none'; ?>">
				<label class="form-label small mb-1" for="cowFm">মাস</label>
				<select name="fm" class="form-select form-select-sm" id="cowFm">
					<?php for ($m = 1; $m <= 12; $m++): ?>
						<option value="<?php echo $m; ?>" <?php echo $fm === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="col-6 col-sm-auto cow-fl-fy <?php echo ($f === 'month' || $f === 'year') ? '' : 'd-none'; ?>">
				<label class="form-label small mb-1" for="cowFy">বছর</label>
				<select name="fy" class="form-select form-select-sm" id="cowFy">
					<?php for ($y = $y_max; $y >= $y_min; $y--): ?>
						<option value="<?php echo $y; ?>" <?php echo $fy === $y ? 'selected' : ''; ?>><?php echo $y; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="col-12 col-sm-auto d-flex flex-wrap gap-2">
				<button type="submit" class="btn btn-success btn-sm btn-add">প্রয়োগ</button>
				<a class="btn btn-outline-secondary btn-sm" href="<?php echo html_escape($form_action); ?>">রিসেট</a>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
(function(){
	var mode = document.getElementById('cowFilterMode');
	if (!mode) return;
	function sync(){
		var v = mode.value;
		var d = document.querySelector('.cow-fl-day');
		var fm = document.querySelector('.cow-fl-fm');
		var fy = document.querySelector('.cow-fl-fy');
		if (d) d.classList.toggle('d-none', v !== 'day');
		if (fm) fm.classList.toggle('d-none', v !== 'month');
		if (fy) fy.classList.toggle('d-none', v !== 'month' && v !== 'year');
	}
	mode.addEventListener('change', sync);
})();
</script>
