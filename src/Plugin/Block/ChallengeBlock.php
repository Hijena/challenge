<?php

namespace Drupal\challenge\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Challenge' Block.
 *
 * @Block(
 *   id = "challenge_block",
 *   admin_label = @Translation("Challenge block"),
 *   category = @Translation("Challenge"),
 * )
 */
class ChallengeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */


	public function build() {
		$node = \Drupal::routeMatch()->getParameter('node');
		$day = 86400;		// number of seconds in a day
		// gets value from date field and converts it into  unix timestamp
		$date = strtotime($node->get('field_event_date')->value);
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

		// returns correct output
		$build = [];
		$build['#cache']['max-age'] = 0;
		$build['sample_block_extra_text']['#markup'] = $out;
		return $build;
	}

}