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
<?php $this->load->view('partials/chatbot'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
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

	if (window.jQuery && jQuery.fn.DataTable) {
		var isBn = <?php echo json_encode(cow_lang() !== 'en'); ?>;
		var langCfg = isBn ? {
			search: 'খুঁজুন:',
			searchPlaceholder: 'তারিখ, নাম বা বিবরণ লিখুন...',
			lengthMenu: '_MENU_ টি করে দেখান',
			info: 'মোট _TOTAL_টি রেকর্ডের মধ্যে _START_–_END_',
			infoEmpty: 'কোনো রেকর্ড নেই',
			infoFiltered: '(_MAX_টি থেকে ফিল্টারকৃত)',
			zeroRecords: 'কোনো মিল পাওয়া যায়নি',
			paginate: { previous: 'আগের', next: 'পরের' }
		} : {
			search: 'Search:',
			searchPlaceholder: 'Type to filter...',
			lengthMenu: 'Show _MENU_ entries',
			info: 'Showing _START_ to _END_ of _TOTAL_ entries',
			infoEmpty: 'No records',
			infoFiltered: '(filtered from _MAX_ total)',
			zeroRecords: 'No matching records found',
			paginate: { previous: 'Prev', next: 'Next' }
		};
		jQuery('.cow-datatable').DataTable({
			pageLength: 25,
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, isBn ? 'সব' : 'All']],
			order: [],
			columnDefs: [{ orderable: false, targets: -1 }],
			language: langCfg
		});
	}
})();
</script>
</body>
</html>
