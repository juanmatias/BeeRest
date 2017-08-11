<?php
/**
 * Class dbservice | vendor/Modules/dbservice.php
 *
 * @package RESTful WebService Model
 * @author Juan Matias de la Camara Beovide <juanmatias@gmail.com>
 *
 */

 namespace Modules;

 /**
  * Class dbservice - Service to query database
  *
  * This class is intended to abstract service to query database.
  * It requires a DB_connect to do the queries
  *
  * @property DB_connect $db Instance of database connection
  *
  */

abstract class dbservice extends service
{

  protected $db = null;

  /**
  * Creates a DB_connect instance for the object
  */
  function __construct()
  {
    parent::__construct();
    $this->db = \DB_connect::getInstance();
  }

}
?>
