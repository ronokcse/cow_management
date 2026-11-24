<?php defined('BASEPATH') OR exit('No direct script access allowed');
$lang = cow_lang();
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0d9488">
	<title><?php echo t('login'); ?> — <?php echo t('app_name'); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/theme.css'); ?>" rel="stylesheet">
</head>
<body class="auth-bg d-flex align-items-center min-vh-100 py-4">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
			<div class="d-flex justify-content-end mb-3">
				<div class="lang-switch shadow-sm">
					<a href="<?php echo site_url('language/switch_lang/bn'); ?>" class="<?php echo $lang === 'bn' ? 'active' : ''; ?>">বাংলা</a>
					<a href="<?php echo site_url('language/switch_lang/en'); ?>" class="<?php echo $lang === 'en' ? 'active' : ''; ?>">EN</a>
				</div>
			</div>
			<div class="card auth-card border-0">
				<div class="card-body p-4 p-md-5">
					<div class="text-center mb-4">
						<div class="brand-mark mx-auto mb-3" style="width:3.5rem;height:3.5rem;font-size:1.85rem;">🐄</div>
						<h1 class="h4 fw-bold mb-1"><?php echo t('app_name'); ?></h1>
						<p class="text-muted small mb-0"><?php echo t('login_sub'); ?></p>
					</div>

					<?php if ($this->session->flashdata('error')): ?>
						<div class="alert alert-danger alert-dismissible fade show small" role="alert">
							<i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $this->session->flashdata('error'); ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>

					<?php if ($this->session->flashdata('success')): ?>
						<div class="alert alert-success alert-dismissible fade show small" role="alert">
							<i class="bi bi-check-circle-fill me-1"></i><?php echo $this->session->flashdata('success'); ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>

					<form method="post" action="<?php echo site_url('auth/login'); ?>">
						<div class="mb-3">
							<label for="username" class="form-label"><?php echo t('username'); ?></label>
							<div class="input-group">
								<span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
								<input type="text" class="form-control" id="username" name="username" required autofocus placeholder="admin">
							</div>
						</div>
						<div class="mb-4">
							<label for="password" class="form-label"><?php echo t('password'); ?></label>
							<div class="input-group">
								<span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
								<input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-add w-100 py-2">
							<i class="bi bi-box-arrow-in-right me-1"></i> <?php echo t('login_btn'); ?>
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
