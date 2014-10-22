<?php

namespace WPF\Validator\Wordpress;

use \Zend\Validator\ValidatorInterface;

/**
 * Confirms a record does not exist in a table.
 */
class Password extends \Zend\Validator\AbstractValidator implements
    ValidatorInterface
{
    
    /**
     * Error constants
     */
    const ERROR_INCORRECT_PASSWORD = 'incorrectPassword';
    
    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = array(
        'where_field'      => 'user_login', // Column in wp_user table which will be used to get user
        'login_field'      => '', // Column in wp_user table which will be used to get user
    );

    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_INCORRECT_PASSWORD => "Incorrect Password",
    );
    
    /**
     * Returns the set where_field
     *
     * @return mixed
     */
    public function getWhereField()
    {
        return $this->options['where_field'];
    }
    
    /**
     * Sets the where_field
     *
     * @param  string
     * @return Callback Provides a fluent interface
     */
    public function setWhereField($whereField)
    {
        $this->options['where_field'] = $whereField;
        return $this;
    }
    
    /**
     * Returns the set where_field
     *
     * @return mixed
     */
    public function getLoginField()
    {
        return $this->options['login_field'];
    }
    
    /**
     * Sets the where_field
     *
     * @param  string
     * @return Callback Provides a fluent interface
     */
    public function setLoginField($loginField)
    {
        $this->options['login_field'] = $loginField;
        return $this;
    }
    
    public function isValid($value)
    {
        global $wpdb;

        $valid = true;
        $this->setValue($value);
        
        $found = $wpdb->get_var( $wpdb->prepare("SELECT user_pass FROM $wpdb->users WHERE %s = %s", $this->getWhereField(), $this->getLoginField()) );
        
        if ($found) {
            $valid = false;
            $this->error(self::ERROR_RECORD_FOUND);
        }else {
            
        }

        return $valid;
    }
}
