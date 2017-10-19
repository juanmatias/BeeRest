<?php
/**
 * Class getitemstest | vendor/Modules/getitemstest.php
 *
 * @package RESTful WebService Model
 * @author Juan Matias de la Camara Beovide <juanmatias@gmail.com>
 *
 */

 namespace Modules;

 /**
  * Class getitemstest - Sample Service
  *
  * 
  *
  */

class getitemstest extends dbservice
{
  /**
  * Fills the valid_actions with this object's actions
  */
  function __construct()
  {
    parent::__construct();
    $this->add_actions(array('activity'));
  }


  public function activity($params,$request)
  {

    $time = 10;
    $response = array('lastname' => '', 'qty' => 0, 'true' => 0);

    $sql = 'select count(*) as qty from  pm_options where categories_id = 1 AND time > DATE_SUB(now(),INTERVAL '.$time.' MINUTE);';
    $this->db->queryPrep($sql);
    if(!$r = $this->db->queryExe())
    {
      return null;
    }
    else
    {
      $r = $this->db->getResults();

      $row = $r->fetch_assoc();

      $true = 0;
      if($row['qty']!='0')
      {
        $true = 1;
      }

      $response['qty'] = $row['qty'];
      $response['true'] = $true;
    }

    $sql = 'select nickname, selected_option as color from  pm_options where categories_id = 1 order by time DESC limit 1;';

    $this->db->queryPrep($sql);
    if(!$r = $this->db->queryExe())
    {
      return null;
    }
    else
    {
      $r = $this->db->getResults();

      $row = $r->fetch_assoc();

      $response['lastcolor'] = $row['color'];


    }

    $sql = 'select nickname, selected_option as color from  pm_options where categories_id = 1 AND nickname is not null order by time DESC limit 1;';

    $this->db->queryPrep($sql);
    if(!$r = $this->db->queryExe())
    {
      return null;
    }
    else
    {
      $r = $this->db->getResults();

      $row = $r->fetch_assoc();

      $response['lastname'] = $row['nickname'];


    }
    return $response;
  }

}

 ?>
