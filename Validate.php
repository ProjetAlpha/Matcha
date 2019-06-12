<?php
class Validate
{
    private static $typeKey;
    private static $typeValue;

    public static function check($names, $path, $messages, $type, $formType = null)
    {
        self::$typeKey = $formType ? key($formType) : 'type';
        self::$typeValue = $formType ? $formType[key($formType)] : $type;
        self::validData($names, $path, $messages, $type);
    }

    private static function validData($names, $path, $messages, $type)
    {
        foreach ($names as $key => $name) {
            $method = 'valid'.ucfirst(strtolower($key));
            if (method_exists(__CLASS__, $method) && isset($name) && !empty($name)) {
                self::{$method}($name, $path, $messages, $type);
            }
        }
    }

    public static function validUsername($name, $path, $messages, $type)
    {
        if (!isValidRegex(ALPHA_NUM, $name) && isset($messages['username'])) {
            view(
                $path,
                [
                    'warning' =>  $messages['username'],
                    self::$typeKey => self::$typeValue
                ]
            );
        }
    }

    public static function validPassword($password, $path, $messages, $type)
    {
        if (!isValidRegex(PASSWORD, $password) && isset($messages['password'])) {
            view(
                $path,
                [
                    'warning' => $messages['password'],
                    self::$typeKey => self::$typeValue
                ]
            );
        }
    }
    public static function validMail($mail, $path, $messages, $type)
    {
        if (!filterData($mail, "mail") && isset($messages['email'])) {
            view(
                $path,
                [
                    'warning' =>  $messages['mail'],
                    self::$typeKey => self::$typeValue
                ]
            );
        }
    }

    public static function validBase64Image($image, $path, $messages, $type)
    {
        if (!checkBase64Format($image) && isset($messages['image'])) {
            view(
                $path,
                [
                    'warning' => $messages['image'],
                    self::$typeKey => self::$typeValue
                ]
            );
        }
    }

    public static function validDigits($digit, $path, $messages, $type)
    {
        if (!isValidRegex(DIGITS, $digit) && isset($messages['digit'])) {
            view(
                $path,
                [
                    'warning' => $messages['digit'],
                    self::$typeKey => self::$typeValue
                ]
            );
        }
    }

    public static function validLastname($string, $path, $messages, $type)
    {
        if (!isValidRegex(ALPHA, $string) && isset($messages['lastname'])) {
            view(
                $path,
                [
                    'warning' => $messages['lastname'],
                    self::$typeKey => self::$typeValue
                ]
            );
        }
    }

    public static function validFirstname($string, $path, $messages, $type)
    {
        if (!isValidRegex(ALPHA, $string) && isset($messages['firstname'])) {
            view(
                $path,
                [
                    'warning' => $messages['firstname'],
                    self::$typeKey => self::$typeValue
                ]
            );
        }
    }

    public static function validLengthData($data, $maxLen, $path, $type)
    {
        foreach ($data as $key => $value) {
            if (isset($maxLen[$key])) {
                if (strlen($value) > $maxLen[$key]) {
                    view(
                        $path,
                        [
                      'warning' => $key.' contient trop de charactéres (taille maximale : '.$maxLen[$key].')',
                      self::$typeKey => self::$typeValue
                  ]
              );
                }
            }
        }
    }
}
