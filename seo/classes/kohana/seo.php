<?php defined('SYSPATH') or die('No direct script access.');

 /**
  * SEO - friendly url
  * 
  * This class must use PHP 5.3.0 or higher
  * because it used "Late Static Bindings" http://www.php.net/manual/en/language.oop5.late-static-bindings.php
  * 
  * @author Wojciech Bruggemann
 */

class Kohana_SEO {
    
    /**
     * Here you define a connection between the key and pair controller-action and friendly url
     * Example:
     * array(
            1 => array('welcome' => array('index' => 'welcome-to-our-website')),
            2 => array('test'    => array('index' => 'test-test-test')),
        );
     * 
     * Only the key identifies pair controller-action,
     * so a title can be freely changed in the future
     */
    static protected $map = array();
    

    /**
     * Get controller and action from friedly url
     * 
     * @param   string url
     * @return  mixed
     */
    static public function get_controller_action($uri)
    {
        if (preg_match('/-(\d+)$/', $uri, $w))
        {
            $key = $w[1];
            
            if (isset(static::$map[$key]))
            {
                $controller = key(static::$map[$key]);
                $action = key(static::$map[$key][$controller]);
                
                return array($controller, $action);
            }
            else
                return null;
        }
        else
            return null;
    }
    
    /**
     * Create friedly url from controller and action
     * 
     * @param  string  controller
     * @param  string  action
     * @return string  friendly-url
     */
    static public function friendly_url($controller, $action)
    {
        /**
         * table of friendly-url
         * where first key is controller and second key is action
         */
        static $map_key;
        
        if ( ! isset($map_key))
        {
            foreach (static::$map as $key => $value)
            {
                $c = key($value);
                $a = key($value[$c]);
                $map_key[$c][$a] = $value[$c][$a].'-'.$key;
            }
        }
        
        return
            isset($map_key[$controller][$action]) ? urlencode($map_key[$controller][$action]) : null;
    }
}
