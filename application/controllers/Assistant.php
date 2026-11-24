<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assistant extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('investment_model');
		$this->load->model('food_purchase_model');
		$this->load->model('daily_feeding_model');
		$this->load->model('food_type_model');
		$this->load->model('income_model');
		$this->load->model('other_expense_model');
	}

	public function undo()
	{
		$this->output->set_content_type('application/json', 'utf-8');
		$intent = (string) $this->input->post('intent', TRUE);
		$id = (int) $this->input->post('id', TRUE);
		$lang = cow_lang();

		if ($id <= 0)
		{
			echo json_encode(array('ok' => FALSE, 'reply' => 'Invalid ID'));
			return;
		}

		$deleted = 0;
		if ($intent === 'investment')
		{
			$deleted = $this->investment_model->delete($id);
		}
		elseif ($intent === 'food_purchase')
		{
			$deleted = $this->food_purchase_model->delete($id);
		}
		elseif ($intent === 'daily_feeding')
		{
			$deleted = $this->daily_feeding_model->delete($id);
		}
		elseif ($intent === 'income')
		{
			$deleted = $this->income_model->delete($id);
		}
		elseif ($intent === 'other_expense')
		{
			$deleted = $this->other_expense_model->delete($id);
		}

		if ($deleted)
		{
			echo json_encode(array(
				'ok' => TRUE,
				'reply' => $lang === 'en'
					? '↩️ **Undone!** The entry has been removed.'
					: '↩️ **বাতিল করা হয়েছে!** হিসাবটি মুছে ফেলা হয়েছে।',
			));
			return;
		}

		echo json_encode(array(
			'ok' => FALSE,
			'reply' => $lang === 'en' ? 'Entry was already removed.' : 'হিসাবটি ইতিমধ্যেই মুছে ফেলা হয়েছে।',
		));
	}

	public function update_record()
	{
		$this->output->set_content_type('application/json', 'utf-8');
		$intent = (string) $this->input->post('intent', TRUE);
		$id = (int) $this->input->post('id', TRUE);
		$amount = (float) $this->input->post('amount', TRUE);
		$kg = (float) $this->input->post('kg', TRUE);
		$date = trim((string) $this->input->post('date', TRUE));
		$desc = trim((string) $this->input->post('desc', TRUE));
		$lang = cow_lang();

		if ($id <= 0)
		{
			echo json_encode(array('ok' => FALSE, 'reply' => 'Invalid ID'));
			return;
		}
		if ( ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date))
		{
			$date = date('Y-m-d');
		}

		if ($intent === 'investment')
		{
			$this->investment_model->update($id, array(
				'amount' => $amount,
				'investment_date' => $date,
				'description' => $desc ?: NULL,
			));
			$reply = $lang === 'en'
				? "✅ **Updated in Investments**\n• **Amount:** ৳ ".money_fmt($amount)."\n• **Date:** {$date}\n• **Note:** ".($desc ?: '—')
				: "✅ **বিনিয়োগ আপডেট হয়েছে**\n• **পরিমাণ:** ৳ ".money_fmt($amount)."\n• **তারিখ:** {$date}\n• **বিবরণ:** ".($desc ?: '—');
		}
		elseif ($intent === 'food_purchase')
		{
			$row = $this->food_purchase_model->get_by_id($id);
			$ft = $row ? $this->food_type_model->get_by_id($row->food_type_id) : NULL;
			$ft_name = $ft ? $ft->name : '';
			$this->food_purchase_model->update($id, array(
				'quantity_kg' => $kg,
				'total_amount' => $amount,
				'purchase_date' => $date,
				'notes' => $desc ?: NULL,
			));
			$rate = $kg > 0 ? ($amount / $kg) : 0;
			$reply = $lang === 'en'
				? "✅ **Updated in Feed Purchases**\n• **Feed:** {$ft_name}\n• **Quantity:** ".money_fmt($kg)." KG\n• **Cost:** ৳ ".money_fmt($amount)." (৳ ".money_fmt($rate)."/KG)\n• **Date:** {$date}"
				: "✅ **খাদ্য ক্রয় আপডেট হয়েছে**\n• **খাদ্য:** {$ft_name}\n• **পরিমাণ:** ".money_fmt($kg)." কেজি\n• **মোট দাম:** ৳ ".money_fmt($amount)." (৳ ".money_fmt($rate)."/কেজি)\n• **তারিখ:** {$date}";
		}
		elseif ($intent === 'daily_feeding')
		{
			$row = $this->daily_feeding_model->get_by_id($id);
			$ft = $row ? $this->food_type_model->get_by_id($row->food_type_id) : NULL;
			$ft_name = $ft ? $ft->name : '';
			$this->daily_feeding_model->update($id, array(
				'quantity_kg' => $kg,
				'feeding_date' => $date,
				'notes' => $desc ?: NULL,
			));
			$reply = $lang === 'en'
				? "✅ **Updated in Daily Feeding**\n• **Feed:** {$ft_name}\n• **Quantity:** ".money_fmt($kg)." KG\n• **Date:** {$date}"
				: "✅ **দৈনিক খাদ্য আপডেট হয়েছে**\n• **খাদ্য:** {$ft_name}\n• **পরিমাণ:** ".money_fmt($kg)." কেজি\n• **তারিখ:** {$date}";
		}
		elseif ($intent === 'income')
		{
			$this->income_model->update($id, array(
				'amount' => $amount,
				'income_date' => $date,
				'description' => $desc ?: NULL,
			));
			$reply = $lang === 'en'
				? "✅ **Updated in Incomes**\n• **Amount:** ৳ ".money_fmt($amount)."\n• **Date:** {$date}\n• **Description:** ".($desc ?: '—')
				: "✅ **আয়ের হিসাব আপডেট হয়েছে**\n• **পরিমাণ:** ৳ ".money_fmt($amount)."\n• **তারিখ:** {$date}\n• **বিবরণ:** ".($desc ?: '—');
		}
		elseif ($intent === 'other_expense')
		{
			$this->other_expense_model->update($id, array(
				'amount' => $amount,
				'expense_date' => $date,
				'description' => $desc ?: NULL,
			));
			$reply = $lang === 'en'
				? "✅ **Updated in Other Expenses**\n• **Amount:** ৳ ".money_fmt($amount)."\n• **Date:** {$date}\n• **Description:** ".($desc ?: '—')
				: "✅ **অন্যান্য খরচ আপডেট হয়েছে**\n• **পরিমাণ:** ৳ ".money_fmt($amount)."\n• **তারিখ:** {$date}\n• **বিবরণ:** ".($desc ?: '—');
		}
		else
		{
			echo json_encode(array('ok' => FALSE, 'reply' => 'Unknown intent'));
			return;
		}

		echo json_encode(array(
			'ok' => TRUE,
			'reply' => $reply,
			'fields' => array(
				'amount' => $amount,
				'kg' => $kg,
				'date' => $date,
				'desc' => $desc,
			),
		));
	}

	public function reset()
	{
		$this->output->set_content_type('application/json', 'utf-8');
		$this->session->unset_userdata('bot_pending');
		echo json_encode(array('ok' => TRUE));
	}

	public function chat()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$raw_msg = trim((string) $this->input->post('message', TRUE));
		if ($raw_msg === '')
		{
			echo json_encode(array(
				'ok' => FALSE,
				'reply' => cow_lang() === 'en' ? 'Please type a message.' : 'অনুগ্রহ করে কিছু লিখুন।',
			));
			return;
		}

		$norm = $this->normalize_text($raw_msg);
		$lang = cow_lang();

		// 1. Cancel pending state
		if (preg_match('/^(cancel|reset|bad|বাদ|বাতিল|থাক|না)$/u', $norm))
		{
			$this->session->unset_userdata('bot_pending');
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'reply' => $lang === 'en'
					? 'Cancelled. Select an option above or type a new entry.'
					: 'বাতিল করা হয়েছে। উপরে যেকোনো খাতে ক্লিক করুন অথবা নতুন হিসাব লিখুন।',
			));
			return;
		}

		// 2. Smart Analytics Queries (Today / This Month / Stock / Summary)
		if ($this->is_stock_query($norm))
		{
			$this->session->unset_userdata('bot_pending');
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'reply' => $this->build_stock_reply($lang),
			));
			return;
		}

		if ($this->is_today_query($norm))
		{
			$this->session->unset_userdata('bot_pending');
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'reply' => $this->build_today_reply($lang),
			));
			return;
		}

		if ($this->is_month_query($norm))
		{
			$this->session->unset_userdata('bot_pending');
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'reply' => $this->build_month_reply($lang),
			));
			return;
		}

		if ($this->is_summary_query($norm))
		{
			$this->session->unset_userdata('bot_pending');
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'reply' => $this->build_summary_reply($lang),
				'options' => $lang === 'en'
					? array('Today report', 'This month report', 'Feed stock')
					: array('আজকের হিসাব', 'এই মাসের হিসাব', 'খাদ্যের স্টক'),
			));
			return;
		}

		if ($this->is_help_query($norm))
		{
			$this->session->unset_userdata('bot_pending');
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'reply' => $this->build_help_reply($lang),
			));
			return;
		}

		// 3. Multi-Command Batch Processing (only when no pending state)
		$pending = $this->session->userdata('bot_pending');
		if (empty($pending))
		{
			$clauses = $this->split_multi_commands($raw_msg);
			if (count($clauses) > 1)
			{
				$batch_results = array();
				$pending_followup = NULL;
				foreach ($clauses as $cl)
				{
					$cl_norm = $this->normalize_text($cl);
					$p = $this->parse_message($cl, $cl_norm, NULL);
					if (empty($p['need_followup']) && ! empty($p['intent']) && $p['intent'] !== 'unknown')
					{
						$batch_results[] = $this->execute_intent($p, $lang);
					}
					elseif ( ! empty($p['need_followup']) && ! empty($p['pending_state']['intent']) && $p['pending_state']['intent'] !== 'unknown' && $pending_followup === NULL)
					{
						$pending_followup = $p;
					}
				}
				if (count($batch_results) >= 1 && ($pending_followup !== NULL || count($batch_results) > 1))
				{
					$replies = array();
					foreach ($batch_results as $br)
					{
						$replies[] = $br['reply'];
					}
					$header = count($batch_results) > 1
						? ($lang === 'en' ? "⚡ **".count($batch_results)." Records Saved!**\n\n" : "⚡ **একসাথে ".count($batch_results)."টি হিসাব সেভ হয়েছে!**\n\n")
						: '';
					$full_reply = $header.implode("\n\n", $replies);

					$options = array();
					$input_hint = '';
					$input_unit = '';
					if ($pending_followup !== NULL)
					{
						$this->session->set_userdata('bot_pending', $pending_followup['pending_state']);
						$full_reply .= "\n\n---\n".$pending_followup['followup_question'];
						$options = isset($pending_followup['options']) ? $pending_followup['options'] : array();
						$input_hint = isset($pending_followup['input_hint']) ? $pending_followup['input_hint'] : '';
						$input_unit = isset($pending_followup['input_unit']) ? $pending_followup['input_unit'] : '';
					}

					$last = end($batch_results);
					echo json_encode(array(
						'ok' => TRUE,
						'saved' => ($pending_followup === NULL),
						'pending' => ($pending_followup !== NULL),
						'intent' => $last['intent'],
						'record_id' => $last['record_id'],
						'url' => $last['url'],
						'reply' => $full_reply,
						'options' => $options,
						'input_hint' => $input_hint,
						'input_unit' => $input_unit,
					));
					return;
				}
			}
		}

		// 4. Single / Multi-turn Conversational Parsing
		$parsed = $this->parse_message($raw_msg, $norm, $pending);

		if ( ! empty($parsed['need_followup']))
		{
			$this->session->set_userdata('bot_pending', $parsed['pending_state']);
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'pending' => TRUE,
				'reply' => $parsed['followup_question'],
				'options' => isset($parsed['options']) ? $parsed['options'] : array(),
				'placeholder' => isset($parsed['placeholder']) ? $parsed['placeholder'] : '',
				'input_hint' => isset($parsed['input_hint']) ? $parsed['input_hint'] : '',
				'input_unit' => isset($parsed['input_unit']) ? $parsed['input_unit'] : '',
			));
			return;
		}

		$this->session->unset_userdata('bot_pending');

		if (empty($parsed['intent']) || $parsed['intent'] === 'unknown')
		{
			echo json_encode(array(
				'ok' => TRUE,
				'saved' => FALSE,
				'reply' => $this->build_unknown_reply($lang),
			));
			return;
		}

		$result = $this->execute_intent($parsed, $lang);
		echo json_encode($result);
	}

	private function split_multi_commands($raw_msg)
	{
		$parts = preg_split('/(?:\s*;\s*|\s*\+\s*|\s*,\s*|\s+এবং\s+|\s+আর\s+|\s+and\s+)/ui', $raw_msg);
		$clean = array();
		foreach ($parts as $p)
		{
			$p = trim($p);
			if ($p !== '')
			{
				$clean[] = $p;
			}
		}
		return $clean;
	}

	private function normalize_text($str)
	{
		$bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
		$en_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
		$str = str_replace($bn_digits, $en_digits, $str);
		$str = preg_replace('/(\d),(\d)/', '$1$2', $str);
		return mb_strtolower($str, 'UTF-8');
	}

	private function is_stock_query($norm)
	{
		return (bool) preg_match('/(স্টক|মজুদ|খাদ্যের স্টক|খাদ্য মজুদ|কত কেজি আছে|stock|inventory)/u', $norm)
			&& ! preg_match('/(কিনলাম|কিনেছি|কিনসি|খাওয়ালাম|দিলাম|kinsi|kinlam|khawailam)/u', $norm);
	}

	private function is_today_query($norm)
	{
		return (bool) preg_match('/(আজকের হিসাব|আজকের সারাংশ|আজকের রিপোর্ট|ajker hisab|ajker report|today report|today summary)/u', $norm);
	}

	private function is_month_query($norm)
	{
		return (bool) preg_match('/(এই মাসের হিসাব|চলতি মাসের হিসাব|মাসের হিসাব|ei maser hisab|this month|month report|monthly summary)/u', $norm);
	}

	private function is_summary_query($norm)
	{
		return (bool) preg_match('/(হিসাব দেখাও|বর্তমান হিসাব|সারাংশ|লাভ কত|মোট আয়|মোট খরচ|summary|status|balance|profit|report)/u', $norm)
			&& ! preg_match('/\d+/', $norm);
	}

	private function is_help_query($norm)
	{
		return (bool) preg_match('/^(help|হেল্প|কিভাবে|কীভাবে|সাহায্য|কি করবো|hello|hi|হ্যালো|সালাম|assalamu)/u', $norm);
	}

	private function get_food_type_option_chips()
	{
		$types = $this->food_type_model->get_all();
		$chips = array();
		foreach ($types as $ft)
		{
			$chips[] = $ft->name;
		}
		if (empty($chips))
		{
			$chips = array('কাঁচা ঘাস', 'গমের ভুসি', 'খড়', 'খৈল');
		}
		return $chips;
	}

	private function parse_message($raw_msg, $norm, $pending)
	{
		$lang = cow_lang();

		// Check if user clicked one of the top-level category buttons to start fresh
		$top_triggers = array(
			'নতুন আয়' => 'income', 'আয় যোগ' => 'income', 'আয়' => 'income', 'income' => 'income', 'add income' => 'income',
			'অন্যান্য খরচ' => 'other_expense', 'নতুন খরচ' => 'other_expense', 'খরচ' => 'other_expense', 'expense' => 'other_expense', 'add expense' => 'other_expense',
			'নতুন বিনিয়োগ' => 'investment', 'বিনিয়োগ' => 'investment', 'investment' => 'investment', 'add investment' => 'investment',
			'দৈনিক খাদ্য' => 'daily_feeding', 'daily feed' => 'daily_feeding',
			'খাদ্য ক্রয়' => 'food_purchase', 'feed purchase' => 'food_purchase',
		);

		$trimmed_norm = trim($norm);
		$is_generic_trigger = isset($top_triggers[$trimmed_norm]);
		$current_pending_intent = (is_array($pending) && ! empty($pending['intent'])) ? $pending['intent'] : NULL;

		if ($is_generic_trigger)
		{
			$chosen_intent = $top_triggers[$trimmed_norm];
			if ($current_pending_intent === 'choose_category' && in_array($chosen_intent, array('income', 'other_expense', 'investment'), TRUE))
			{
				// User selected which category to save their previously typed amount+reason into!
				$intent = $chosen_intent;
				$current_pending_intent = $chosen_intent;
				$pending['intent'] = $chosen_intent;
			}
			else
			{
				// Always start fresh when user clicks a top category button normally
				$pending = NULL;
				$current_pending_intent = NULL;
				$intent = $chosen_intent;
			}
		}

		$date_info = $this->extract_date_info($norm);
		$date = $date_info['date'];
		$norm_no_date = $date_info['clean_text'];

		$kg = $this->extract_kg($norm_no_date);
		$amount = $this->extract_amount($norm_no_date);
		$all_nums = $this->extract_all_numbers($norm_no_date);

		$food_type = $this->detect_food_type($norm, $current_pending_intent);

		if ( ! $is_generic_trigger)
		{
			$detected_intent = $this->detect_intent($norm, $food_type, $kg, $amount);

			if ($current_pending_intent !== NULL)
			{
				// Stay in pending intent if we are answering a follow-up question (reason, food_type, kg, or amount)
				$waiting_for_reason = empty($pending['reason']) && in_array($current_pending_intent, array('income', 'other_expense', 'investment'), TRUE);
				$waiting_for_food = empty($pending['food_type']) && in_array($current_pending_intent, array('daily_feeding', 'food_purchase'), TRUE);
				$is_just_number_or_unit = ($kg !== NULL || $amount !== NULL || count($all_nums) === 1);

				if ($detected_intent === 'unknown' || $detected_intent === $current_pending_intent || $waiting_for_reason || $waiting_for_food || $is_just_number_or_unit)
				{
					$intent = $current_pending_intent;
				}
				else
				{
					$intent = $detected_intent;
					$pending = NULL;
				}
			}
			else
			{
				$intent = $detected_intent;
			}
		}

		$prev_kg = (is_array($pending) && isset($pending['kg'])) ? $pending['kg'] : NULL;
		$prev_amount = (is_array($pending) && isset($pending['amount'])) ? $pending['amount'] : NULL;

		$final_food = $food_type ? $food_type : ((is_array($pending) && isset($pending['food_type'])) ? $pending['food_type'] : NULL);
		$final_kg = ($kg !== NULL) ? $kg : $prev_kg;
		$final_amount = ($amount !== NULL) ? $amount : $prev_amount;

		if ($date_info['explicit'])
		{
			$final_date = $date;
		}
		elseif (is_array($pending) && ! empty($pending['date']))
		{
			$final_date = $pending['date'];
		}
		else
		{
			$final_date = $date;
		}

		// Smart number assignment ONLY for numbers that did NOT already have an explicit unit!
		if ($intent === 'investment' || $intent === 'income' || $intent === 'other_expense' || $intent === 'unknown')
		{
			if ($final_amount === NULL && $kg === NULL && ! empty($all_nums))
			{
				$final_amount = (float) max($all_nums);
			}
		}
		elseif ($intent === 'daily_feeding')
		{
			if ($final_kg === NULL && ! empty($all_nums))
			{
				$final_kg = (float) $all_nums[0];
			}
		}
		elseif ($intent === 'food_purchase')
		{
			if (count($all_nums) >= 2)
			{
				// Two numbers given in the same message (e.g. "50 kg 2200 tk" or "50 2200")
				if ($kg === NULL && $amount === NULL)
				{
					$n1 = (float) $all_nums[0];
					$n2 = (float) $all_nums[1];
					$final_kg = min($n1, $n2);
					$final_amount = max($n1, $n2);
				}
				elseif ($kg !== NULL && $amount === NULL)
				{
					foreach ($all_nums as $n)
					{
						if ((float) $n !== (float) $kg)
						{
							$final_amount = (float) $n;
							break;
						}
					}
				}
				elseif ($amount !== NULL && $kg === NULL)
				{
					foreach ($all_nums as $n)
					{
						if ((float) $n !== (float) $amount)
						{
							$final_kg = (float) $n;
							break;
						}
					}
				}
			}
			elseif (count($all_nums) === 1 && $kg === NULL && $amount === NULL)
			{
				// User typed a single BARE number (e.g. "12" or "450") with NO unit
				// Fill whichever slot was still empty in pending state!
				if ($prev_kg === NULL)
				{
					$final_kg = (float) $all_nums[0];
				}
				elseif ($prev_amount === NULL)
				{
					$final_amount = (float) $all_nums[0];
				}
			}
		}

		// Clean reason tracking for income, other_expense, and investment
		$final_reason = (is_array($pending) && isset($pending['reason'])) ? $pending['reason'] : NULL;
		if ( ! $is_generic_trigger)
		{
			// Remove explicit date/amount/kg parts to see if a reason phrase was provided
			$msg_clean = trim(preg_replace('/^[0-9০-৯]+(?:\.[0-9০-৯]+)?\s*(?:টাকায়|টাকায়|টাকার|টাকা|টাঃ|কেজি|কজি|tk|taka|bdt|kg|kgs|৳)?$/ui', '', trim($raw_msg)));
			if ($msg_clean !== '')
			{
				$msg_clean = trim(preg_replace('/[0-9০-৯]+(?:\.[0-9০-৯]+)?\s*(?:টাকায়|টাকায়|টাকার|টাকা|টাঃ|কেজি|কজি|tk|taka|bdt|kg|kgs|৳)/ui', '', $msg_clean));
				$msg_clean = trim($msg_clean, " \t\n\r\0\x0B—-,.");
			}
			if ($msg_clean !== '')
			{
				$final_reason = $final_reason ? ($final_reason.' — '.$msg_clean) : $msg_clean;
			}
		}

		$final_raw = $final_reason ? $final_reason : ($is_generic_trigger ? '' : $raw_msg);

		$state = array(
			'intent' => $intent,
			'food_type' => $final_food,
			'kg' => $final_kg,
			'amount' => $final_amount,
			'date' => $final_date,
			'reason' => $final_reason,
			'raw_msg' => $final_raw,
		);

		// Follow-up checks
		if ($intent === 'investment')
		{
			if (empty($final_reason) && ($final_amount === NULL || $final_amount <= 0))
			{
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "🐄 **Investment (Step 1/2):** What is this investment for?"
						: "🐄 **বিনিয়োগ (ধাপ ১/২):** কী বাবদ বিনিয়োগ করেছেন?",
					'options' => $lang === 'en'
						? array('Cow Purchase', 'Calf Purchase', 'Shed Construction', 'Capital Deposit', 'Cancel')
						: array('গরু ক্রয়', 'গাভী ক্রয়', 'বাছুর ক্রয়', 'শেড নির্মাণ', 'মূলধন জমা', 'বাতিল'),
					'placeholder' => $lang === 'en' ? 'Or type reason (e.g. Bought 2 cows)...' : 'অথবা নিচে কারণ লিখুন...',
				);
			}
			if ($final_amount === NULL || $final_amount <= 0)
			{
				$r_lbl = $final_reason ? (' (**'.$final_reason.'**)') : '';
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "💰 **Step 2/2:** How much Taka was invested{$r_lbl}?"
						: "💰 **ধাপ ২/২:**{$r_lbl} বাবদ কত টাকা বিনিয়োগ করেছেন?",
					'options' => $lang === 'en'
						? array('25000 tk', '50000 tk', '85000 tk', '100000 tk', 'Cancel')
						: array('২৫০০০ টাকা', '৫০০০০ টাকা', '৮৫০০০ টাকা', '১০০০০০ টাকা', 'বাতিল'),
					'input_hint' => $lang === 'en' ? 'Enter custom amount...' : 'যেকোনো টাকার পরিমাণ লিখুন...',
					'input_unit' => $lang === 'en' ? 'tk' : 'টাকা',
				);
			}
		}
		elseif ($intent === 'income')
		{
			if (empty($final_reason) && ($final_amount === NULL || $final_amount <= 0))
			{
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "🥛 **Income (Step 1/2):** Which source is this income from?"
						: "🥛 **নতুন আয় (ধাপ ১/২):** কোন খাত থেকে আয় হয়েছে?",
					'options' => $lang === 'en'
						? array('Milk Sale', 'Cow Sale', 'Calf Sale', 'Manure Sale', 'Cancel')
						: array('দুধ বিক্রি', 'গরু বিক্রি', 'বাছুর বিক্রি', 'গোবর বিক্রি', 'বাতিল'),
					'input_hint' => $lang === 'en' ? 'Or type income source...' : 'অথবা অন্য কোনো খাত লিখুন...',
					'input_unit' => '',
				);
			}
			if ($final_amount === NULL || $final_amount <= 0)
			{
				$r_lbl = $final_reason ? (' (**'.$final_reason.'**)') : '';
				$is_cattle_sale = $final_reason && preg_match('/(গরু|গাভী|ষাঁড়|বাছুর|cow|calf|cattle)/ui', $final_reason);
				$inc_opts = $is_cattle_sale
					? ($lang === 'en' ? array('40000 tk', '70000 tk', '100000 tk', '150000 tk', 'Cancel') : array('৪০০০০ টাকা', '৭০০০০ টাকা', '১০০০০০ টাকা', '১৫০০০০ টাকা', 'বাতিল'))
					: ($lang === 'en' ? array('500 tk', '1000 tk', '1500 tk', '2000 tk', 'Cancel') : array('৫০০ টাকা', '১০০০ টাকা', '১৫০০ টাকা', '২০০০ টাকা', 'বাতিল'));
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "💰 **Step 2/2:** How much Taka was earned{$r_lbl}?"
						: "💰 **ধাপ ২/২:**{$r_lbl} থেকে কত টাকা আয় হয়েছে?",
					'options' => $inc_opts,
					'input_hint' => $lang === 'en' ? 'Enter custom amount...' : 'অন্য কোনো পরিমাণ এখানে লিখুন...',
					'input_unit' => $lang === 'en' ? 'tk' : 'টাকা',
				);
			}
		}
		elseif ($intent === 'other_expense')
		{
			if (empty($final_reason) && ($final_amount === NULL || $final_amount <= 0))
			{
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "💊 **Expense (Step 1/2):** What was the expense for?"
						: "💊 **অন্যান্য খরচ (ধাপ ১/২):** কী বাবদ খরচ হয়েছে?",
					'options' => $lang === 'en'
						? array('Medicine', 'Doctor Fee', 'Labor', 'Electricity', 'Transport', 'Cancel')
						: array('ওষুধ ও চিকিৎসা', 'ডাক্তার ফি', 'শ্রমিক মজুরি', 'বিদ্যুৎ বিল', 'পরিবহন ভাড়া', 'বাতিল'),
					'input_hint' => $lang === 'en' ? 'Or type expense reason...' : 'অথবা অন্য কোনো খাত লিখুন...',
					'input_unit' => '',
				);
			}
			if ($final_amount === NULL || $final_amount <= 0)
			{
				$r_lbl = $final_reason ? (' (**'.$final_reason.'**)') : '';
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "💰 **Step 2/2:** How much did it cost{$r_lbl}?"
						: "💰 **ধাপ ২/২:**{$r_lbl} বাবদ কত টাকা খরচ হয়েছে?",
					'options' => $lang === 'en'
						? array('200 tk', '500 tk', '1000 tk', '1500 tk', 'Cancel')
						: array('২০০ টাকা', '৫০০ টাকা', '১০০০ টাকা', '১৫০০ টাকা', 'বাতিল'),
					'input_hint' => $lang === 'en' ? 'Enter custom amount...' : 'অন্য কোনো পরিমাণ এখানে লিখুন...',
					'input_unit' => $lang === 'en' ? 'tk' : 'টাকা',
				);
			}
		}
		elseif ($intent === 'daily_feeding')
		{
			if ( ! $final_food)
			{
				$opts = $this->get_food_type_option_chips();
				$opts[] = $lang === 'en' ? 'Cancel' : 'বাতিল';
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "🌿 **Daily Feeding (Step 1/2):** Select which feed was given:"
						: "🌿 **দৈনিক খাদ্য (ধাপ ১/২):** কোন খাদ্যটি খাওয়ানো হয়েছে?",
					'options' => $opts,
				);
			}
			if ($final_kg === NULL || $final_kg <= 0)
			{
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? '⚖️ **Step 2/2:** How many KG of **'.$final_food['name'].'** was fed?'
						: '⚖️ **ধাপ ২/২:** কত কেজি **'.$final_food['name'].'** খাওয়ানো হয়েছে?',
					'options' => $lang === 'en'
						? array('5 kg', '10 kg', '15 kg', '20 kg', 'Cancel')
						: array('৫ কেজি', '১০ কেজি', '১৫ কেজি', '২০ কেজি', 'বাতিল'),
					'input_hint' => $lang === 'en' ? 'Enter custom KG...' : 'অন্য কোনো পরিমাণ এখানে লিখুন...',
					'input_unit' => $lang === 'en' ? 'kg' : 'কেজি',
				);
			}
		}
		elseif ($intent === 'food_purchase')
		{
			if ( ! $final_food)
			{
				$opts = $this->get_food_type_option_chips();
				$opts[] = $lang === 'en' ? 'Cancel' : 'বাতিল';
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? "🌾 **Feed Purchase (Step 1/3):** Which feed did you buy?"
						: "🌾 **খাদ্য ক্রয় (ধাপ ১/৩):** কোন খাদ্যটি কিনেছেন?",
					'options' => $opts,
				);
			}
			if ($final_kg === NULL || $final_kg <= 0)
			{
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? '⚖️ **Step 2/3:** How many KG of **'.$final_food['name'].'** did you buy?'
						: '⚖️ **ধাপ ২/৩:** কত কেজি **'.$final_food['name'].'** কিনেছেন?',
					'options' => $lang === 'en'
						? array('10 kg', '25 kg', '50 kg', '100 kg', 'Cancel')
						: array('১০ কেজি', '২৫ কেজি', '৫০ কেজি', '১০০ কেজি', 'বাতিল'),
					'input_hint' => $lang === 'en' ? 'Enter custom KG...' : 'অন্য কোনো পরিমাণ এখানে লিখুন...',
					'input_unit' => $lang === 'en' ? 'kg' : 'কেজি',
				);
			}
			if ($final_amount === NULL || $final_amount <= 0)
			{
				return array(
					'need_followup' => TRUE,
					'pending_state' => $state,
					'followup_question' => $lang === 'en'
						? '💰 **Step 3/3:** What was the total price for **'.$final_kg.' KG '.$final_food['name'].'**?'
						: '💰 **ধাপ ৩/৩:** **'.$final_kg.' কেজি '.$final_food['name'].'** এর মোট দাম কত টাকা?',
					'options' => $lang === 'en'
						? array('500 tk', '1000 tk', '2000 tk', 'Cancel')
						: array('৫০০ টাকা', '১০০০ টাকা', '২০০০ টাকা', 'বাতিল'),
					'input_hint' => $lang === 'en' ? 'Enter exact total price...' : 'অন্য কোনো টাকার পরিমাণ লিখুন...',
					'input_unit' => $lang === 'en' ? 'tk' : 'টাকা',
				);
			}
		}
		elseif ($intent === 'unknown' && $final_amount !== NULL && $final_amount > 0)
		{
			// User typed an amount + unfamiliar description (e.g. "বোনাস ৫০০ টাকা"): ask which category to save it into!
			$state['intent'] = 'choose_category';
			$desc_lbl = $final_reason ? ('**'.$final_reason.'** — ') : '';
			return array(
				'need_followup' => TRUE,
				'pending_state' => $state,
				'followup_question' => $lang === 'en'
					? "🤔 {$desc_lbl}**৳ ".money_fmt($final_amount)."**\nWhich section should I save this to?"
					: "🤔 {$desc_lbl}**৳ ".money_fmt($final_amount)."**\nএটি কোন খাতে সেভ করব? নিচে ক্লিক করুন:",
				'options' => $lang === 'en'
					? array('Add Income', 'Add Expense', 'Add Investment', 'Cancel')
					: array('নতুন আয়', 'অন্যান্য খরচ', 'নতুন বিনিয়োগ', 'বাতিল'),
			);
		}

		return array(
			'need_followup' => FALSE,
			'intent' => $intent,
			'food_type' => $final_food,
			'kg' => $final_kg,
			'amount' => $final_amount,
			'date' => $final_date,
			'reason' => $final_reason,
			'raw_msg' => $final_raw,
		);
	}

	private function detect_intent($norm, $food_type, $kg, $amount)
	{
		$is_sell_or_income = (bool) preg_match('/(বিক্রি|বিক্রয়|বেচলাম|বেচেছি|বেচছি|বেচসি|আয়|পেলাম|পাইছি|পাইসি|পাওয়া|দুধ|গোবর|জৈব সার|বস্তা|মাংস|ঘি|দই|bikri|bikroy|bechlam|bechechi|bechsi|bechchi|sell|selling|sells|sale|sold|income|earn|earned|revenue|dudh|doodh|milk|gobor|gobar|gobr|manure|dung|fertilizer|compost|bosta|sack|meat|beef|ghee|doi)/u', $norm);
		$is_buy = (bool) preg_match('/(কিনলাম|কিনেছি|কিনছি|কিনসি|কেনা|ক্রয়|আনলাম|আনছি|আনসি|kinlam|kinechi|kinsi|kinchi|kena|kroy|anlam|ansi|anchi|buy|buying|bought|purchase|purchased)/u', $norm);
		$is_feed_use = (bool) preg_match('/(খাওয়ালাম|খাইয়েছি|খাওয়াইছি|খাওয়াইসি|খাওয়ানো|দিলাম|দিয়েছি|দিছি|দিসি|ব্যবহার|দৈনিক|khawailam|khaiyechi|khawaisi|khawaichi|khawano|dilam|disi|dichi|feeding|fed|gave|daily)/u', $norm);
		$is_cow_or_invest = (bool) preg_match('/(গরু|গাভী|ষাঁড়|বাছুর|বকনা|খামার|শেড|ঘর|যন্ত্রপাতি|মোটর|মেশিন|বিনিয়োগ|মূলধন|পুঁজি|goru|gavi|gabhi|shar|bachur|bokna|khamar|ghor|muldhon|puji|biniyog|biniog|cow|cows|cattle|calf|calves|bull|ox|heifer|shed|barn|equipment|machine|motor|invest|investment|invested|capital|deposit)/u', $norm);
		$is_other_expense = (bool) preg_match('/(ডাক্তার|পশুচিকিৎসক|চিকিৎসা|ওষুধ|ঔষধ|ভ্যাকসিন|টিকা|ইনজেকশন|শ্রমিক|কর্মচারী|রাখাল|মজুরি|বেতন|বিদ্যুৎ|কারেন্ট|পানি|গ্যাস|বিল|পরিবহন|ট্রাক|ভ্যান|ভাড়া|মেরামত|পরিষ্কার|দড়ি|বালতি|সাবান|লবণ|ভিটামিন|ক্যালসিয়াম|খরচ|ব্যয়|doctor|dr|vet|veterinary|medicine|meds|drug|vaccine|vaccination|injection|treatment|labor|labour|worker|staff|salary|wage|electricity|electric|current|water|gas|fuel|bill|transport|truck|van|fare|rent|repair|maintenance|cleaning|rope|bucket|soap|salt|vitamin|calcium|expense|cost|spent|khoroch|khoroc|osudh|oshudh|oushudh|chikitsha|chikitsa|tika|sromik|majuri|mojuri|beton|bidyut|biddut|vara|bhara|meramot)/u', $norm);

		if ($food_type !== NULL)
		{
			if ($is_feed_use)
			{
				return 'daily_feeding';
			}
			if ($is_buy || $amount !== NULL)
			{
				return 'food_purchase';
			}
			if ($kg !== NULL && $amount === NULL)
			{
				return 'daily_feeding';
			}
			return 'food_purchase';
		}

		if ($is_feed_use || (bool) preg_match('/(খাদ্য দিলাম|খাবার দিলাম|খাদ্য খাওয়ালাম|দৈনিক খাদ্য|daily feed)/u', $norm))
		{
			return 'daily_feeding';
		}

		if ((bool) preg_match('/(খাদ্য কিনলাম|খাবার কিনলাম|খাদ্য ক্রয়|খাবার|খাদ্য|khabar|khaddo|feed buy|bought feed|feed purchase|\bfeed\b)/u', $norm))
		{
			return 'food_purchase';
		}

		if ($is_sell_or_income)
		{
			return 'income';
		}

		if ($is_cow_or_invest)
		{
			return 'investment';
		}

		if ($is_other_expense)
		{
			return 'other_expense';
		}

		return 'unknown';
	}

	private function detect_food_type($norm, $pending_intent = NULL)
	{
		// Do not match food types if user is currently answering income / other_expense / investment follow-up
		if (in_array($pending_intent, array('income', 'other_expense', 'investment'), TRUE))
		{
			return NULL;
		}

		$all_types = $this->food_type_model->get_all();
		$trimmed_norm = trim($norm);

		// 1. Exact match first
		foreach ($all_types as $ft)
		{
			$ft_name_low = trim(mb_strtolower($ft->name, 'UTF-8'));
			if ($ft_name_low !== '' && $ft_name_low === $trimmed_norm)
			{
				return array('id' => (int) $ft->id, 'name' => $ft->name);
			}
		}

		// 2. Longest name substring match first (skip generic "অন্যান্য" unless pending_intent is feed-related)
		$sorted_types = $all_types;
		usort($sorted_types, function($a, $b) {
			return mb_strlen($b->name, 'UTF-8') - mb_strlen($a->name, 'UTF-8');
		});

		foreach ($sorted_types as $ft)
		{
			$ft_name_low = trim(mb_strtolower($ft->name, 'UTF-8'));
			if ($ft_name_low === 'অন্যান্য' || $ft_name_low === 'other')
			{
				continue;
			}
			if ($ft_name_low !== '' && mb_strpos($norm, $ft_name_low) !== FALSE)
			{
				return array('id' => (int) $ft->id, 'name' => $ft->name);
			}
		}

		$synonyms = array(
			array(
				'keywords' => array('কাঁচা ঘাস', 'নেপিয়ার', 'ঘাস', 'ghas', 'ghash', 'grass', 'napier'),
				'default_name' => 'কাঁচা ঘাস',
				'match_db' => array('ঘাস', 'grass'),
			),
			array(
				'keywords' => array('গমের ভুসি', 'ডালের ভুসি', 'ভুসি', 'ভুষি', 'তুষ', 'vusi', 'vushi', 'bhusi', 'bran'),
				'default_name' => 'গমের ভুসি',
				'match_db' => array('ভুসি', 'ভুষি', 'bran'),
			),
			array(
				'keywords' => array('শুকনা খড়', 'খড়', 'খড়', 'বিচালি', 'khor', 'straw', 'hay'),
				'default_name' => 'খড়',
				'match_db' => array('খড়', 'খড়', 'straw'),
			),
			array(
				'keywords' => array('সরিষার খৈল', 'খৈল', 'খইল', 'khoil', 'oilcake', 'mustard cake'),
				'default_name' => 'খৈল',
				'match_db' => array('খৈল', 'খইল', 'cake'),
			),
			array(
				'keywords' => array('দানাদার', 'ফিড', 'ফীড', 'প্যাকেট ফিড', 'ডেইরি ফিড', 'danadar', 'dairy feed', 'pellet', 'concentrate'),
				'default_name' => 'দানাদার ফিড',
				'match_db' => array('দানাদার', 'ফিড', 'feed'),
			),
			array(
				'keywords' => array('ভুট্টা', 'ভাঙ্গা ভুট্টা', 'ভুট্টা ভাঙা', 'bhutta', 'vutta', 'corn', 'maize'),
				'default_name' => 'ভুট্টা ভাঙা',
				'match_db' => array('ভুট্টা', 'corn', 'maize'),
			),
			array(
				'keywords' => array('চিটাগুড়', 'চিটা গুড়', 'গুড়', 'molasses', 'chitagur'),
				'default_name' => 'চিটাগুড়',
				'match_db' => array('গুড়', 'চিটাগুড়', 'molasses'),
			),
		);

		foreach ($synonyms as $syn)
		{
			foreach ($syn['keywords'] as $kw)
			{
				if (mb_strpos($norm, $kw) !== FALSE)
				{
					foreach ($all_types as $ft)
					{
						$ft_low = mb_strtolower($ft->name, 'UTF-8');
						foreach ($syn['match_db'] as $mdb)
						{
							if (mb_strpos($ft_low, $mdb) !== FALSE)
							{
								return array('id' => (int) $ft->id, 'name' => $ft->name);
							}
						}
					}
					$new_id = $this->food_type_model->create(array(
						'name' => $syn['default_name'],
						'sort_order' => 10,
					));
					return array('id' => (int) $new_id, 'name' => $syn['default_name']);
				}
			}
		}

		return NULL;
	}

	private function extract_kg($norm)
	{
		if (preg_match('/(\d+(?:\.\d+)?)\s*(?:কেজি|কে\.জি|কজি|kg|kgs|kilogram)/u', $norm, $m))
		{
			return (float) $m[1];
		}
		if (preg_match('/(?:কেজি|kg)\s*(\d+(?:\.\d+)?)/u', $norm, $m))
		{
			return (float) $m[1];
		}
		return NULL;
	}

	private function extract_amount($norm)
	{
		if (preg_match('/(\d+(?:\.\d+)?)\s*(?:টাকায়|টাকায়|টাকার|টাকা|টাঃ|tk|taka|bdt|৳)/u', $norm, $m))
		{
			return (float) $m[1];
		}
		if (preg_match('/(?:৳|tk|taka|টাকা)\s*(\d+(?:\.\d+)?)/u', $norm, $m))
		{
			return (float) $m[1];
		}
		return NULL;
	}

	private function extract_all_numbers($norm)
	{
		if (preg_match_all('/\d+(?:\.\d+)?/', $norm, $matches))
		{
			return array_map('floatval', $matches[0]);
		}
		return array();
	}

	private function extract_date_info($norm)
	{
		$clean = $norm;
		$date = date('Y-m-d');
		$explicit = FALSE;

		if (preg_match('/\b(\d{4})-(\d{1,2})-(\d{1,2})\b/', $clean, $m))
		{
			$date = sprintf('%04d-%02d-%02d', (int) $m[1], (int) $m[2], (int) $m[3]);
			$clean = str_replace($m[0], ' ', $clean);
			$explicit = TRUE;
			return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
		}

		if (preg_match('/\b([0-3]?\d)[\/\-]([0-1]?\d)[\/\-](\d{4})\b/', $clean, $m))
		{
			$date = sprintf('%04d-%02d-%02d', (int) $m[3], (int) $m[2], (int) $m[1]);
			$clean = str_replace($m[0], ' ', $clean);
			$explicit = TRUE;
			return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
		}

		if (preg_match('/\b(\d+)\s*(?:দিন আগে|দিন পূর্বে|din age|din aage|days ago|day ago)\b/u', $clean, $m))
		{
			$days = (int) $m[1];
			if ($days > 0 && $days <= 365)
			{
				$date = date('Y-m-d', strtotime("-{$days} days"));
				$explicit = TRUE;
			}
			$clean = str_replace($m[0], ' ', $clean);
			return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
		}

		if (preg_match('/\b([0-3]?\d)\s*(?:তারিখে|তারিখ|তারিক|tarikhe|tarikh|tarik)\b/u', $clean, $m))
		{
			$day = (int) $m[1];
			if ($day >= 1 && $day <= 31)
			{
				$date = sprintf('%04d-%02d-%02d', (int) date('Y'), (int) date('m'), $day);
				$explicit = TRUE;
			}
			$clean = str_replace($m[0], ' ', $clean);
			return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
		}

		if (preg_match('/(?:তারিখে|তারিখ|তারিক|tarikhe|tarikh|tarik)\s*([0-3]?\d)\b/u', $clean, $m))
		{
			$day = (int) $m[1];
			if ($day >= 1 && $day <= 31)
			{
				$date = sprintf('%04d-%02d-%02d', (int) date('Y'), (int) date('m'), $day);
				$explicit = TRUE;
			}
			$clean = str_replace($m[0], ' ', $clean);
			return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
		}

		if (preg_match('/(গত পরশু|পরশুদিন|পরশু|goto porshu|porshudin|porshu|poroshu|day before yesterday)/u', $clean))
		{
			$date = date('Y-m-d', strtotime('-2 days'));
			$explicit = TRUE;
			return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
		}

		if (preg_match('/(গতকালকে|গতকাল|কালকে|গত কাল|yesterday|gotokalke|gotokal|goto kal|\bkalke\b|\bkal\b|কাল)/u', $clean))
		{
			$date = date('Y-m-d', strtotime('-1 day'));
			$explicit = TRUE;
			return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
		}

		return array('date' => $date, 'clean_text' => $clean, 'explicit' => $explicit);
	}

	private function clean_description($raw_msg, $default_bn, $default_en)
	{
		$desc = trim(preg_replace('/\s+/', ' ', (string) $raw_msg));
		if ($desc === '')
		{
			return cow_lang() === 'en' ? $default_en : $default_bn;
		}
		return mb_substr($desc, 0, 250, 'UTF-8');
	}

	private function execute_intent($parsed, $lang)
	{
		$intent = $parsed['intent'];
		$date = $parsed['date'];
		$raw_msg = $parsed['raw_msg'];

		if ($intent === 'investment')
		{
			$amount = (float) $parsed['amount'];
			$desc = $this->clean_description($raw_msg, 'বিনিয়োগ / গরু ক্রয়', 'Investment / Cattle Purchase');
			$id = $this->investment_model->create(array(
				'amount' => $amount,
				'investment_date' => $date,
				'description' => $desc,
			));

			$reply = $lang === 'en'
				? "✅ **Saved to Investments**\n• **Amount:** ৳ ".money_fmt($amount)."\n• **Date:** {$date}\n• **Note:** {$desc}"
				: "✅ **বিনিয়োগে সেভ হয়েছে**\n• **পরিমাণ:** ৳ ".money_fmt($amount)."\n• **তারিখ:** {$date}\n• **বিবরণ:** {$desc}";

			return array(
				'ok' => TRUE,
				'saved' => TRUE,
				'intent' => 'investment',
				'record_id' => (int) $id,
				'module' => t('investments'),
				'url' => site_url('investments'),
				'reply' => $reply,
				'fields' => array('amount' => $amount, 'kg' => 0, 'date' => $date, 'desc' => $desc),
			);
		}

		if ($intent === 'food_purchase')
		{
			$ft = $parsed['food_type'];
			$kg = (float) $parsed['kg'];
			$amount = (float) $parsed['amount'];
			$notes = $this->clean_description($raw_msg, '', '');
			if ($notes === $ft['name'])
			{
				$notes = '';
			}

			$id = $this->food_purchase_model->create(array(
				'food_type_id' => (int) $ft['id'],
				'quantity_kg' => $kg,
				'total_amount' => $amount,
				'purchase_date' => $date,
				'notes' => $notes ?: NULL,
			));

			$rate = $kg > 0 ? ($amount / $kg) : 0;
			$reply = $lang === 'en'
				? "✅ **Saved to Feed Purchases**\n• **Feed:** {$ft['name']}\n• **Quantity:** ".money_fmt($kg)." KG\n• **Cost:** ৳ ".money_fmt($amount)." (৳ ".money_fmt($rate)."/KG)\n• **Date:** {$date}"
				: "✅ **খাদ্য ক্রয়ে সেভ হয়েছে**\n• **খাদ্য:** {$ft['name']}\n• **পরিমাণ:** ".money_fmt($kg)." কেজি\n• **মোট দাম:** ৳ ".money_fmt($amount)." (৳ ".money_fmt($rate)."/কেজি)\n• **তারিখ:** {$date}";

			return array(
				'ok' => TRUE,
				'saved' => TRUE,
				'intent' => 'food_purchase',
				'record_id' => (int) $id,
				'module' => t('food_purchases'),
				'url' => site_url('food_purchases'),
				'reply' => $reply,
				'fields' => array('amount' => $amount, 'kg' => $kg, 'date' => $date, 'desc' => $notes),
			);
		}

		if ($intent === 'daily_feeding')
		{
			$ft = $parsed['food_type'];
			$kg = (float) $parsed['kg'];
			$notes = $this->clean_description($raw_msg, '', '');
			if ($notes === $ft['name'])
			{
				$notes = '';
			}

			$id = $this->daily_feeding_model->create(array(
				'food_type_id' => (int) $ft['id'],
				'quantity_kg' => $kg,
				'feeding_date' => $date,
				'notes' => $notes ?: NULL,
			));

			$reply = $lang === 'en'
				? "✅ **Saved to Daily Feeding**\n• **Feed:** {$ft['name']}\n• **Quantity:** ".money_fmt($kg)." KG\n• **Date:** {$date}"
				: "✅ **দৈনিক খাদ্যে সেভ হয়েছে**\n• **খাদ্য:** {$ft['name']}\n• **পরিমাণ:** ".money_fmt($kg)." কেজি\n• **তারিখ:** {$date}";

			return array(
				'ok' => TRUE,
				'saved' => TRUE,
				'intent' => 'daily_feeding',
				'record_id' => (int) $id,
				'module' => t('daily_feeding'),
				'url' => site_url('daily_feeding'),
				'reply' => $reply,
				'fields' => array('amount' => 0, 'kg' => $kg, 'date' => $date, 'desc' => $notes),
			);
		}

		if ($intent === 'income')
		{
			$amount = (float) $parsed['amount'];
			$desc = $this->clean_description($raw_msg, 'খামার থেকে আয়', 'Farm Income');
			$id = $this->income_model->create(array(
				'amount' => $amount,
				'income_date' => $date,
				'description' => $desc,
			));

			$reply = $lang === 'en'
				? "✅ **Saved to Incomes**\n• **Amount:** ৳ ".money_fmt($amount)."\n• **Date:** {$date}\n• **Description:** {$desc}"
				: "✅ **আয়ের তালিকায় সেভ হয়েছে**\n• **পরিমাণ:** ৳ ".money_fmt($amount)."\n• **তারিখ:** {$date}\n• **বিবরণ:** {$desc}";

			return array(
				'ok' => TRUE,
				'saved' => TRUE,
				'intent' => 'income',
				'record_id' => (int) $id,
				'module' => t('incomes'),
				'url' => site_url('incomes'),
				'reply' => $reply,
				'fields' => array('amount' => $amount, 'kg' => 0, 'date' => $date, 'desc' => $desc),
			);
		}

		if ($intent === 'other_expense')
		{
			$amount = (float) $parsed['amount'];
			$desc = $this->clean_description($raw_msg, 'অন্যান্য খরচ', 'Other Expense');
			$id = $this->other_expense_model->create(array(
				'amount' => $amount,
				'expense_date' => $date,
				'description' => $desc,
			));

			$reply = $lang === 'en'
				? "✅ **Saved to Other Expenses**\n• **Amount:** ৳ ".money_fmt($amount)."\n• **Date:** {$date}\n• **Description:** {$desc}"
				: "✅ **অন্যান্য খরচে সেভ হয়েছে**\n• **পরিমাণ:** ৳ ".money_fmt($amount)."\n• **তারিখ:** {$date}\n• **বিবরণ:** {$desc}";

			return array(
				'ok' => TRUE,
				'saved' => TRUE,
				'intent' => 'other_expense',
				'record_id' => (int) $id,
				'module' => t('other_expenses'),
				'url' => site_url('other_expenses'),
				'reply' => $reply,
				'fields' => array('amount' => $amount, 'kg' => 0, 'date' => $date, 'desc' => $desc),
			);
		}

		return array(
			'ok' => FALSE,
			'saved' => FALSE,
			'reply' => $this->build_unknown_reply($lang),
		);
	}

	private function build_stock_reply($lang)
	{
		$rows = $this->food_type_model->get_stock_summary();
		if (empty($rows))
		{
			return $lang === 'en' ? '📦 No feed types found.' : '📦 কোনো খাদ্যের ধরন পাওয়া যায়নি।';
		}
		$lines = array($lang === 'en' ? '📦 **Current Feed Stock:**' : '📦 **খাদ্যের বর্তমান মজুদ (স্টক):**');
		foreach ($rows as $r)
		{
			$stk = (float) $r->stock_kg;
			$icon = $stk <= 0 ? '🔴' : ($stk < 25 ? '🟡' : '🟢');
			$lines[] = $icon.' **'.$r->name.':** '.money_fmt($stk).' '.($lang === 'en' ? 'KG' : 'কেজি');
		}
		return implode("\n", $lines);
	}

	private function build_today_reply($lang)
	{
		$today = date('Y-m-d');
		$inc = $this->income_model->sum_amount_filtered($today, $today);
		$food = $this->food_purchase_model->sum_total_filtered($today, $today);
		$other = $this->other_expense_model->sum_amount_filtered($today, $today);
		$feed_kg = $this->daily_feeding_model->sum_quantity_filtered($today, $today);

		if ($lang === 'en')
		{
			return "📅 **Today's Report ({$today})**\n"
				."• **Feed Consumed:** ".money_fmt($feed_kg)." KG\n"
				."• **Today's Income:** ৳ ".money_fmt($inc)."\n"
				."• **Feed Bought:** ৳ ".money_fmt($food)."\n"
				."• **Other Expenses:** ৳ ".money_fmt($other);
		}

		return "📅 **আজকের রিপোর্ট ({$today})**\n"
			."• **খাদ্য খাওয়ানো হয়েছে:** ".money_fmt($feed_kg)." কেজি\n"
			."• **আজকের আয়:** ৳ ".money_fmt($inc)."\n"
			."• **আজকের খাদ্য ক্রয়:** ৳ ".money_fmt($food)."\n"
			."• **অন্যান্য খরচ:** ৳ ".money_fmt($other);
	}

	private function build_month_reply($lang)
	{
		$start = date('Y-m-01');
		$end = date('Y-m-t');
		$inc = $this->income_model->sum_amount_filtered($start, $end);
		$food = $this->food_purchase_model->sum_total_filtered($start, $end);
		$other = $this->other_expense_model->sum_amount_filtered($start, $end);
		$net = $inc - ($food + $other);

		if ($lang === 'en')
		{
			return "🗓️ **This Month (".date('F Y').")**\n"
				."• **Income:** ৳ ".money_fmt($inc)."\n"
				."• **Feed Purchases:** ৳ ".money_fmt($food)."\n"
				."• **Other Expenses:** ৳ ".money_fmt($other)."\n"
				."• **Net Profit/Loss:** ৳ ".money_fmt($net);
		}

		return "🗓️ **চলতি মাসের হিসাব (".cow_month_name((int) date('n'))." ".date('Y').")**\n"
			."• **মোট আয়:** ৳ ".money_fmt($inc)."\n"
			."• **খাদ্য ক্রয়:** ৳ ".money_fmt($food)."\n"
			."• **অন্যান্য খরচ:** ৳ ".money_fmt($other)."\n"
			."• **নেট লাভ/ক্ষতি:** ৳ ".money_fmt($net);
	}

	private function build_summary_reply($lang)
	{
		$inv = $this->investment_model->sum_total();
		$food = $this->food_purchase_model->sum_total();
		$other = $this->other_expense_model->sum_total();
		$inc = $this->income_model->sum_total();
		$net = $inc - ($food + $other);

		if ($lang === 'en')
		{
			return "📊 **Farm Summary**\n"
				."• **Total Investment:** ৳ ".money_fmt($inv)."\n"
				."• **Feed Purchases:** ৳ ".money_fmt($food)."\n"
				."• **Other Expenses:** ৳ ".money_fmt($other)."\n"
				."• **Total Income:** ৳ ".money_fmt($inc)."\n"
				."• **Net Profit/Loss:** ৳ ".money_fmt($net);
		}

		return "📊 **খামারের সংক্ষিপ্ত হিসাব**\n"
			."• **মোট বিনিয়োগ:** ৳ ".money_fmt($inv)."\n"
			."• **মোট খাদ্য ক্রয়:** ৳ ".money_fmt($food)."\n"
			."• **অন্যান্য খরচ:** ৳ ".money_fmt($other)."\n"
			."• **মোট আয়:** ৳ ".money_fmt($inc)."\n"
			."• **নেট লাভ/ক্ষতি:** ৳ ".money_fmt($net);
	}

	private function build_help_reply($lang)
	{
		if ($lang === 'en')
		{
			return "👋 Tap any category above for step-by-step entry, or write directly:\n"
				."• `Milk sale 1500 tk`\n"
				."• `Fed 15 kg grass`\n"
				."• `50 kg bran bought 2200 tk`\n"
				."• `Medicine cost 500 tk`";
		}

		return "👋 উপরের যেকোনো খাতে ক্লিক করে ধাপে ধাপে এন্ট্রি করুন, অথবা নিচে সরাসরি লিখুন:\n"
			."• `দুধ বিক্রি ১৫০০ টাকা`\n"
			."• `১৫ কেজি ঘাস খাওয়ালাম`\n"
			."• `৫০ কেজি ভুসি কিনলাম ২২০০ টাকা`\n"
			."• `ওষুধ খরচ ৫০০ টাকা`";
	}

	private function build_unknown_reply($lang)
	{
		if ($lang === 'en')
		{
			return "🤔 Please select a category button above or write like:\n"
				."• `Milk sale 1500 tk`\n"
				."• `50 kg bran 2200 tk`\n"
				."• `Fed 15 kg grass`";
		}

		return "🤔 অনুগ্রহ করে উপরের যেকোনো বাটনে ক্লিক করুন অথবা এভাবে লিখুন:\n"
			."• `দুধ বিক্রি ১৫০০ টাকা`\n"
			."• `৫০ কেজি ভুসি কিনলাম ২২০০ টাকা`\n"
			."• `১৫ কেজি ঘাস খাওয়ালাম`";
	}
}
