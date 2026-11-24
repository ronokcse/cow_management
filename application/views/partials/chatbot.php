<?php defined('BASEPATH') OR exit('No direct script access allowed');
$lang = cow_lang();

$categories = $lang === 'en'
	? array(
		array('icon' => '🥛', 'title' => 'Add Income', 'cmd' => 'Income'),
		array('icon' => '🌿', 'title' => 'Daily Feed', 'cmd' => 'Daily feed'),
		array('icon' => '🌾', 'title' => 'Buy Feed', 'cmd' => 'Feed purchase'),
		array('icon' => '💊', 'title' => 'Add Expense', 'cmd' => 'Expense'),
		array('icon' => '🐄', 'title' => 'Investment', 'cmd' => 'Investment'),
		array('icon' => '📊', 'title' => 'Summary', 'cmd' => 'summary'),
	)
	: array(
		array('icon' => '🥛', 'title' => 'আয় যোগ', 'cmd' => 'নতুন আয়'),
		array('icon' => '🌿', 'title' => 'দৈনিক খাদ্য', 'cmd' => 'দৈনিক খাদ্য'),
		array('icon' => '🌾', 'title' => 'খাদ্য ক্রয়', 'cmd' => 'খাদ্য ক্রয়'),
		array('icon' => '💊', 'title' => 'অন্যান্য খরচ', 'cmd' => 'অন্যান্য খরচ'),
		array('icon' => '🐄', 'title' => 'বিনিয়োগ', 'cmd' => 'নতুন বিনিয়োগ'),
		array('icon' => '📊', 'title' => 'হিসাব সারাংশ', 'cmd' => 'বর্তমান হিসাব'),
	);
?>
<!-- Floating Chatbot Trigger -->
<button type="button" class="cow-bot-fab no-print" id="cowBotFab" aria-label="<?php echo html_escape(t('bot_title')); ?>">
	<span class="cow-bot-fab-pulse"></span>
	<span class="cow-bot-fab-icon"><i class="bi bi-chat-dots-fill"></i></span>
	<span class="cow-bot-fab-label"><?php echo t('bot_title'); ?></span>
</button>

<!-- Floating Chatbot Panel -->
<div class="cow-bot-panel no-print" id="cowBotPanel" aria-hidden="true">
	<!-- Clean Minimal Header -->
	<div class="cow-bot-header">
		<div class="d-flex align-items-center gap-2">
			<div class="cow-bot-avatar">
				<span>🐄</span>
				<span class="cow-bot-online-dot"></span>
			</div>
			<div>
				<div class="cow-bot-title"><?php echo t('bot_title'); ?></div>
				<div class="cow-bot-sub"><?php echo $lang === 'en' ? 'Smart Farm Assistant' : 'সহজ ও দ্রুত হিসাব এন্ট্রি'; ?></div>
			</div>
		</div>
		<div class="d-flex align-items-center gap-1">
			<button type="button" class="cow-bot-hdr-btn cow-bot-hdr-btn--help" id="cowBotHelpBtn" data-bs-toggle="modal" data-bs-target="#cowBotHelpModal" title="<?php echo $lang === 'en' ? 'Usage Guide & Examples' : 'ব্যবহারের নিয়ম ও উদাহরণ'; ?>">
				<i class="bi bi-question-circle-fill"></i>
			</button>
			<button type="button" class="cow-bot-hdr-btn" id="cowBotExpand" title="<?php echo $lang === 'en' ? 'Expand / Collapse' : 'বড় / ছোট করুন'; ?>">
				<i class="bi bi-arrows-angle-expand"></i>
			</button>
			<button type="button" class="cow-bot-hdr-btn" id="cowBotClear" title="<?php echo $lang === 'en' ? 'Reset Chat' : 'নতুন করে শুরু করুন'; ?>">
				<i class="bi bi-arrow-counterclockwise"></i>
			</button>
			<button type="button" class="cow-bot-hdr-btn" id="cowBotClose" title="Close">
				<i class="bi bi-x-lg"></i>
			</button>
		</div>
	</div>

	<!-- Always-Visible Pinned Category Bar (Never scrolls away!) -->
	<div class="cow-bot-pinned-bar">
		<div class="cow-bot-cat-grid">
			<?php foreach ($categories as $cat): ?>
				<button type="button" class="cow-bot-cat-btn" data-cmd="<?php echo html_escape($cat['cmd']); ?>">
					<span class="cow-bot-cat-icon"><?php echo $cat['icon']; ?></span>
					<span class="cow-bot-cat-title"><?php echo html_escape($cat['title']); ?></span>
				</button>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- Scrollable Messages Body -->
	<div class="cow-bot-messages" id="cowBotMessages">
		<div class="cow-bot-msg cow-bot-msg--bot">
			<div class="cow-bot-bubble">
				<div class="cow-bot-text">
					<?php echo $lang === 'en'
						? '👋 Select any category from the pinned bar above, or type directly below:'
						: '👋 উপরের যেকোনো খাতে ক্লিক করুন অথবা নিচে সরাসরি লিখুন:'; ?>
				</div>
			</div>
		</div>
		<div id="cowBotThread"></div>
	</div>

	<!-- Single Clean Input Bar -->
	<form class="cow-bot-form" id="cowBotForm">
		<button type="button" class="cow-bot-mic" id="cowBotMic" title="<?php echo $lang === 'en' ? 'Voice Input' : 'মুখে বলুন'; ?>">
			<i class="bi bi-mic-fill"></i>
		</button>
		<input type="text" class="form-control cow-bot-input" id="cowBotInput" placeholder="<?php echo html_escape($lang === 'en' ? 'Type here (e.g. Milk sale 1500 tk)...' : 'এখানে লিখুন (যেমন: দুধ বিক্রি ১৫০০ টাকা)...'); ?>" autocomplete="off">
		<button type="submit" class="btn btn-success cow-bot-send" id="cowBotSend" title="<?php echo html_escape(t('bot_send')); ?>">
			<i class="bi bi-send-fill"></i>
		</button>
	</form>
</div>

<!-- Smart Assistant Usage Guide Modal -->
<div class="modal fade no-print" id="cowBotHelpModal" tabindex="-1" aria-labelledby="cowBotHelpModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content border-0 shadow-lg" style="border-radius: 1.15rem; overflow: hidden;">
			<div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0f172a 0%, #0f766e 100%);">
				<div class="d-flex align-items-center gap-2">
					<span class="fs-4">🐄</span>
					<div>
						<h5 class="modal-title fw-bold mb-0" id="cowBotHelpModalLabel">
							<?php echo $lang === 'en' ? 'Smart Farm Assistant — Usage Guide' : 'স্মার্ট খামার সহকারী — ব্যবহারের নিয়ম'; ?>
						</h5>
					</div>
				</div>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body p-4" style="background: #f8fafc;">
				<?php if ($lang === 'en'): ?>
					<div class="row g-3">
						<div class="col-md-6">
							<div class="p-3 bg-white rounded-3 border h-100 shadow-sm">
								<div class="fw-bold text-success mb-2"><i class="bi bi-1-circle-fill me-1"></i> Single Entry Examples (Bangla / Banglish / EN)</div>
								<ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
									<li>🐄 <strong>Investment:</strong><br><code>Bought cow 85000 tk</code> or <code>goru kinlam 85000 taka</code></li>
									<li>🌾 <strong>Feed Purchase:</strong><br><code>50 kg bran bought 2200 tk</code> or <code>25 kg vushi 1000 taka</code></li>
									<li>🌿 <strong>Daily Feeding:</strong><br><code>Fed 15 kg grass</code> or <code>15 kg ghas khawailam</code></li>
									<li>🥛 <strong>Income:</strong><br><code>Milk sale 1500 tk</code> or <code>dudh bikri 1500 taka</code></li>
									<li>💊 <strong>Other Expense:</strong><br><code>Medicine cost 500 tk</code> or <code>osudh khoroch 500 tk</code></li>
								</ul>
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 bg-white rounded-3 border h-100 shadow-sm">
								<div class="fw-bold text-primary mb-2"><i class="bi bi-2-circle-fill me-1"></i> Multi-Entry (+), Dates & Guided Mode</div>
								<ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
									<li>⚡ <strong>Multiple Entries at Once (use <code>+</code>, <code>,</code> or <code>and</code>):</strong><br>
										• <code>goru 80000 taka + 20 kg vushi 1000 taka</code><br>
										• <code>dudh bikri 1500 tk + 15 kg ghas khawailam + osudh 300 tk</code><br>
										• <code>goru 1000 taka + khabar 2000 taka</code> <em>(saves cow & asks feed details!)</em>
									</li>
									<li>📅 <strong>Any Date (Yesterday / Specific Date):</strong><br>
										• <code>kalke dudh bikri 1300 taka</code> (Yesterday)<br>
										• <code>20 tarikh 25 kg vushi kinsi 1000 taka</code> (20th of month)<br>
										• <code>3 din age osudh khoroch 500 tk</code> (3 days ago)
									</li>
									<li>👆 <strong>Step-by-Step Button Mode:</strong><br>
										Tap any of the 6 category buttons in the chat to select options or type custom amounts in the box inside the message.
									</li>
								</ul>
							</div>
						</div>
					</div>
				<?php else: ?>
					<div class="row g-3">
						<div class="col-md-6">
							<div class="p-3 bg-white rounded-3 border h-100 shadow-sm">
								<div class="fw-bold text-success mb-2"><i class="bi bi-1-circle-fill me-1"></i> এক লাইনে সরাসরি এন্ট্রি (বাংলা / বাংলিশ / ইংরেজি)</div>
								<ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
									<li>🐄 <strong>বিনিয়োগ (গরু কেনা, শেড, মূলধন):</strong><br>
										<code>গরু কিনলাম ৮৫০০০ টাকা</code> অথবা <code>goru kinlam 85000 taka</code>
									</li>
									<li>🌾 <strong>খাদ্য ক্রয় (কেজি + দাম):</strong><br>
										<code>৫০ কেজি ভুসি কিনলাম ২২০০ টাকা</code> অথবা <code>25 kg vushi 1000 taka</code>
									</li>
									<li>🌿 <strong>দৈনিক খাদ্য (শুধু কেজি):</strong><br>
										<code>১৫ কেজি ঘাস খাওয়ালাম</code> অথবা <code>15 kg ghas dilam</code>
									</li>
									<li>🥛 <strong>আয় (দুধ, গরু বা গোবর বিক্রি):</strong><br>
										<code>দুধ বিক্রি ১৫০০ টাকা</code> অথবা <code>dudh bikri 1500 tk</code>
									</li>
									<li>💊 <strong>অন্যান্য খরচ (ওষুধ, ডাক্তার, শ্রমিক, বিদ্যুৎ):</strong><br>
										<code>ওষুধ খরচ ৫০০ টাকা</code> অথবা <code>doctor khoroch 500 tk</code>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-6">
							<div class="p-3 bg-white rounded-3 border h-100 shadow-sm">
								<div class="fw-bold text-primary mb-2"><i class="bi bi-2-circle-fill me-1"></i> একসাথে একাধিক হিসাব (+), তারিখ ও বাটন মোড</div>
								<ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
									<li>⚡ <strong>এক মেসেজে একাধিক হিসাব (<code>+</code>, <code>,</code> বা <code>এবং</code> দিয়ে):</strong><br>
										• <code>গরু ৮০০০০ টাকা + ২০ কেজি ভুসি ১০০০ টাকা</code><br>
										• <code>দুধ বিক্রি ১৫০০ টাকা + ১৫ কেজি ঘাস খাওয়ালাম + ওষুধ ৩০০ টাকা</code><br>
										• <code>goru 1000 taka + khabar 2000 taka</code> <em>(প্রথমটি সেভ করে পরেরটির জন্য কোন খাবার ও কত কেজি তা জানতে চাইবে!)</em>
									</li>
									<li>📅 <strong>আগের যেকোনো তারিখের হিসাব:</strong><br>
										• <code>কালকে দুধ বিক্রি ১৩০০ টাকা</code> বা <code>dudh bikri kalke 1300 tk</code><br>
										• <code>২০ তারিখ ২৫ কেজি ভুসি কিনলাম ১০০০ টাকা</code> বা <code>20 tarikh...</code><br>
										• <code>পরশু ওষুধ খরচ ৫০০ টাকা</code> বা <code>3 din age osudh 500 tk</code>
									</li>
									<li>👆 <strong>বাটন ক্লিক মোড ও কাস্টম বক্স:</strong><br>
										চ্যাটবটের ৬টি বাটনের যেকোনোটিতে ক্লিক করলে ধাপে ধাপে অপশন আসবে এবং মেসেজের ভেতরের ছোট বক্সেই নিজের ইচ্ছামতো যেকোনো পরিমাণ লিখে টিক (✓) দেওয়া যাবে।
									</li>
								</ul>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="modal-footer bg-white border-top py-2 px-4">
				<button type="button" class="btn btn-success btn-sm px-3" data-bs-dismiss="modal">
					<?php echo $lang === 'en' ? 'Got It' : 'বুঝতে পেরেছি'; ?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
(function(){
	var fab = document.getElementById('cowBotFab');
	var panel = document.getElementById('cowBotPanel');
	var closeBtn = document.getElementById('cowBotClose');
	var clearBtn = document.getElementById('cowBotClear');
	var expandBtn = document.getElementById('cowBotExpand');
	var msgBox = document.getElementById('cowBotMessages');
	var thread = document.getElementById('cowBotThread');
	var form = document.getElementById('cowBotForm');
	var input = document.getElementById('cowBotInput');
	var micBtn = document.getElementById('cowBotMic');

	var chatEndpoint = <?php echo json_encode(site_url('assistant/chat')); ?>;
	var undoEndpoint = <?php echo json_encode(site_url('assistant/undo')); ?>;
	var updateEndpoint = <?php echo json_encode(site_url('assistant/update_record')); ?>;
	var resetEndpoint = <?php echo json_encode(site_url('assistant/reset')); ?>;
	var appLang = <?php echo json_encode($lang); ?>;
	var defaultPlaceholder = input ? input.getAttribute('placeholder') : '';
	var lblView = <?php echo json_encode(t('bot_view_record')); ?>;
	var lblEdit = <?php echo json_encode($lang === 'en' ? 'Edit' : 'এডিট'); ?>;
	var lblUndo = <?php echo json_encode($lang === 'en' ? 'Undo' : 'বাতিল (Undo)'); ?>;
	var lblSave = <?php echo json_encode($lang === 'en' ? 'Update' : 'আপডেট'); ?>;
	var lblCancel = <?php echo json_encode($lang === 'en' ? 'Cancel' : 'বন্ধ'); ?>;
	var storageKey = 'cow_bot_history_v4';

	if (!fab || !panel) return;

	function saveHistory() {
		try {
			sessionStorage.setItem(storageKey, thread.innerHTML);
		} catch (e) {}
	}

	function loadHistory() {
		try {
			var saved = sessionStorage.getItem(storageKey);
			if (saved) {
				thread.innerHTML = saved;
				bindDynamicButtons();
				msgBox.scrollTop = msgBox.scrollHeight;
			}
		} catch (e) {}
	}

	function openPanel() {
		panel.classList.add('open');
		panel.setAttribute('aria-hidden', 'false');
		msgBox.scrollTop = msgBox.scrollHeight;
		setTimeout(function(){ if (input) input.focus(); }, 100);
	}

	function closePanel() {
		panel.classList.remove('open');
		panel.setAttribute('aria-hidden', 'true');
	}

	fab.addEventListener('click', function(){
		if (panel.classList.contains('open')) closePanel();
		else openPanel();
	});

	if (closeBtn) closeBtn.addEventListener('click', closePanel);

	if (expandBtn) {
		expandBtn.addEventListener('click', function(){
			panel.classList.toggle('expanded');
			var ico = expandBtn.querySelector('i');
			if (ico) {
				ico.className = panel.classList.contains('expanded') ? 'bi bi-arrows-angle-contract' : 'bi bi-arrows-angle-expand';
			}
		});
	}

	document.addEventListener('keydown', function(e){
		if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
			e.preventDefault();
			if (panel.classList.contains('open')) closePanel();
			else openPanel();
		} else if (e.key === 'Escape' && panel.classList.contains('open')) {
			closePanel();
		}
	});

	if (clearBtn) {
		clearBtn.addEventListener('click', function(){
			thread.innerHTML = '';
			if (input) input.setAttribute('placeholder', defaultPlaceholder);
			try { sessionStorage.removeItem(storageKey); } catch (e) {}
			fetch(resetEndpoint, { method: 'POST' });
		});
	}

	function formatBotText(str) {
		var safe = String(str)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;');
		safe = safe.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
		safe = safe.replace(/`([^`]+)`/g, '<code class="cow-bot-code">$1</code>');
		safe = safe.replace(/\n/g, '<br>');
		return safe;
	}

	function appendMsg(role, htmlContent, extraActionsHtml) {
		var wrap = document.createElement('div');
		wrap.className = 'cow-bot-msg cow-bot-msg--' + role;

		var bubble = document.createElement('div');
		bubble.className = 'cow-bot-bubble';
		bubble.innerHTML = '<div class="cow-bot-text">' + htmlContent + '</div>' + (extraActionsHtml || '');

		wrap.appendChild(bubble);
		thread.appendChild(wrap);
		msgBox.scrollTop = msgBox.scrollHeight;
		saveHistory();
		bindDynamicButtons();
	}

	function bindDynamicButtons() {
		var btns = thread.querySelectorAll('.cow-undo-btn:not([data-bound])');
		for (var i = 0; i < btns.length; i++) {
			btns[i].setAttribute('data-bound', '1');
			btns[i].addEventListener('click', function(){
				var btn = this;
				var intent = btn.getAttribute('data-intent');
				var id = btn.getAttribute('data-id');
				btn.disabled = true;

				var body = new URLSearchParams();
				body.append('intent', intent);
				body.append('id', id);

				fetch(undoEndpoint, {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
					body: body.toString()
				})
				.then(function(r){ return r.json(); })
				.then(function(data){
					btn.remove();
					appendMsg('bot', formatBotText((data && data.reply) ? data.reply : 'Undone.'));
				});
			});
		}

		var optBtns = thread.querySelectorAll('.cow-opt-pill:not([data-bound])');
		for (var j = 0; j < optBtns.length; j++) {
			optBtns[j].setAttribute('data-bound', '1');
			optBtns[j].addEventListener('click', function(){
				var val = this.getAttribute('data-opt') || '';
				if (val) sendToBot(val);
			});
		}

		var inlineForms = thread.querySelectorAll('.cow-inline-val-form:not([data-bound])');
		for (var f = 0; f < inlineForms.length; f++) {
			inlineForms[f].setAttribute('data-bound', '1');
			inlineForms[f].addEventListener('submit', function(e){
				e.preventDefault();
				var inp = this.querySelector('.cow-inline-val-input');
				var unit = this.getAttribute('data-unit') || '';
				if (inp && inp.value.trim() !== '') {
					sendToBot(inp.value.trim() + (unit ? ' ' + unit : ''));
				}
			});
		}

		// In-Chat Edit Toggle Buttons
		var editBtns = thread.querySelectorAll('.cow-edit-toggle-btn:not([data-bound])');
		for (var eb = 0; eb < editBtns.length; eb++) {
			editBtns[eb].setAttribute('data-bound', '1');
			editBtns[eb].addEventListener('click', function(){
				var bubble = this.closest('.cow-bot-bubble');
				if (!bubble) return;
				var editBox = bubble.querySelector('.cow-inchat-edit-box');
				if (editBox) {
					editBox.classList.toggle('d-none');
					var firstInp = editBox.querySelector('input');
					if (firstInp && !editBox.classList.contains('d-none')) firstInp.focus();
				}
			});
		}

		// In-Chat Edit Cancel Buttons
		var cancelEditBtns = thread.querySelectorAll('.cow-edit-cancel-btn:not([data-bound])');
		for (var cb = 0; cb < cancelEditBtns.length; cb++) {
			cancelEditBtns[cb].setAttribute('data-bound', '1');
			cancelEditBtns[cb].addEventListener('click', function(){
				var editBox = this.closest('.cow-inchat-edit-box');
				if (editBox) editBox.classList.add('d-none');
			});
		}

		// In-Chat Edit Submit Forms
		var editForms = thread.querySelectorAll('.cow-inchat-edit-form:not([data-bound])');
		for (var ef = 0; ef < editForms.length; ef++) {
			editForms[ef].setAttribute('data-bound', '1');
			editForms[ef].addEventListener('submit', function(e){
				e.preventDefault();
				var formEl = this;
				var bubble = formEl.closest('.cow-bot-bubble');
				var editBox = formEl.closest('.cow-inchat-edit-box');
				var intent = formEl.getAttribute('data-intent');
				var id = formEl.getAttribute('data-id');
				var amtInp = formEl.querySelector('[name="amount"]');
				var kgInp = formEl.querySelector('[name="kg"]');
				var dateInp = formEl.querySelector('[name="date"]');
				var descInp = formEl.querySelector('[name="desc"]');

				var body = new URLSearchParams();
				body.append('intent', intent);
				body.append('id', id);
				if (amtInp) body.append('amount', amtInp.value);
				if (kgInp) body.append('kg', kgInp.value);
				if (dateInp) body.append('date', dateInp.value);
				if (descInp) body.append('desc', descInp.value);

				fetch(updateEndpoint, {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
					body: body.toString()
				})
				.then(function(r){ return r.json(); })
				.then(function(data){
					if (data && data.ok && bubble) {
						var txtEl = bubble.querySelector('.cow-bot-text');
						if (txtEl) txtEl.innerHTML = formatBotText(data.reply);
						if (editBox) editBox.classList.add('d-none');
						saveHistory();
					}
				});
			});
		}
	}

	function buildInChatEditBox(intent, recordId, fields) {
		if (!recordId || !fields) return '';
		var showKg = (intent === 'daily_feeding' || intent === 'food_purchase');
		var showAmt = (intent !== 'daily_feeding');
		var amtVal = fields.amount || '';
		var kgVal = fields.kg || '';
		var dateVal = fields.date || '';
		var descVal = String(fields.desc || '').replace(/"/g, '&quot;');

		var html = '<div class="cow-inchat-edit-box d-none mt-2 pt-2 border-top">'
			+ '<form class="cow-inchat-edit-form" data-intent="' + intent + '" data-id="' + recordId + '">'
			+ '<div class="row g-1 mb-1">';
		if (showKg) {
			html += '<div class="col-6"><label class="cow-edit-lbl">' + (appLang === 'en' ? 'KG' : 'কেজি') + '</label>'
				+ '<input type="number" step="any" min="0.01" name="kg" class="form-control form-control-sm" value="' + kgVal + '" required></div>';
		}
		if (showAmt) {
			html += '<div class="' + (showKg ? 'col-6' : 'col-6') + '"><label class="cow-edit-lbl">' + (appLang === 'en' ? 'Amount (৳)' : 'টাকা (৳)') + '</label>'
				+ '<input type="number" step="any" min="0.01" name="amount" class="form-control form-control-sm" value="' + amtVal + '" required></div>';
		}
		html += '<div class="' + (showKg && showAmt ? 'col-12' : 'col-6') + '"><label class="cow-edit-lbl">' + (appLang === 'en' ? 'Date' : 'তারিখ') + '</label>'
			+ '<input type="date" name="date" class="form-control form-control-sm" value="' + dateVal + '" required></div>'
			+ '<div class="col-12"><label class="cow-edit-lbl">' + (appLang === 'en' ? 'Description / Note' : 'বিবরণ / নোট') + '</label>'
			+ '<input type="text" name="desc" class="form-control form-control-sm" value="' + descVal + '"></div>'
			+ '</div>'
			+ '<div class="d-flex gap-1 mt-2">'
			+ '<button type="submit" class="btn btn-sm btn-success py-1 px-2" style="font-size:.74rem;"><i class="bi bi-check2 me-1"></i>' + lblSave + '</button>'
			+ '<button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 cow-edit-cancel-btn" style="font-size:.74rem;">' + lblCancel + '</button>'
			+ '</div>'
			+ '</form></div>';
		return html;
	}

	function sendToBot(text) {
		var trimmed = (text || '').trim();
		if (!trimmed) return;
		openPanel();
		appendMsg('user', formatBotText(trimmed));
		if (input) input.value = '';

		var body = new URLSearchParams();
		body.append('message', trimmed);

		fetch(chatEndpoint, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
			body: body.toString()
		})
		.then(function(r){ return r.json(); })
		.then(function(data){
			var actions = '';
			if (data && data.saved) {
				actions = '<div class="cow-bot-actions">'
					+ (data.url ? '<a href="' + data.url + '" class="cow-act-btn cow-act-btn--primary"><i class="bi bi-eye me-1"></i>' + lblView + '</a>' : '')
					+ (data.record_id && data.fields ? '<button type="button" class="cow-act-btn cow-edit-toggle-btn"><i class="bi bi-pencil-square me-1"></i>' + lblEdit + '</button>' : '')
					+ (data.record_id ? '<button type="button" class="cow-act-btn cow-act-btn--danger cow-undo-btn" data-intent="' + data.intent + '" data-id="' + data.record_id + '"><i class="bi bi-arrow-counterclockwise me-1"></i>' + lblUndo + '</button>' : '')
					+ '</div>'
					+ (data.record_id && data.fields ? buildInChatEditBox(data.intent, data.record_id, data.fields) : '');
			} else if (data && data.options && data.options.length > 0) {
				actions = '<div class="cow-bot-opt-wrap">';
				for (var k = 0; k < data.options.length; k++) {
					var opt = String(data.options[k]).replace(/"/g, '&quot;');
					var isCancel = (opt === 'বাতিল' || opt === 'Cancel');
					actions += '<button type="button" class="cow-opt-pill ' + (isCancel ? 'cow-opt-pill--cancel' : '') + '" data-opt="' + opt + '">' + opt + '</button>';
				}
				actions += '</div>';
				if (data.input_hint) {
					var hintSafe = String(data.input_hint).replace(/"/g, '&quot;');
					var unitSafe = String(data.input_unit || '').replace(/"/g, '&quot;');
					var inpType = unitSafe ? 'number" step="any" min="0.01' : 'text';
					actions += '<form class="cow-inline-val-form mt-2 d-flex gap-1" data-unit="' + unitSafe + '">'
						+ '<input type="' + inpType + '" class="form-control form-control-sm cow-inline-val-input" placeholder="' + hintSafe + '" required>'
						+ (unitSafe ? '<span class="cow-inline-unit">' + unitSafe + '</span>' : '')
						+ '<button type="submit" class="btn btn-sm btn-success px-2 py-1"><i class="bi bi-check-lg"></i></button>'
						+ '</form>';
				}
			}
			appendMsg('bot', formatBotText((data && data.reply) ? data.reply : 'Error'), actions);
			var lastInline = thread.querySelector('.cow-bot-msg:last-child .cow-inline-val-input');
			if (lastInline) lastInline.focus();
		})
		.catch(function(){
			appendMsg('bot', 'Connection error. Please try again.');
		});
	}

	form.addEventListener('submit', function(e){
		e.preventDefault();
		sendToBot(input.value);
	});

	var catBtns = panel.querySelectorAll('.cow-bot-cat-btn');
	for (var i = 0; i < catBtns.length; i++) {
		catBtns[i].addEventListener('click', function(){
			sendToBot(this.getAttribute('data-cmd'));
		});
	}

	// Voice Recognition (Web Speech API)
	var SpeechRec = window.SpeechRecognition || window.webkitSpeechRecognition;
	if (SpeechRec && micBtn) {
		var rec = new SpeechRec();
		rec.continuous = false;
		rec.interimResults = false;
		var listening = false;

		micBtn.addEventListener('click', function(){
			if (listening) {
				rec.stop();
				return;
			}
			rec.lang = (appLang === 'en') ? 'en-US' : 'bn-BD';
			try {
				rec.start();
				listening = true;
				micBtn.classList.add('recording');
			} catch (e) {}
		});

		rec.onresult = function(event) {
			if (event.results && event.results[0] && event.results[0][0]) {
				input.value = event.results[0][0].transcript;
				input.focus();
			}
		};

		rec.onend = function() {
			listening = false;
			micBtn.classList.remove('recording');
		};

		rec.onerror = function() {
			listening = false;
			micBtn.classList.remove('recording');
		};
	} else if (micBtn) {
		micBtn.style.display = 'none';
	}

	loadHistory();
})();
</script>
