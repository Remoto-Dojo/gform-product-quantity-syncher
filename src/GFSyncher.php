<?php


namespace RemotoDojo\GFormProductInventorySyncher;

use GFAddOn;
use GFForms;

GFForms::include_addon_framework();

/**
 * Class GFSyncher
 *
 * @package RemotoDojo\GFormProductInventorySyncher
 */
class GFSyncher extends GFAddOn
{
    /**
    * {@inheritdoc}
    * @var string
    */
    protected $_version = '0.1.0';

    /**
    * {@inheritdoc}
    * @var string
    */
    protected $_min_gravityforms_version = '1.9';

    /**
    * {@inheritdoc}
    * @var string
    */
    protected $_slug = 'gform-product-inventory-syncher';

    /**
    * {@inheritdoc}
    * @var string
    */
    protected $_path = 'gform-product-inventory-syncher/GFSyncher.php';

    /**
    * {@inheritdoc}
    * @var string
    */
    protected $_full_path = __FILE__;

    /**
    * {@inheritdoc}
    * @var string
    */
    protected $_title = 'Gravity Forms Product with Quantity Limits GFSyncher';

    /**
    * {@inheritdoc}
    * @var string
    */
    protected $_short_title = 'Gravity Forms Product and Quantity Add-On';

    /**
    * @var object|null $_instance If available, contains an instance of this class.
    */
    private static $_instance = null;

    /**
     * {@inheritdoc}
     * @retun void
     */
    public function init()
    {
        add_action( 'gform_after_submission', 'gf_product_inventory_sync_process', 10, 2 );

        parent::init();
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

    /**
   * Returns an instance of this class, and stores it in the $_instance property.
   *
   * @return object $_instance An instance of this class.
   */
    public static function get_instance() {
        if ( self::$_instance === null ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}
