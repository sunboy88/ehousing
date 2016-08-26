<?php

/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 2.1
 * @revision 917
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2014 by CodeGravity.com - All rights reserved!
 * @website http://www.extrawatch.com
 */

/** ensure this file is being included by a parent file */
if (!defined('_JEXEC') && !defined('_VALID_MOS'))  {
  die('Restricted access');
}

class ExtraWatchDBWrapPrestaShop implements ExtraWatchDBWrap
{

  public $query;
  public $dbref;
  public $result;
  public $dbprefix;
  public $errNum;
  public $errMsg;

  function ExtraWatchDBWrapPrestaShop()
  {
    $this->dbref = Db::getInstance();
    $this->dbprefix = _DB_PREFIX_;
  }

  function __destruct()
  {
    //return mysql_close($this->dbref);
  }

  function getEscaped($sql)
  {
    return $sql;
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
      $return = @$row['value'];
    }
    return $return;
  }

  function select($database)
  {
    if (!$database) {
      return FALSE;
    }
    if (!mysql_select_db($database, $this->dbref)) {
      die ('Could not connect to database');
      return FALSE;
    }
    return TRUE;
  }

  function setQuery($query)
  {
    $this->query = $query;
  }

  function getErrorNum()
  {
    return $this->errNum;
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
    return str_replace("#__", $this->dbprefix, $sql);
  }

  function loadObjectList($key = '')
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


