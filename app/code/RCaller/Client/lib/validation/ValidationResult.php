<?php
namespace rcaller\lib\validation;
class ValidationResult
{
    private $errors;

    public function __construct()
    {
        $this->errors = array();
    }

    /**
     * @return mixed
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function addError($field, $message)
    {
        $validationError = new ValidationError();
        $validationError->setField($field);
        $validationError->setMessage($message);
        array_push($this->errors, $validationError);
    }

    public function __toString()
    {
        $result = array();
        foreach ($this->errors as $error) {
            $errorString = $error->getField() . ":" . $error->getMessage();
            array_push($result, $errorString);
        }
        return join(" ; ", $result);
    }
}

