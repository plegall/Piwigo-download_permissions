<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class download_permissions_maintain extends PluginMaintain
{
  private $installed = false;
  
  private $default_conf = array();

  function install($plugin_version, &$errors=array())
  {
    global $conf, $prefixeTable;

    // create categories.downloadable (true/false)
    $result = pwg_query('SHOW COLUMNS FROM `'.CATEGORIES_TABLE.'` LIKE "downloadable";');
    if (!pwg_db_num_rows($result))
    {
      pwg_query('ALTER TABLE `'.CATEGORIES_TABLE.'` ADD `downloadable` enum("true", "false") DEFAULT "true";');
    }

    $this->installed = true;
  }

  function activate($plugin_version, &$errors=array())
  {
    if (!$this->installed)
    {
      $this->install($plugin_version, $errors);
    }
  }

  function deactivate()
  {
  }

  function uninstall()
  {
    global $prefixeTable;
    
    pwg_query('ALTER TABLE '.CATEGORIES_TABLE.' DROP COLUMN downloadable;');
  }
}
