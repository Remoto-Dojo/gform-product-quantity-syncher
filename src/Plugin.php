<?php
/**
 * The main plugin file.
 *
 * @author  Joemar Tagpuno <joemartagpuno@remotodojo.com>
 * @package RemotoDojo\GFormProductInventorySyncher
 */

namespace RemotoDojo\GFormProductInventorySyncher;

use GFAddOn;

/**
 * Class Plugin
 *
 * @author  Joemar Tagpuno <joemartagpuno@remotodojo.com>
 * @package RemotoDojo\GFormProductInventorySyncher
 */
class Plugin {
	/**
	 * Initialize the plugin's processes.
   *
	 * @return void
	 */
	public function run() {

    if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
      return;
    }

    // Registers an addon so that it gets initialized appropriately
    GFAddOn::register( Syncher::class );

	}
}
