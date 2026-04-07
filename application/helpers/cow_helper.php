<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('money_fmt'))
{
	function money_fmt($amount)
	{
		return number_format((float) $amount, 2, '.', ',');
	}
}

/**
 * GET প্যারামিটার থেকে তারিখ ফিল্টার (সব / দিন / মাস / বছর)
 *
 * @param	CI_Input	$input
 * @return	array{filter:string,fd:string,fm:int,fy:int,start:?string,end:?string,label:string}
 */
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
		$label = 'সব তারিখ';

		if ($filter === 'day')
		{
			if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fd))
			{
				$start = $fd;
				$end = $fd;
				$label = 'নির্দিষ্ট দিন: '.$fd;
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
			$label = 'মাস: '.sprintf('%04d-%02d', $fy, $fm);
		}
		elseif ($filter === 'year')
		{
			$start = sprintf('%04d-01-01', $fy);
			$end = sprintf('%04d-12-31', $fy);
			$label = 'বছর: '.$fy;
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
