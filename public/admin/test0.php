<?php
include('../layouts/admin_header.php') ?>
<?php

class Photograph {

  public static $db_fields = array('id', 'filename', 'type', 'size', 'caption');

  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;

  public function attributes() {
        // return an array of attribute keys and their values

          $attributes = array();
          foreach(self::$db_fields as $field) {
            if(property_exists($this, $field)) {
              $attributes[$field] = $this->$field;
            }
          }
          return $attributes;
        // return get_object_vars($this);
      }


}

$attributes = new Photograph();
$attributes->attributes($attributes)
?>
<p>attributes: <?php print_r($attributes); ?></p>


<?php include('../layouts/admin_footer.php') ?>
