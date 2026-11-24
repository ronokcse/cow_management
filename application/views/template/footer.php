<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			</div>
		</main>
		<footer class="app-footer d-flex flex-wrap justify-content-between align-items-center gap-2">
			<div>
				<strong><?php echo t('app_name'); ?></strong> &middot; <?php echo t('app_tagline'); ?>
			</div>
			<div>
				<a href="<?php echo base_url('docs/PROJEKT_GUIDE_BN.html'); ?>"><i class="bi bi-book me-1"></i><?php echo t('documentation'); ?></a>
			</div>
		</footer>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
(function(){
	var btn = document.getElementById('sidebarToggleBtn');
	var sb = document.getElementById('appSidebar');
	var bd = document.getElementById('sidebarBackdrop');
	if (btn && sb && bd) {
		btn.addEventListener('click', function(){
			sb.classList.toggle('show');
			bd.classList.toggle('show');
		});
		bd.addEventListener('click', function(){
			sb.classList.remove('show');
			bd.classList.remove('show');
		});
	}
})();
</script>
</body>
</html>
