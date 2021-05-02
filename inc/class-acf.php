<?php


namespace ThfoIntranet\acf;

use function in_array;
use function remove_filter;
use const MC_DIR_PATH;

class acf {

	// list of field group IDs
	private $groups = array(
		'group_608d844a68c7a',
	);

	public function __construct() {
		add_action( 'acf/update_field_group', [ $this, 'mc_update_field_group' ], 1, 1);
		add_filter( 'acf/settings/load_json', [ $this, 'mc_json_load' ] );
	}

	// action on field group updated
	public function mc_update_field_group( $group ) {
		// called when ACF save the field group to the DB
		if ( in_array( $group['key'], $this->groups ) ) {
			// if it is one of my groups then add a filter on the save location
			// high priority to make sure it is not overrridded, I hope
			add_filter('acf/settings/save_json', [ $this, 'mc_override_location' ], 9999);
			add_filter('acf/settings/l10n_textdomain', [ $this, 'acf_textdomain'], 9999 );
		}
		return $group;
	}

	// override field group json
	public function mc_override_location( $path ) {
		// remove this filter so it will not effect other goups
		remove_filter( 'acf/settings/save_json', [ $this, 'mc_override_location' ], 9999);
		// override save path
		$path = THFO_INTRANET_PLUGIN_PATH . 'acf-json';
		return $path;
	}

	// include json files
	public function mc_json_load( $paths ) {
		$paths[] = THFO_INTRANET_PLUGIN_PATH . 'acf-json';
		return $paths;
	}

	public function acf_textdomain($domain) {
		if ( in_array( $this->group['key'], $this->groups ) ) {
			return 'thfo-intranet';
		}
		return $domain;
	}

}
global $thfo_intranet_acf;

if ( ! isset( $thfo_intranet_acf ) ) {
	$thfo_intranet_acf = new acf();
}