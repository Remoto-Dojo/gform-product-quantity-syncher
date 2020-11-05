<?php


namespace RemotoDojo\GFormProductInventorySyncher;

use GFAddOn;
use GFAPI;
use GFCommon;
use GFFormDisplay;
use GFForms;
use GFFormsModel;

GFForms::include_addon_framework();

/**
 * Class Syncher
 *
 * @package RemotoDojo\GFormProductInventorySyncher
 */
class Syncher extends GFAddOn
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
  protected $_path = 'gform-product-inventory-syncher/Syncher.php';

  /**
   * {@inheritdoc}
   * @var string
   */
  protected $_full_path = __FILE__;

  /**
   * {@inheritdoc}
   * @var string
   */
  protected $_title = 'Gravity Forms Product with Quantity Limits Syncher';

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
