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
		$date = strtotime($node->get('field_event_date')->value);
		$now = time();
		$day = 86400;
		$temp = $now % $day;
		$now = $now - $temp;
		$temp = $date % $day;
		$date = $date - $temp;

		if ($date < $now) {
			$out = 'The event has ended.';
		}
		elseif ($date > $now) {
			$diff = $date - $now;
			$days = round($diff / $day);
			$out = 'Days left to event start: '.$days;
		}
		else {
		  $out = 'The event is in progress.';
		}

		$build = [];
		$build['sample_block_extra_text']['#markup'] = $out;
		return $build;
	}

}