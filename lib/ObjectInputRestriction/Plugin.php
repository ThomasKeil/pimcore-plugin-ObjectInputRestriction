<?php

/**
 * This source file is subject to the new BSD license that is
 * available through the world-wide-web at this URL:
 * http://www.pimcore.org/license
 *
 * @copyright  Copyright (c) 2013 Weblizards GbR (http://www.weblizards.de)
 * @author     Thomas Keil <thomas@weblizards.de>
 * @license    http://www.pimcore.org/license     New BSD License
 */

if (!defined("OBJECTINPUTRESTRICTION_PLUGIN")) define("OBJECTINPUTRESTRICTION_PLUGIN", PIMCORE_PLUGINS_PATH.DIRECTORY_SEPARATOR."ObjectInputRestriction");
if (!defined("OBJECTINPUTRESTRICTION_VAR"))    define("OBJECTINPUTRESTRICTION_VAR", PIMCORE_WEBSITE_PATH . "/var/plugins/ObjectInputRestriction");


class ObjectInputRestriction_Plugin extends Pimcore_API_Plugin_Abstract implements Pimcore_API_Plugin_Interface {

  public static function needsReloadAfterInstall() {
      return true; // User muss neu geladen werden
  }

  public static function install() {
    if (!is_dir(OBJECTINPUTRESTRICTION_VAR)) mkdir(OBJECTINPUTRESTRICTION_VAR);

    foreach (array("classes.xml", "config.xml") as $config_file) {
      if (!file_exists(OBJECTINPUTRESTRICTION_VAR.DIRECTORY_SEPARATOR.$config_file)) {
        copy(OBJECTINPUTRESTRICTION_PLUGIN.DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR.$config_file, OBJECTINPUTRESTRICTION_VAR.DIRECTORY_SEPARATOR.$config_file);
      }
    }

    if (self::isInstalled()) {
        return "ObjectInputRestriction Plugin successfully installed.";
    } else {
        return "ObjectInputRestriction Plugin could not be installed";
    }
  }

  public static function uninstall() {
    // TODO: Remove stuff?

    if (!self::isInstalled()) {
        return "ObjectInputRestriction Plugin successfully uninstalled.";
    } else {
        return "ObjectInputRestriction Plugin could not be uninstalled";
    }
  }

  public static function isInstalled() {
    if (!is_dir(OBJECTINPUTRESTRICTION_VAR)) return false;
    if (!is_file(OBJECTINPUTRESTRICTION_VAR."/config.xml")) return false;
    return true;
  }

  public function preDispatch() {

  }

  /**
   *
   * @param string $language
   * @return string path to the translation file relative to plugin direcory
   */
  public static function getTranslationFile($language) {
    if(file_exists(PIMCORE_PLUGINS_PATH . "/ObjectInputRestriction/texts/" . $language . ".csv")){
      return "/ObjectInputRestriction/texts/" . $language . ".csv";
    }
    return "/ObjectInputRestriction/texts/de.csv";
  }

  /**
   * Hook called when maintenance script is called
   */
  public function maintenance() {

  }

}