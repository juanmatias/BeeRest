<?php
/**
 * Config file | config/config.php
 *
 * @package RESTful WebService Model
 * @author Juan Matias de la Camara Beovide <juanmatias@gmail.com>
 *
 */

define('ROOT_DIR',getcwd().'/');
define('DB_HOST','localhost');
define('DB_NAME','pentatistics');
define('DB_USR','pentatistics');
define('DB_PWD','pentatistics');

// set autoload for classes (and its order)
$classesDir = array (
    ROOT_DIR.'core/',
    ROOT_DIR.'vendor/',
);





?>
