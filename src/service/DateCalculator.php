<?php

namespace Drupal\challenge\service;

class DateCalculator {
	public function calculator($date) {
		$day = 86400;		// number of seconds in a day
		// removes time of day from event time, so only days are left
		$temp = $date % $day;
		$date = $date - $temp;

		// gets current time
		$now = time();
		// removes time of day from current time, so only days are left
		$temp = $now % $day;
		$now = $now - $temp;

		// check if event is in the past
		if ($date < $now) {
			$out = 'The event has ended.';
		}
		// checks if event is in the future
		elseif ($date > $now) {
			// calculates days between current date and event date
			$diff = $date - $now;
			$days = round($diff / $day);
			$out = 'Days left to event start: '.$days;
		}
		else {
			$out = 'The event is in progress.';
		}

		$build = [];
		$build['#cache']['max-age'] = 0;
		$build['sample_block_extra_text']['#markup'] = $out;

		return $build;

	}
}