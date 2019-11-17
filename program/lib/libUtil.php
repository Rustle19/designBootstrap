<?php

class libUtil
{
    /**
     * validation of array
     * @param  mixed $mValue 
     * @return boolean         
     */
    public static function isValidArray($mValue)
    {
        return (is_array($mValue) === true && count($mValue) > 0) ? true : false;
    }

    /**
     * validation of string
     * @param  mixed  $mValue 
     * @return boolean         
     */
    public static function isValidString($mValue)
    {
        return (is_string($mValue) === true && strlen($mValue) > 0) ? true : false;
    }
}
