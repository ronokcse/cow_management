<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('cow_lang'))
{
	function cow_lang()
	{
		$CI =& get_instance();
		$lang = $CI->session ? $CI->session->userdata('app_lang') : 'bn';
		return ($lang === 'en') ? 'en' : 'bn';
	}
}

if ( ! function_exists('t'))
{
	function t($key)
	{
		static $dict = array(
			'app_name' => array('bn' => 'গরু খামার হিসাব', 'en' => 'Cow Farm Manager'),
			'app_tagline' => array('bn' => 'স্মার্ট ডেইরি ও ক্যাটল ফার্ম ম্যানেজমেন্ট', 'en' => 'Smart Dairy & Cattle Farm Management'),
			'nav_main' => array('bn' => 'মূল মেনু', 'en' => 'Main Menu'),
			'nav_feed' => array('bn' => 'খাদ্য ও স্টক', 'en' => 'Feed & Stock'),
			'nav_finance' => array('bn' => 'আয় ও ব্যয় হিসাব', 'en' => 'Finance & Accounts'),
			'nav_account' => array('bn' => 'অ্যাকাউন্ট', 'en' => 'Account'),
			'dashboard' => array('bn' => 'ড্যাশবোর্ড', 'en' => 'Dashboard'),
			'investments' => array('bn' => 'বিনিয়োগ', 'en' => 'Investments'),
			'food_types' => array('bn' => 'খাদ্যের ধরন', 'en' => 'Feed Types'),
			'food_purchases' => array('bn' => 'খাদ্য ক্রয়', 'en' => 'Feed Purchases'),
			'daily_feeding' => array('bn' => 'দৈনিক খাদ্য', 'en' => 'Daily Feeding'),
			'incomes' => array('bn' => 'আয়', 'en' => 'Incomes'),
			'other_expenses' => array('bn' => 'অন্যান্য খরচ', 'en' => 'Other Expenses'),
			'profile' => array('bn' => 'প্রোফাইল সেটিংস', 'en' => 'Profile Settings'),
			'logout' => array('bn' => 'লগআউট', 'en' => 'Logout'),
			'login' => array('bn' => 'লগইন', 'en' => 'Login'),
			'login_sub' => array('bn' => 'আপনার খামার অ্যাকাউন্টে প্রবেশ করুন', 'en' => 'Sign in to your farm account'),
			'username' => array('bn' => 'ইউজারনেম', 'en' => 'Username'),
			'password' => array('bn' => 'পাসওয়ার্ড', 'en' => 'Password'),
			'login_btn' => array('bn' => 'লগইন করুন', 'en' => 'Sign In'),
			'login_success' => array('bn' => 'সফলভাবে লগইন হয়েছে।', 'en' => 'Logged in successfully.'),
			'login_error' => array('bn' => 'ইউজারনেম অথবা পাসওয়ার্ড সঠিক নয়।', 'en' => 'Invalid username or password.'),
			'logout_success' => array('bn' => 'সফলভাবে লগআউট হয়েছে।', 'en' => 'Logged out successfully.'),

			// Dashboard
			'dash_hero_title' => array('bn' => 'খামার ড্যাশবোর্ড ওভারভিউ', 'en' => 'Farm Dashboard Overview'),
			'dash_hero_sub' => array('bn' => 'খামারের আর্থিক সারাংশ, লাভ-ক্ষতি, খাদ্যের মজুদ ও দৈনিক হিসাব — এক নজরে।', 'en' => 'Financial summary, profit/loss, feed inventory & daily logs at a glance.'),
			'total_investment' => array('bn' => 'মোট বিনিয়োগ', 'en' => 'Total Investment'),
			'total_food_cost' => array('bn' => 'মোট খাদ্য ক্রয়', 'en' => 'Total Feed Cost'),
			'total_other_cost' => array('bn' => 'অন্যান্য খরচ', 'en' => 'Other Expenses'),
			'total_ops_expense' => array('bn' => 'মোট পরিচালন খরচ', 'en' => 'Total Operating Expense'),
			'total_income' => array('bn' => 'মোট আয়', 'en' => 'Total Income'),
			'net_profit_loss' => array('bn' => 'নেট লাভ / ক্ষতি', 'en' => 'Net Profit / Loss'),
			'profit_formula' => array('bn' => 'আয় − (খাদ্য ক্রয় + অন্যান্য খরচ)', 'en' => 'Income − (Feed Cost + Other Expenses)'),
			'ops_formula' => array('bn' => 'খাদ্য ক্রয় + অন্যান্য খরচ', 'en' => 'Feed Cost + Other Expenses'),
			'quick_add_feed' => array('bn' => 'দৈনিক খাদ্য এন্ট্রি', 'en' => 'Log Daily Feed'),
			'quick_buy_feed' => array('bn' => 'খাদ্য ক্রয় যোগ', 'en' => 'Add Feed Purchase'),
			'quick_add_income' => array('bn' => 'নতুন আয় যোগ', 'en' => 'Record Income'),
			'quick_add_expense' => array('bn' => 'নতুন খরচ যোগ', 'en' => 'Record Expense'),
			'feed_stock_title' => array('bn' => 'খাদ্যের বর্তমান মজুদ (স্টক)', 'en' => 'Current Feed Inventory (Stock)'),
			'purchased_kg' => array('bn' => 'মোট ক্রয় (কেজি)', 'en' => 'Purchased (KG)'),
			'consumed_kg' => array('bn' => 'মোট ব্যবহার (কেজি)', 'en' => 'Consumed (KG)'),
			'stock_kg' => array('bn' => 'বর্তমান স্টক (কেজি)', 'en' => 'Available Stock (KG)'),
			'status' => array('bn' => 'অবস্থা', 'en' => 'Status'),
			'in_stock' => array('bn' => 'পর্যাপ্ত', 'en' => 'In Stock'),
			'low_stock' => array('bn' => 'কম স্টক', 'en' => 'Low Stock'),
			'out_of_stock' => array('bn' => 'স্টক শেষ', 'en' => 'Out of Stock'),
			'today_feeding' => array('bn' => 'আজকের খাদ্য তালিকা', 'en' => 'Today\'s Feeding Log'),
			'last_30_days_feed' => array('bn' => 'গত ৩০ দিনের খাদ্য ব্যবহার (কেজি)', 'en' => 'Last 30 Days Feed Usage (KG)'),
			'recent_feeding_entries' => array('bn' => 'সাম্প্রতিক দৈনিক খাদ্য এন্ট্রি', 'en' => 'Recent Daily Feeding Entries'),
			'no_today_entry' => array('bn' => 'আজকের কোনো খাদ্য এন্ট্রি নেই।', 'en' => 'No feeding entries logged for today.'),
			'no_data' => array('bn' => 'কোনো ডেটা পাওয়া যায়নি।', 'en' => 'No records found.'),

			// Common actions & labels
			'add_new' => array('bn' => 'নতুন যোগ করুন', 'en' => 'Add New'),
			'print_report' => array('bn' => 'প্রিন্ট করুন', 'en' => 'Print Report'),
			'edit' => array('bn' => 'সম্পাদনা', 'en' => 'Edit'),
			'delete' => array('bn' => 'মুছুন', 'en' => 'Delete'),
			'save' => array('bn' => 'সংরক্ষণ করুন', 'en' => 'Save Changes'),
			'cancel' => array('bn' => 'বাতিল', 'en' => 'Cancel'),
			'actions' => array('bn' => 'অ্যাকশন', 'en' => 'Actions'),
			'date' => array('bn' => 'তারিখ', 'en' => 'Date'),
			'amount' => array('bn' => 'টাকার পরিমাণ', 'en' => 'Amount (৳)'),
			'total_amount' => array('bn' => 'মোট টাকা', 'en' => 'Total Amount (৳)'),
			'unit_price' => array('bn' => 'কেজি প্রতি দর', 'en' => 'Rate / KG'),
			'description' => array('bn' => 'বিবরণ', 'en' => 'Description'),
			'description_opt' => array('bn' => 'বিবরণ (ঐচ্ছিক)', 'en' => 'Description (Optional)'),
			'notes' => array('bn' => 'নোট', 'en' => 'Notes'),
			'notes_opt' => array('bn' => 'নোট (ঐচ্ছিক)', 'en' => 'Notes (Optional)'),
			'type' => array('bn' => 'খাদ্যের ধরন', 'en' => 'Feed Type'),
			'kg' => array('bn' => 'পরিমাণ (কেজি)', 'en' => 'Quantity (KG)'),
			'total_kg' => array('bn' => 'মোট কেজি', 'en' => 'Total KG'),
			'name' => array('bn' => 'নাম', 'en' => 'Name'),
			'sort_order' => array('bn' => 'ক্রম (সাজানো)', 'en' => 'Sort Order'),
			'sort_order_hint' => array('bn' => 'ক্রম (ছোট সংখ্যা আগে দেখাবে)', 'en' => 'Sort Order (smaller numbers appear first)'),
			'select_option' => array('bn' => '— নির্বাচন করুন —', 'en' => '— Select Option —'),
			'confirm_delete' => array('bn' => 'আপনি কি নিশ্চিতভাবে এটি মুছে ফেলতে চান?', 'en' => 'Are you sure you want to delete this record?'),
			'saved_msg' => array('bn' => 'সফলভাবে সংরক্ষণ করা হয়েছে।', 'en' => 'Record saved successfully.'),
			'updated_msg' => array('bn' => 'সফলভাবে আপডেট করা হয়েছে।', 'en' => 'Record updated successfully.'),
			'deleted_msg' => array('bn' => 'সফলভাবে মুছে ফেলা হয়েছে।', 'en' => 'Record deleted successfully.'),
			'dup_name_err' => array('bn' => 'এই নাম আগে থেকেই আছে।', 'en' => 'This name already exists.'),
			'in_use_err' => array('bn' => 'মুছতে পারিনি — এই খাদ্যের ধরনটি অন্য রেকর্ডে ব্যবহৃত হচ্ছে।', 'en' => 'Cannot delete — this feed type is currently in use.'),

			// Module titles
			'new_investment' => array('bn' => 'নতুন বিনিয়োগ যোগ', 'en' => 'Add New Investment'),
			'edit_investment' => array('bn' => 'বিনিয়োগ সম্পাদনা', 'en' => 'Edit Investment'),
			'new_food_type' => array('bn' => 'নতুন খাদ্যের ধরন', 'en' => 'Add Feed Type'),
			'edit_food_type' => array('bn' => 'খাদ্যের ধরন সম্পাদনা', 'en' => 'Edit Feed Type'),
			'new_food_purchase' => array('bn' => 'নতুন খাদ্য ক্রয়', 'en' => 'Add Feed Purchase'),
			'edit_food_purchase' => array('bn' => 'খাদ্য ক্রয় সম্পাদনা', 'en' => 'Edit Feed Purchase'),
			'new_daily_feeding' => array('bn' => 'দৈনিক খাদ্য এন্ট্রি', 'en' => 'Add Daily Feeding Entry'),
			'edit_daily_feeding' => array('bn' => 'দৈনিক খাদ্য সম্পাদনা', 'en' => 'Edit Daily Feeding Entry'),
			'new_income' => array('bn' => 'নতুন আয় যোগ', 'en' => 'Add New Income'),
			'edit_income' => array('bn' => 'আয় সম্পাদনা', 'en' => 'Edit Income'),
			'income_desc_hint' => array('bn' => 'বিবরণ (ঐচ্ছিক) — দুধ বিক্রি, গরু বিক্রি, গোবর বিক্রি ইত্যাদি', 'en' => 'Description (Optional) — Milk sale, cattle sale, manure sale, etc.'),
			'new_expense' => array('bn' => 'নতুন খরচ যোগ', 'en' => 'Add Other Expense'),
			'edit_expense' => array('bn' => 'খরচ সম্পাদনা', 'en' => 'Edit Other Expense'),
			'expense_desc_hint' => array('bn' => 'বিবরণ (ঐচ্ছিক) — চিকিৎসা, ওষুধ, শ্রমিক, বিদ্যুৎ, পরিবহন ইত্যাদি', 'en' => 'Description (Optional) — Vet/medicine, labor, electricity, transport, etc.'),

			// Filter bar
			'filter_by_date' => array('bn' => 'তারিখ অনুযায়ী ফিল্টার', 'en' => 'Filter by Date'),
			'filter_mode' => array('bn' => 'ফিল্টারের ধরন', 'en' => 'Filter Mode'),
			'all_dates' => array('bn' => 'সব তারিখ', 'en' => 'All Dates'),
			'specific_day' => array('bn' => 'নির্দিষ্ট দিন', 'en' => 'Specific Day'),
			'specific_month' => array('bn' => 'নির্দিষ্ট মাস', 'en' => 'Specific Month'),
			'specific_year' => array('bn' => 'নির্দিষ্ট বছর', 'en' => 'Specific Year'),
			'day' => array('bn' => 'দিন', 'en' => 'Day'),
			'month' => array('bn' => 'মাস', 'en' => 'Month'),
			'year' => array('bn' => 'বছর', 'en' => 'Year'),
			'apply' => array('bn' => 'ফিল্টার করুন', 'en' => 'Apply Filter'),
			'reset' => array('bn' => 'রিসেট', 'en' => 'Reset'),
			'active_filter' => array('bn' => 'ফিল্টার', 'en' => 'Active Filter'),
			'filtered_total' => array('bn' => 'ফিল্টারকৃত মোট', 'en' => 'Filtered Total'),
			'records_count' => array('bn' => 'মোট এন্ট্রি', 'en' => 'Total Records'),

			// Profile
			'change_name' => array('bn' => 'নাম পরিবর্তন', 'en' => 'Update Display Name'),
			'update_name_btn' => array('bn' => 'নাম আপডেট করুন', 'en' => 'Update Name'),
			'change_password' => array('bn' => 'পাসওয়ার্ড পরিবর্তন', 'en' => 'Change Password'),
			'current_password' => array('bn' => 'বর্তমান পাসওয়ার্ড', 'en' => 'Current Password'),
			'new_password' => array('bn' => 'নতুন পাসওয়ার্ড (কমপক্ষে ৬ অক্ষর)', 'en' => 'New Password (min 6 chars)'),
			'confirm_password' => array('bn' => 'নতুন পাসওয়ার্ড নিশ্চিত করুন', 'en' => 'Confirm New Password'),
			'change_password_btn' => array('bn' => 'পাসওয়ার্ড পরিবর্তন করুন', 'en' => 'Update Password'),
			'err_name_empty' => array('bn' => 'নাম খালি রাখা যাবে না।', 'en' => 'Name cannot be empty.'),
			'msg_name_updated' => array('bn' => 'নাম সফলভাবে পরিবর্তন হয়েছে।', 'en' => 'Name updated successfully.'),
			'err_curr_pwd' => array('bn' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।', 'en' => 'Current password is incorrect.'),
			'err_pwd_len' => array('bn' => 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।', 'en' => 'New password must be at least 6 characters.'),
			'err_pwd_mismatch' => array('bn' => 'নতুন পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড মিলছে না।', 'en' => 'New password and confirmation do not match.'),
			'msg_pwd_updated' => array('bn' => 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।', 'en' => 'Password changed successfully.'),
			'documentation' => array('bn' => 'ডকুমেন্টেশন', 'en' => 'Documentation'),
		);

		$lang = cow_lang();
		if (isset($dict[$key][$lang]))
		{
			return $dict[$key][$lang];
		}
		return isset($dict[$key]['bn']) ? $dict[$key]['bn'] : $key;
	}
}

if ( ! function_exists('cow_month_name'))
{
	function cow_month_name($m)
	{
		$months_bn = array(
			1 => 'জানুয়ারি', 2 => 'ফেব্রুয়ারি', 3 => 'মার্চ', 4 => 'এপ্রিল',
			5 => 'মে', 6 => 'জুন', 7 => 'জুলাই', 8 => 'আগস্ট',
			9 => 'সেপ্টেম্বর', 10 => 'অক্টোবর', 11 => 'নভেম্বর', 12 => 'ডিসেম্বর'
		);
		$months_en = array(
			1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
			5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
			9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
		);
		$m = (int) $m;
		return cow_lang() === 'en'
			? (isset($months_en[$m]) ? $months_en[$m] : (string) $m)
			: (isset($months_bn[$m]) ? $months_bn[$m] : (string) $m);
	}
}

if ( ! function_exists('money_fmt'))
{
	function money_fmt($amount)
	{
		return number_format((float) $amount, 2, '.', ',');
	}
}

if ( ! function_exists('cow_parse_date_filter'))
{
	function cow_parse_date_filter($input)
	{
		$filter = $input->get('filter');
		if ($filter === NULL || $filter === '')
		{
			$filter = 'all';
		}
		if ( ! in_array($filter, array('all', 'day', 'month', 'year'), TRUE))
		{
			$filter = 'all';
		}

		$now_y = (int) date('Y');
		$now_m = (int) date('n');
		$today = date('Y-m-d');

		$fd = $input->get('fd');
		if ($fd === NULL || $fd === '')
		{
			$fd = $today;
		}

		$fm = (int) $input->get('fm');
		if ($fm < 1 || $fm > 12)
		{
			$fm = $now_m;
		}

		$fy = (int) $input->get('fy');
		if ($fy < 2000 || $fy > 2100)
		{
			$fy = $now_y;
		}

		$start = NULL;
		$end = NULL;
		$label = t('all_dates');

		if ($filter === 'day')
		{
			if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fd))
			{
				$start = $fd;
				$end = $fd;
				$label = t('day').': '.$fd;
			}
			else
			{
				$filter = 'all';
			}
		}
		elseif ($filter === 'month')
		{
			$start = sprintf('%04d-%02d-01', $fy, $fm);
			$end = date('Y-m-t', strtotime($start));
			$label = t('month').': '.cow_month_name($fm).' '.$fy;
		}
		elseif ($filter === 'year')
		{
			$start = sprintf('%04d-01-01', $fy);
			$end = sprintf('%04d-12-31', $fy);
			$label = t('year').': '.$fy;
		}

		return array(
			'filter' => $filter,
			'fd' => $fd,
			'fm' => $fm,
			'fy' => $fy,
			'start' => $start,
			'end' => $end,
			'label' => $label,
		);
	}
}
