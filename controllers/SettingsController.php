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


class ObjectInputRestriction_SettingsController extends Pimcore_Controller_Action {

  public function getdataAction() {
    $class_id = $this->_getParam("id");


    $list = new User_List();
    $list->load();

    $users = array();
    if(is_array($list->getUsers())){
      foreach ($list->getUsers() as $user) {
        /**
         * @var User $user
         */
        $users[] = array(
          "id" => $user->getId(),
          "value" => ltrim($user->getFirstname()." ".$user->getLastname()." (".$user->getEmail().")")
        );
      }
    }

    $list = new User_Role_List();
    $list->load();

    $roles = array();
    if(is_array($list->getRoles())){
      foreach ($list->getRoles() as $role) {
        /**
         * @var User_Role $role
         */
        $roles[] = array(
          "id" => $role->getId(),
          "value" => ltrim($role->getName())
        );
      }
    }

    $class = Object_Class::getById($class_id);

    $class_name = strtolower($class->getName());

    $classesXML = ObjectInputRestriction_Config::getInstance();
    $classDOM = $classesXML->getClasses();

    $field_information = array();
    if ($classDOM->$class_name) {
      foreach ($classDOM->$class_name->children() as $input_field_node) {
        $attributes = array();
        foreach ($input_field_node->attributes() as $key => $value) $attributes[$key] = $value->__toString();
        $field_information[$attributes["name"]] = array(
          "users" => $attributes["allowed_users"],
          "roles" => $attributes["allowed_roles"]
        );
      }
    }

    $response = array(
      "users" => $users,
      "roles" => $roles,
      "fields" =>  $field_information
    );
    $this->_helper->json($response);
  }

  public function saveAction() {
    $class = Object_Class::getById(intval($this->getParam("id")));
    $class_config = Zend_Json::decode($this->getParam("configuration"));

    $class_name = strtolower($class->getName());

    $classesXML = ObjectInputRestriction_Config::getInstance();

    $classDOM = $classesXML->getClasses();

    unset($classDOM->$class_name);
    $classDOM->addChild($class_name);

    $this->setValues($class_config, $class_name, $classDOM);

    if ($classDOM->$class_name->count() == 0) unset($classDOM->$class_name); // remove empty classes


    $classesXML->writeClassesXml();

    $this->_helper->json(array("success" => true, "config" => $class_config));
  }

  private function setValues($class_config, $class_name, $classDOM) {
    if (array_key_exists("childs", $class_config) && is_array($class_config["childs"])) {

      foreach ($class_config["childs"] as $child) {
        $this->setValues($child, $class_name, $classDOM);
        $field_type = $child["fieldtype"];
        if (in_array($field_type, array("input", "checkbox", "date", "datetime", "numeric", "textarea", "time", "select", "superboxselect", "wysiwyg"))) {
          $fieldNode = $classDOM->$class_name->addChild("inputfield");
          $fieldNode->addAttribute("name", $child["name"]);
          $fieldNode->addAttribute("allowed_users", $child["allowed_users"]);
          $fieldNode->addAttribute("allowed_roles", $child["allowed_roles"]);

        }
      }
    }
  }

}