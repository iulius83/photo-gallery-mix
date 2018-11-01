<?php
// If it's going to need the database then it's probably smart to require it before we start
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {

  // common database methods
  public static function find_all() {
        return static::find_by_sql("SELECT * FROM ".static::$table_name);
      }

  public static function find_by_id($id=0) {
        global $database;

        $result_array = self::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
      }

  public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
          $object_array[] = self::instantiate($row);
        }
        return $object_array;
      }

  public static function count_all() {
    global $database;
    $sql = "SELECT COUNT(*) FROM ".static::$table_name;
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    return array_shift($row);

  }

  private static function instantiate($record) {
        //simple, long approach
        $class_name = get_called_class();
        $object = new $class_name;
        // $object->id = $record['id'];
        // $object->username = $record['username'];
        // $object->password = $record['password'];
        // $object->first_name = $record['first_name'];
        // $object->last_name = $record['last_name'];
        //more dynamic approach
        foreach($record as $attribute=>$value) {
          if($object->has_attribute($attribute)) {
            $object->$attribute = $value;
          }
        }
        return $object;
      }

  private function has_attribute($attribute) {
          // get_object_vars returns an associative array with all attributes
          // (incl. private ones!) as the keys and their current values as the values
          //$object_vars = $this->attributes();
          // we don't care about value, we just want to iknow if the key exists
          // will return true or false
    return array_key_exists($attribute, $this->attributes());
  }

  protected function attributes() {
      // return an array of attribute keys and their values
      $attributes = array();
      foreach(static::$db_fields as $field) {
        if(property_exists($this, $field)) {
          $attributes[$field] = $this->$field;
        }
      }
      return $attributes;
  }

  protected function sanitized_attributes() {
      global $database;
      $clean_attributes = array();
    // sanitize the values before submitting
    // Note: does not alter the actual value of each attribute
      foreach($this->attributes() as $key => $value) {
        $clean_attributes[$key] = $database->escape_value($value);
      }
      return $clean_attributes;
  }

  public function create() {
        global $database;
      // Don't forget your SQL syntex and good habits:
      // - INSERT INTO table (key, key) VALUES ('value', 'value')
      // - single quotes around all values
      // - escape all values to prevent SQL injection

        // old version
          // $sql = "INSERT INTO photographs (";
          // $sql .= "filename, type, size, caption";
          // $sql .= ") VALUES ('";
          // $sql .= $database->escape_value($this->filename) ."', '";
          // $sql .= $database->escape_value($this->type) ."', '";
          // $sql .= $database->escape_value($this->size) ."', '";
          // $sql .= $database->escape_value($this->caption) ."')";

        // abstracted new version
        $attributes = $this->sanitized_attributes();
        unset($attributes[id]);
        $sql = "INSERT INTO " .static::$table_name. " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        if($database->query($sql)) {
          $this->id = $database->insert_id();
          return true;
        } else {
          return false;
        }
      }

  public function update() {
        global $database;
        // Don't forget your SQL syntex and good habits:
        // - UPDATE table SET key='value', key='value' WHERE condition
        // - single quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
          $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
      }

  public function delete() {
        global $database;
        // Don't forget your SQL syntex and good habits:
        // - DELETE FROM table WHERE condition LIMIT 1
        // - use LIMIT 1 !!
        // - escape all values to prevent SQL injection
        $sql = "DELETE FROM ".static::$table_name;
        $sql .= " WHERE id=" . $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
      }

}

?>
