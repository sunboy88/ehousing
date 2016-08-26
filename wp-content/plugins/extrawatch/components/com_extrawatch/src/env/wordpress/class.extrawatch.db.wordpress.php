<?php

/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 2.3
 * @revision 2650
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2016 by CodeGravity.com - All rights reserved!
 * @website http://www.extrawatch.com
 */

defined('_JEXEC') or die('Restricted access');

class ExtraWatchDBWrapWordpress implements ExtraWatchDBWrap
{

  public $query;
  public $dbref;
  public $result;
  public $dbprefix;
  public $errNum;
  public $errMsg;

  function __construct()
  {
      global $wpdb;
      $host = $wpdb->dbhost;
      $user = $wpdb->dbuser;
      $password = $wpdb->dbpassword;
      $database = $wpdb->dbname;
      $this->dbprefix = $wpdb->base_prefix;
      $driver = "mysql";
      try {
          $this->dbref = new PDO("$driver:host=$host;dbname=$database", $user, $password, array(
              PDO::ATTR_PERSISTENT => true)
          );
          if (!$this->dbref) {
              throw new Exception("PDO connection not established");
          }
      } catch (Exception $e) {
          error_log("ExtraWatch could not connect using PDO database driver:". $e->getTraceAsString());
          echo nl2br("ERROR: ExtraWatch could not connect using PDO database driver, check your web server error logs for more details\n");
      }
  }

  function __destruct()
  {
    //return @mysqli_close($this->dbref);
  }

  function getEscaped($sql)
  {
    global $wpdb;
    return $wpdb->_real_escape($sql);
  }


  function query()
  {
    $sql = $this->query;
    $sql = $this->replaceDbPrefix($sql);
    $STH = $this->dbref->query($sql);
    if (!$STH) {
      return null;
    }
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $result = $STH->fetch();
    return $result;
  }

  function loadResult()
  {
    $this->query = $this->replaceDbPrefix($this->query);
    $STH = $this->dbref->query($this->query);
    if (!$STH) {
      return null;
    }
    $STH->setFetchMode(PDO::FETCH_ASSOC);

    $return = null;
    if ($row = $STH->fetch()) {
      $return = @$row['value'];
      if (!$return) {
        $key = @key($row);
        $return = @$row[$key];
      }
    }
    return $return;
  }


  function loadAssocList($key = '')
  {
    $this->query = $this->replaceDbPrefix($this->query);
    $STH = $this->dbref->query($this->query);
    $STH->setFetchMode(PDO::FETCH_ASSOC);

    $return = null;
    if ($row = $STH->fetchAll()) {
      $return = @$row;
    }
    return $return;
  }

  function setQuery($query)
  {
    ExtraWatchLog::debug("setQuery: $query");
    $this->query = $query;
  }

  function getErrorNum()
  {
    return $this->errNum;
  }

  function getErrorMsg()
  {
    return $this->errMsg;
  }

  function objectListQuery($query)
  {
    $this->query = $query;
    return $this->loadObjectList();
  }

  function getQuery()
  {
    return $this->query;
  }

  function resultQuery($query)
  {
    $this->query = $query;
    $this->setQuery($query);
    return $this->loadResult();
  }

  function executeQuery($query)
  {
    $this->query = $query;
    return $this->query();
  }

  function assocListQuery($query)
  {
    $this->query = $query;
    return $this->loadAssocList();
  }

  function replaceDbPrefix($sql)
  {
    ExtraWatchLog::debug("$sql");
    return str_replace("#__", $this->dbprefix, $sql);
  }


  private function loadObjectList($key = '')
  {
    $sql = $this->replaceDbPrefix($this->query);
    $STH = $this->dbref->query($sql);
    if (!$STH) {
      return null;
    }
    $STH->setFetchMode(PDO::FETCH_OBJ);
    $result = $STH->fetchAll();
    return $result;
  }
}


