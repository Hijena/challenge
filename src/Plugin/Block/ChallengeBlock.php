<?php

namespace Drupal\challenge\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\challenge\service\DateCalculator;

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
		if ($node = \Drupal::routeMatch()->getParameter('node')) {
    		if ($node->hasField('field_event_date')) {
    			$node = \Drupal::routeMatch()->getParameter('node');
				// gets value from date field and converts it into  unix timestamp
				$date = strtotime($node->get('field_event_date')->value);

				$dateCalculator = new DateCalculator();
				$response = $dateCalculator->calculator($date);

				$build = [];
				$build['#cache']['max-age'] = 0;
				$build['sample_block_extra_text']['#markup'] = $response;
				return $build;
			}
		}
		
	}

}