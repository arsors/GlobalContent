<?php
/*
 * Arsors.GlobalContent is written by Marvin Schieler
 * © 2020 until today
 *
 * The following people improved this package:
 * - Here could be your name
 *
 * */

namespace Arsors\GlobalContent\EelHelper;

use Neos\Eel\ProtectedContextAwareInterface;

class GlobalContent implements ProtectedContextAwareInterface {

  /**
   * Generate Global Content Array
   *
   * @param array $groups
   * @param array $properties
   * @return array
   */
  public function generateGlobalContentArray($groups, $properties)
  {
    // Set group array if no group set
    if (!isset($groups)) $groups = [];

    // Init variables
    $defaultKey = 'default';
    $defaultLabel = 'General';
    $defaultCollapsed = false;
    $defaultIcon = 'file';
    $skipProperties = ['metaRobotsNoindex', 'metaRobotsNofollow', '_hiddenInIndex'];

    // Create group array and add properties
    foreach($groups as $key => $value) {
      $group = $key;
      if (!isset($value['collapsed'])) $groups[$key]['collapsed'] = $defaultCollapsed;
      if (!isset($value['icon'])) $groups[$key]['icon'] = $defaultIcon;
      $groups[$key]['properties'] = [];
    }

    // Create default group if not exist
    if (!isset($groups[$defaultKey])) {
      $groups[$defaultKey] = [
        'label' => $defaultLabel,
        'collapsed' => $defaultCollapsed,
        'icon' => $defaultIcon,
        'properties' => []
      ];
    }

    // Sort properties into groups
    foreach($properties as $propKey => $propValue) {
      // Skip if key is not a editable property
      if (in_array($propKey, $skipProperties)) continue;

      // Add missing properties to property
      if (!isset($propValue['ui'])) $propValue['ui'] = ['group' => $defaultKey];
      if (!isset($propValue['ui']['group'])) $propValue['ui']['group'] = $defaultKey;

      // Append property to correct group
      $groups[$propValue['ui']['group']]['properties'][$propKey] = $propValue;
    }

    return $groups;
  }

  /**
   * All methods are considered safe, i.e. can be executed from within Eel
   *
   * @param string $methodName
   * @return boolean
   */
  public function allowsCallOfMethod($methodName) {
    return true;
  }
}