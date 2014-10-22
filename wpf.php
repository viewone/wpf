<?php
/*
Plugin Name: Wordpress Framework
Plugin URI: http://www.viewone.pl/
Description: Framework for WordPress.
Version: 0.0.1alpha
Author: ViewOne Sp. z o.o.
Author URI: http://www.viewone.pl/
License: GPL
Copyright: ViewOne Sp. z o.o.
*/

require_once realpath(dirname(__FILE__) . '/vendor/autoload.php');

$modules = array(
    'WPCms\Menu' => array(
        'filters' => array('WpNavMenuObjects', 'WpNavMenuArgs')
    )
);

foreach ($modules as $class => $module) {
    
    foreach ($module['filters'] as $filter) {
        
        $filterName = strtolower(implode('_', preg_split('/(?=[A-Z])/', $filter, -1, PREG_SPLIT_NO_EMPTY)));
        $filterClass = '\\' . $class . '\\Filters\\' . $filter;
        $filterInstance = new $filterClass();
        
        $methods = get_class_methods($filterInstance);
        foreach ($methods as $method) {
            if(preg_match("/^.+Filter$/", $method)){
                add_filter( $filterName, array($filterInstance, $method) , 10, 2);
            }
        }
    }
    
    foreach ($module['actions'] as $action) {
        
        $actionName = strtolower(implode('_', preg_split('/(?=[A-Z])/', $action, -1, PREG_SPLIT_NO_EMPTY)));
        $actionClass = $class . '\\Actions\\' . $action;
        $actionInstance = new $actionClass();
        
        $methods = get_class_methods($actionInstance);
        foreach ($methods as $method) {
            if(preg_match("/^.+Action$/", $method)){
                add_action( $actionName, array($actionInstance, $method) , 10, 2);
            }
        }
    }
}