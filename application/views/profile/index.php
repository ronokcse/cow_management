<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-toolbar">
	<h1 class="page-title"><?php echo t('profile'); ?></h1>
</div>

<div class="row g-4">
	<div class="col-12 col-md-6">
		<div class="card shadow-sm border-0 h-100" style="border-radius:var(--radius);">
			<div class="card-body p-4">
				<h2 class="h5 fw-bold mb-3"><i class="bi bi-person-badge text-success me-2"></i><?php echo t('change_name'); ?></h2>
				<form method="post" action="<?php echo site_url('profile/update_name'); ?>">
					<div class="mb-3">
						<label class="form-label"><?php echo t('username'); ?></label>
						<input type="text" class="form-control bg-light" value="<?php echo html_escape($user->username); ?>" disabled readonly>
					</div>
					<div class="mb-4">
						<label for="name" class="form-label"><?php echo t('name'); ?></label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo html_escape($user->name); ?>" required>
					</div>
					<button type="submit" class="btn btn-success btn-add"><i class="bi bi-check2-circle me-1"></i><?php echo t('update_name_btn'); ?></button>
				</form>
			</div>
		</div>
	</div>

	<div class="col-12 col-md-6">
		<div class="card shadow-sm border-0 h-100" style="border-radius:var(--radius);">
			<div class="card-body p-4">
				<h2 class="h5 fw-bold mb-3"><i class="bi bi-shield-lock text-warning me-2"></i><?php echo t('change_password'); ?></h2>
				<form method="post" action="<?php echo site_url('profile/change_password'); ?>">
					<div class="mb-3">
						<label for="current_password" class="form-label"><?php echo t('current_password'); ?></label>
						<input type="password" class="form-control" id="current_password" name="current_password" required>
					</div>
					<div class="mb-3">
						<label for="new_password" class="form-label"><?php echo t('new_password'); ?></label>
						<input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
					</div>
					<div class="mb-4">
						<label for="confirm_password" class="form-label"><?php echo t('confirm_password'); ?></label>
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required>
					</div>
					<button type="submit" class="btn btn-warning fw-semibold"><i class="bi bi-key me-1"></i><?php echo t('change_password_btn'); ?></button>
				</form>
			</div>
		</div>
	</div>
</div>
