<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
	<h1 class="h4 fw-bold mb-0">প্রোফাইল সেটিংস</h1>
</div>

<div class="row g-4">
	<div class="col-12 col-md-6">
		<div class="card shadow-sm border-0 h-100">
			<div class="card-body p-4">
				<h2 class="h5 fw-bold mb-3">নাম পরিবর্তন</h2>
				<form method="post" action="<?php echo site_url('profile/update_name'); ?>">
					<div class="mb-3">
						<label class="form-label">ইউজারনেম</label>
						<input type="text" class="form-control" value="<?php echo html_escape($user->username); ?>" disabled readonly>
					</div>
					<div class="mb-3">
						<label for="name" class="form-label">নাম</label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo html_escape($user->name); ?>" required>
					</div>
					<button type="submit" class="btn btn-primary">নাম আপডেট করুন</button>
				</form>
			</div>
		</div>
	</div>

	<div class="col-12 col-md-6">
		<div class="card shadow-sm border-0 h-100">
			<div class="card-body p-4">
				<h2 class="h5 fw-bold mb-3">পাসওয়ার্ড পরিবর্তন</h2>
				<form method="post" action="<?php echo site_url('profile/change_password'); ?>">
					<div class="mb-3">
						<label for="current_password" class="form-label">বর্তমান পাসওয়ার্ড</label>
						<input type="password" class="form-control" id="current_password" name="current_password" required>
					</div>
					<div class="mb-3">
						<label for="new_password" class="form-label">নতুন পাসওয়ার্ড</label>
						<input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
					</div>
					<div class="mb-3">
						<label for="confirm_password" class="form-label">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required>
					</div>
					<button type="submit" class="btn btn-warning">পাসওয়ার্ড পরিবর্তন করুন</button>
				</form>
			</div>
		</div>
	</div>
</div>
