<?php 
namespace app\lib\wow;
 
class Common {
  public static function random_slug($num = 6) {
    $parts = 'abcefghijklmnopqrstuvwxyz1234567890';
    return substr(str_shuffle($parts), 0, $num);
  }
}

?>