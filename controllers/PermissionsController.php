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


class ObjectInputRestriction_PermissionsController extends Pimcore_Controller_Action_Admin {

  public function getAction() {
    $object_id = $this->_getParam("id");

    $object = Object_Abstract::getById($object_id);

    $class = Object_Class::getById($object->getO_classId());

    $class_name = strtolower($class->getName());

    $classesXML = ObjectInputRestriction_Config::getInstance();
    $classDOM = $classesXML->getClasses();

    $user = Pimcore_Tool_Admin::getCurrentUser();

    $field_information = array();
    foreach ($classDOM->$class_name->children() as $input_field_node) {
      $attributes = array();
      foreach ($input_field_node->attributes() as $key => $value) $attributes[$key] = $value->__toString();
      $allowed = true;
      if ($attributes["allowed_users"] != "" ||  $attributes["allowed_roles"] != "") {
      $users = explode(",", $attributes["allowed_users"]);
      $roles = explode(",", $attributes["allowed_roles"]);
        $allowed = in_array($user->getId(), $users);
        foreach ($user->getRoles() as $role) {
          /**
           * @var User_Role $role
           */
          $allowed |= in_array($role->getId(), $roles);
        }
      }


      $field_information[$attributes["name"]] = $allowed;
    }

    $this->_helper->json($field_information);
  }


}