<?php

namespace Suvarivaza\EV;

class EasyValidator
{

    /**
     * $name variable
     *
     * @var [string]
     */
    protected $name = null;

    /**
     * $value variable
     *
     * @var [string/integer]
     */
    protected $value = null;

    /**
     * $data variable
     *
     * @var array
     */
    protected $data = [];

    /**
     * $errors variable
     *
     * @var array
     */
    protected $errors = [];

    /**
     * $error_key variable
     *
     * @var string
     */
    protected $error_key = null;

    /**
     * $is_errors variable
     *
     * @var bool
     */
    protected $is_errors = false;

    /**
     * name method
     *
     * @param  $name|string
     * @return self
     */
    public function name($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * value method
     *
     * @param $value|string/integer
     * @return self
     */
    public function value($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * value method
     *
     * @param $rules|array
     * @return bool
     */
    public function rules($rules){

        $this->data[$this->name] = $this->value;

        foreach($rules as $rule_name => $rule_value){

            try{
                switch ($rule_name) {

                    case 'required':
                        if (empty($this->value)) {
                            throw new \Exception("{$this->name} Is required!");
                        }
                        break;

                    case 'matches':

                        if ($this->value != $this->data[$rule_value]) {
                            throw new \Exception("{$this->name} does not match!");
                        }
                        break;

                    case 'min':

                        if (strlen($this->value) < $rule_value) {
                            throw new \Exception("{$this->name} should be minimum {$rule_value} characters");
                        }
                        break;

                    case 'max':

                        if (strlen($this->value) > $rule_value) {
                            throw new \Exception("{$this->name} should be maximum {$rule_value} characters");
                        }
                        break;

                    case 'email':
                        if(!filter_var($this->value, FILTER_VALIDATE_EMAIL)){
                            throw new \Exception("{$this->value} not Email!");
                        }
                        break;

                    case 'unique':
                        if ($this->exists($this->value)) { // need check $this->value in database
                            throw new \Exception("{$this->value} not unique!");
                        }
                        break;
                }

            } catch (\Exception $e ){
                $this->errors[$this->name] = $e->getMessage();
                $this->is_errors = true;
                return false;
            }

        }

        return true;

    }

    /**
     * exists method
     *
     * @param $value|string/integer
     * @return bool
     */
    function exists($value){
        // check $value in database
        return false;
    }

    /**
     * getErrors method
     *
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * getError method
     *
     * @return string
     */
    public function getError() {
        return array_shift($this->errors);
    }

    /**
     * success method
     *
     * @return bool
     */
    public function success() {
        return !$this->is_errors ? true : false;
    }

}