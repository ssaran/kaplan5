<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 7.01.2020
 * Time: 14:12
 */

namespace K5\Http\Field;


class FormValidator
{
    const TYPE_ALNUM = 'Alnum'; //Validates that a field’s value is only alphanumeric character(s).
    const TYPE_ALPHA = 'Alpha'; //Validates that a field’s value is only alphabetic character(s).
    const TYPE_DATE = 'Date'; //Validates that a field’s value is a valid date.
    const TYPE_DIGIT = 'Digit'; //Validates that a field’s value is only numeric character(s).
    const TYPE_FILE = 'File'; //Validates that a field’s value is a correct file.
    const TYPE_UNIQUE = 'Uniqueness'; //Validates that a field’s value is unique in the related model.
    const TYPE_NUMERIC = 'Numericality'; //Validates that a field’s value is a valid numeric value.
    const TYPE_PRESENCE = 'PresenceOf'; //Validates that a field’s value is not null or empty string.
    const TYPE_IDENTICAL = 'Identical'; //Validates that a field’s value is the same as a specified value
    const TYPE_EMAIL = 'Email'; //Validates that field contains a valid email format
    const TYPE_EXCLUSION_IN = 'ExclusionIn'; //Validates that a value is not within a list of possible values
    const TYPE_INCLUSION_IN = 'InclusionIn';	//Validates that a value is within a list of possible values
    const TYPE_REGEX = 'Regex'; //Validates that the value of a field matches a regular expression
    const TYPE_STRING_LENGTH = 'StringLength'; //Validates the length of a string
    const TYPE_BETWEEN = 'Between'; //Validates that a value is between two values
    const TYPE_CONFIRM = 'Confirmation'; //Validates that a value is the same as another present in the data
    const TYPE_URL = 'Url'; //Validates that field contains a valid URL
    const TYPE_CREDIT_CARD = 'CreditCard'; //Validates a credit card number
    const TYPE_CALLBACK = 'Callback';

    public $type;
    public $message;
    public $minimum;
    public $maximum;
    public $with;
    public $format;
    public $domain;
    public $maxSize;
    public $messageSize;
    public $allowedTypes;
    public $messageType;
    public $maxResolution;
    public $messageMaxResolution;
    public $accepted;
    public $pattern;
    public $max;
    public $min;
    public $messageMaximum;
    public $messageMinimum;
    public $model;

    public function __construct($type,$message)
    {
        $this->type = $type;
        $this->message = $message;
    }
}