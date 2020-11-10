<?php
/**
 * The main plugin file.
 *
 * @author  Joemar Tagpuno <joemartagpuno@remotodojo.com>
 * @package RemotoDojo\GFormProductInventorySyncher
 */

namespace RemotoDojo\GFormProductInventorySyncher;

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

        if ( ! method_exists( \GFForms::class, 'include_addon_framework' ) ) {
            return;
        }

        add_action( 'gform_after_submission', 'gf_product_inventory_sync_process', 10, 2 );

        // Registers an addon so that it gets initialized appropriately
       \GFAddOn::register( GFSyncher::class );

	}

    public function gf_product_inventory_sync_process($entry, $form)
    {
        $form_id = (int) $entry['form_id'];
        foreach ( $form['fields'] as $field ) {
            $inputs = $field->get_entry_inputs();
            if ( is_array( $inputs ) && isset($inputs[2], $field['type']) && $field['type'] === "product" ) {
                $field_id = (string) $inputs[2]['id'];
                $value = (int) rgar( $entry, $field_id );
                if ($value && $value > 0) {
                    global $wpdb;
                    $table_name = \GFLimitData::get_limit_table_name();
                    $sql = sprintf(
                        'UPDATE %s SET `quantity_limit` = quantity_limit - %d WHERE `form_id` = %d AND CAST(field_id as unsigned) = %s LIMIT 1',
                        $table_name,
                        $value,
                        $form_id,
                        floor($field_id)
                    );
                    $wpdb->query($sql);
                }
            }
        }
    }
}

/**
 * Obtains and returns an instance of the GFSyncher class
 *
 * @return object GFSyncher
 *@uses GFSyncher::get_instance()
 *
 * @since  1.0.0
 * @access public
 *
 */
function gf_syncher() {
    return GFSyncher::get_instance();
}
