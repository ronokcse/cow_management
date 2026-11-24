<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0d9488">
	<title>লগইন — গরু খামার হিসাব</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="<?php echo base_url('assets/css/theme.css'); ?>" rel="stylesheet">
</head>
<body class="d-flex align-items-center min-vh-100 py-4">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-sm-10 col-md-6 col-lg-4">
			<div class="card shadow-sm border-0">
				<div class="card-body p-4 p-md-5">
					<div class="text-center mb-4">
						<div class="fs-1 mb-2" aria-hidden="true">🐄</div>
						<h1 class="h4 fw-bold mb-1">গরু খামার হিসাব</h1>
						<p class="text-muted small mb-0">আপনার অ্যাকাউন্টে লগইন করুন</p>
					</div>

					<?php if ($this->session->flashdata('error')): ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?php echo $this->session->flashdata('error'); ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>

					<?php if ($this->session->flashdata('success')): ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?php echo $this->session->flashdata('success'); ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>

					<form method="post" action="<?php echo site_url('auth/login'); ?>">
						<div class="mb-3">
							<label for="username" class="form-label">ইউজারনেম</label>
							<input type="text" class="form-control" id="username" name="username" required autofocus placeholder="admin">
						</div>
						<div class="mb-4">
							<label for="password" class="form-label">পাসওয়ার্ড</label>
							<input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
						</div>
						<button type="submit" class="btn btn-primary w-100">লগইন করুন</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
