<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$cur = strtolower((string) $CI->router->class);
?>
<!DOCTYPE html>
<html lang="bn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0d9488">
	<title><?php echo isset($title) ? html_escape($title).' — ' : ''; ?>গরু খামার হিসাব</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="<?php echo base_url('assets/css/theme.css'); ?>" rel="stylesheet">
</head>
<body>
<header class="app-header">
	<nav class="navbar navbar-expand-lg navbar-light">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo site_url('dashboard'); ?>">
				<span class="brand-mark" aria-hidden="true">🐄</span>
				<span>গরু খামার হিসাব</span>
			</a>
			<button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="মেনু">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navMain">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-1 align-items-lg-center">
					<li class="nav-item"><a class="nav-link <?php echo $cur === 'dashboard' ? 'active' : ''; ?>" href="<?php echo site_url('dashboard'); ?>">ড্যাশবোর্ড</a></li>
					<li class="nav-item"><a class="nav-link <?php echo $cur === 'investments' ? 'active' : ''; ?>" href="<?php echo site_url('investments'); ?>">বিনিয়োগ</a></li>
					<li class="nav-item"><a class="nav-link <?php echo $cur === 'food_types' ? 'active' : ''; ?>" href="<?php echo site_url('food_types'); ?>">খাদ্যের ধরন</a></li>
					<li class="nav-item"><a class="nav-link <?php echo $cur === 'food_purchases' ? 'active' : ''; ?>" href="<?php echo site_url('food_purchases'); ?>">খাদ্য ক্রয়</a></li>
					<li class="nav-item"><a class="nav-link <?php echo $cur === 'daily_feeding' ? 'active' : ''; ?>" href="<?php echo site_url('daily_feeding'); ?>">দৈনিক খাদ্য</a></li>
					<li class="nav-item"><a class="nav-link <?php echo $cur === 'incomes' ? 'active' : ''; ?>" href="<?php echo site_url('incomes'); ?>">আয়</a></li>
					<li class="nav-item"><a class="nav-link <?php echo $cur === 'other_expenses' ? 'active' : ''; ?>" href="<?php echo site_url('other_expenses'); ?>">অন্যান্য খরচ</a></li>
				</ul>
			</div>
		</div>
	</nav>
</header>
<main class="app-main">
<div class="container pb-5">
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
			<?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php endif; ?>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
			<?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php endif; ?>
