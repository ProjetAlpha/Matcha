<?php
class Validate
{
    private $path;
    private $message;
    public $loadedMessage = [];
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

    public function loadMessage($column, $customTypeKey, $message)
    {
        if ($this->path == "sendToJs") {
            $this->loadedMessage[] = $this->message[$column];
        } else {
            view(
                $this->path,
                [
              'warning' => $message,
              $customTypeKey => $this->customType[$customTypeKey] ?? 'null'
            ]
          );
        }
    }

    public function validAlphanum($column, $data)
    {
        if (!isValidRegex(ALPHA_NUM, $data)) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $this->message[$column] ?? null);
        }
    }

    public function validAlpha($column, $data)
    {
        if (!isValidRegex(ALPHA, $data)) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $this->message[$column] ?? null);
        }
    }

    public function validDigit($column, $data)
    {
        if (!isValidRegex(DIGITS, $data)) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $this->message[$column] ?? null);
        }
    }

    public function validPassword($column, $data)
    {
        if (!isValidRegex(PASSWORD, $data)) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $this->message[$column] ?? null);
        }
    }

    public function validEmail($column, $data)
    {
        if (!filterData($data, "mail")) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $this->message[$column] ?? null);
        }
    }

    public function validImage($column, $data)
    {
        if (!checkBase64Format($data)) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $this->message[$column] ?? null);
        }
    }

    public function validMin($column, $data, $length)
    {
        if (strlen($data) < $length) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $column.' n\'a pas assez de charactéres (taille minimale : '.$length.')');
        }
    }

    public function validMax($column, $data, $length)
    {
        if (strlen($data) > $length) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $column.' à trop de charactéres (taille maximale : '.$length.')');
        }
    }

    public function validText($column, $data)
    {
        if (!isValidRegex(TEXT, $data)) {
            $customTypeKey = $this->customType ? key($this->customType) : 'noKey';
            $this->loadMessage($column, $customTypeKey, $column.' à trop de charactéres (taille maximale : '.$length.')');
        }
    }
}
