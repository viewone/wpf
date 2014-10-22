<?php

namespace WPF\Validator\Db;

use \Zend\Validator\ValidatorInterface;

/**
 * Confirms a record does not exist in a table.
 */
class NoRecordExists extends \Zend\Validator\AbstractValidator implements
    ValidatorInterface
{
    
    /**
     * Error constants
     */
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND    = 'recordFound';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => "No record matching the input was found",
        self::ERROR_RECORD_FOUND    => "A record matching the input was found",
    );
    
    public function isValid($value)
    {
        global $wpdb;

        $valid = true;
        $this->setValue($value);
        
        $found = $wpdb->get_var( $wpdb->prepare("SELECT user_email FROM $wpdb->users WHERE user_email = %s", $value) );
        
        if ($found) {
            $valid = false;
            $this->error(self::ERROR_RECORD_FOUND);
        }

        return $valid;
    }
}
