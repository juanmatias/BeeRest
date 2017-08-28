<?php
/**
 * Class vendorname | vendor/vendorname/vendorname.php
 *
 * @package RESTful WebService Model
 * @author Juan Matias de la Camara Beovide <juanmatias@gmail.com>
 *
 */

 /**
  * Class vendorname
  * rename it to your custom API class name (change /api.php and config/config.php)
  *
  */

class vendorname extends API
{
    /**
    * class constructor, verifies pair (apikey,origin) to allow access
    * @param request $request The request
    * @param string $origin The request origin
    */
    public function __construct($request, $origin) {
        parent::__construct($request, $origin);

    }

    /**
     * endpoint endpoint
     * (rename it to your desired endpoint)
     */
     public function endpoint() {
       $r = $this->processRequest();

       return $r;
     }
 }
 ?>
