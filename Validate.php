<?php
class Validate
{
    private $path;
    private $message;
    private $customType;

    public function __construct($data, $filter, $path, $message, $customType = null)
    {
        $this->path = $path;
        $this->message = $message;
        $this->customType = $customType ?? null;
        $this->filterData($data, $filter);
    }

    private function filterData($data, $filter)
    {
        foreach ($filter as $column => $filterValue) {
            if (isset($data[$column])) {
                $filterArray = explode('|', $filterValue);
                foreach ($filterArray as $value) {
                    if (strpos($value, ':') !== false) {
                        $filterLength = explode(':', $value);
                        if (count($filterLength) == 2) {
                            $method = 'valid'.ucfirst(strtolower($filterLength[0]));
                            if (method_exists(__CLASS__, $method)) {
                                $this->{$method}($column, $data[$column], $filterLength[1]);
                            }
                        }
                    } else {
                        $method = 'valid'.ucfirst(strtolower($value));
                        if (method_exists(__CLASS__, $method)) {
                            $this->{$method}($column, $data[$column]);
                        }
                    }
                }
            }
        }
    }

    public function validAlphanum($column, $data)
    {
        if (!isValidRegex(ALPHA_NUM, $data)) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
              'warning' => $this->message[$column] ?? null,
              $customTypeKey => $this->customType[$customTypeKey]
            ]
          );
        }
    }

    public function validAlpha($column, $data)
    {
        if (!isValidRegex(ALPHA, $data)) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
              'warning' => $this->message[$column] ?? null,
              $customTypeKey => $this->customType[$customTypeKey]
            ]
          );
        }
    }

    public function validDigit($column, $data)
    {
        if (!isValidRegex(DIGITS, $data)) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
              'warning' => $this->message[$column] ?? null,
              $customTypeKey => $this->customType[$customTypeKey]
            ]
          );
        }
    }

    public function validPassword($column, $data)
    {
        if (!isValidRegex(PASSWORD, $data)) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
            'warning' => $this->message[$column] ?? null,
            $customTypeKey => $this->customType[$customTypeKey]
          ]
        );
        }
    }

    public function validMail($column, $data)
    {
        if (!filterData($data, "mail")) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
                'warning' => $this->message[$column] ?? null,
                $customTypeKey => $this->customType[$customTypeKey]
              ]
            );
        }
    }

    public function validImage($column, $data)
    {
        if (!checkBase64Format($data)) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
            'warning' => $this->message[$column] ?? null,
            $customTypeKey => $this->customType[$customTypeKey]
          ]
        );
        }
    }

    public function validMin($column, $data, $length)
    {
        if (strlen($data) < $length) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
                'warning' => $column.' n\'a pas assez de charactéres (taille minimale : '.$length.')',
                $customTypeKey => $this->customType[$customTypeKey]
              ]
            );
        }
    }

    public function validMax($column, $data, $length)
    {
        if (strlen($data) > $length) {
            $customTypeKey = key($this->customType);
            view(
                $this->path,
                [
                'warning' => $column.' à trop de charactéres (taille maximale : '.$length.')',
                $customTypeKey => $this->customType[$customTypeKey]
              ]
            );
        }
    }
}