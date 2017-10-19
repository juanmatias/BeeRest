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

class vendorname extends securecall
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
     * get_endpoint endpoint
     * (rename it to your desired endpoint)
     * This sample forces connection to be GET
     */
     public function get_endpoint() {
       $r = $this->get_service();

       return $r;
     }

    /**
     * post_endpoint endpoint
     * (rename it to your desired endpoint)
     * This sample forces connection to be POST
     */
     public function post_endpoint() {
       $r = $this->post_service();

       return $r;
     }
 }
 ?>
