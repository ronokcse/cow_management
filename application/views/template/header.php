<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$cur = strtolower((string) $CI->router->class);
$lang = cow_lang();
$user_name = $CI->session->userdata('user_name') ?: 'Admin';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0d9488">
	<title><?php echo isset($title) ? html_escape($title).' — ' : ''; ?><?php echo t('app_name'); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/theme.css'); ?>" rel="stylesheet">
</head>
<body>
<div class="app-shell">
	<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

	<!-- Sidebar -->
	<aside class="app-sidebar" id="appSidebar">
		<a class="sidebar-brand" href="<?php echo site_url('dashboard'); ?>">
			<span class="brand-mark" aria-hidden="true">🐄</span>
			<span class="brand-text-wrap">
				<span class="brand-title"><?php echo t('app_name'); ?></span>
				<span class="brand-sub"><?php echo $lang === 'en' ? 'Dairy & Cattle ERP' : 'ডেইরি ও ক্যাটল হিসাব'; ?></span>
			</span>
		</a>

		<nav class="sidebar-nav">
			<div class="sidebar-section-label"><?php echo t('nav_main'); ?></div>
			<a class="sidebar-link <?php echo $cur === 'dashboard' ? 'active' : ''; ?>" href="<?php echo site_url('dashboard'); ?>">
				<i class="bi bi-grid-1x2-fill"></i>
				<span><?php echo t('dashboard'); ?></span>
			</a>

			<div class="sidebar-section-label"><?php echo t('nav_feed'); ?></div>
			<a class="sidebar-link <?php echo $cur === 'daily_feeding' ? 'active' : ''; ?>" href="<?php echo site_url('daily_feeding'); ?>">
				<i class="bi bi-calendar2-check-fill"></i>
				<span><?php echo t('daily_feeding'); ?></span>
			</a>
			<a class="sidebar-link <?php echo $cur === 'food_purchases' ? 'active' : ''; ?>" href="<?php echo site_url('food_purchases'); ?>">
				<i class="bi bi-bag-plus-fill"></i>
				<span><?php echo t('food_purchases'); ?></span>
			</a>
			<a class="sidebar-link <?php echo $cur === 'food_types' ? 'active' : ''; ?>" href="<?php echo site_url('food_types'); ?>">
				<i class="bi bi-boxes"></i>
				<span><?php echo t('food_types'); ?></span>
			</a>

			<div class="sidebar-section-label"><?php echo t('nav_finance'); ?></div>
			<a class="sidebar-link <?php echo $cur === 'incomes' ? 'active' : ''; ?>" href="<?php echo site_url('incomes'); ?>">
				<i class="bi bi-graph-up-arrow"></i>
				<span><?php echo t('incomes'); ?></span>
			</a>
			<a class="sidebar-link <?php echo $cur === 'other_expenses' ? 'active' : ''; ?>" href="<?php echo site_url('other_expenses'); ?>">
				<i class="bi bi-receipt-cutoff"></i>
				<span><?php echo t('other_expenses'); ?></span>
			</a>
			<a class="sidebar-link <?php echo $cur === 'investments' ? 'active' : ''; ?>" href="<?php echo site_url('investments'); ?>">
				<i class="bi bi-bank2"></i>
				<span><?php echo t('investments'); ?></span>
			</a>

			<div class="sidebar-section-label"><?php echo t('nav_account'); ?></div>
			<a class="sidebar-link <?php echo $cur === 'profile' ? 'active' : ''; ?>" href="<?php echo site_url('profile'); ?>">
				<i class="bi bi-person-gear"></i>
				<span><?php echo t('profile'); ?></span>
			</a>
			<a class="sidebar-link text-danger-emphasis" href="<?php echo site_url('auth/logout'); ?>">
				<i class="bi bi-box-arrow-right text-danger"></i>
				<span><?php echo t('logout'); ?></span>
			</a>
		</nav>

		<div class="sidebar-footer small text-secondary d-flex align-items-center justify-content-between">
			<span><i class="bi bi-shield-check text-teal me-1"></i> <?php echo html_escape($user_name); ?></span>
			<span class="badge bg-dark border border-secondary text-uppercase"><?php echo $lang; ?></span>
		</div>
	</aside>

	<!-- Main Content Wrapper -->
	<div class="app-content-wrap">
		<header class="app-topbar">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" id="sidebarToggleBtn" aria-label="Menu">
					<i class="bi bi-list fs-5"></i>
				</button>
				<h2 class="topbar-title d-none d-sm-block"><?php echo isset($title) ? html_escape($title) : t('app_name'); ?></h2>
			</div>

			<div class="d-flex align-items-center gap-2 gap-md-3">
				<!-- Language Switcher -->
				<div class="lang-switch" title="Switch Language / ভাষা পরিবর্তন">
					<a href="<?php echo site_url('language/switch_lang/bn'); ?>" class="<?php echo $lang === 'bn' ? 'active' : ''; ?>">বাংলা</a>
					<a href="<?php echo site_url('language/switch_lang/en'); ?>" class="<?php echo $lang === 'en' ? 'active' : ''; ?>">EN</a>
				</div>

				<a href="<?php echo site_url('profile'); ?>" class="user-chip">
					<i class="bi bi-person-circle text-success"></i>
					<span class="d-none d-md-inline"><?php echo html_escape($user_name); ?></span>
				</a>

				<a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-sm btn-outline-danger" title="<?php echo t('logout'); ?>">
					<i class="bi bi-box-arrow-right"></i>
					<span class="d-none d-md-inline ms-1"><?php echo t('logout'); ?></span>
				</a>
			</div>
		</header>

		<main class="app-main">
			<div class="container-fluid px-0">
				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
						<i class="bi bi-check-circle-fill me-2"></i><?php echo $this->session->flashdata('success'); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>
				<?php if ($this->session->flashdata('error')): ?>
					<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
						<i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $this->session->flashdata('error'); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>
