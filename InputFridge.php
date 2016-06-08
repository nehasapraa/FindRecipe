<?php

/**
 * InputFridge.php
 *
/**
 * IngredientValidationException 
 * 

 */
class IngredientValidationException extends \Exception {}

/**
 * Ingredient 
 * 
 */
class InputFridge {
    /**
     * item 
     *
     */
    private $item = '';
    private $amount = 0;
    private $unit = '';
    private $useBy = 0;
    private $isExpired = false;
    
    private $validationRules = array(
        'item'   => '/^(.*)$/', 
        'amount' => '/^(\d+)$/',
        'unit'   => '/^(of|grams|ml|slices)$/i',
        'useBy'  => '/^(\d{1,2})\/(\d{1,2})\/(\d{1,2})/'
    );

    /**
     * Constructor
     
     */
    public function InputFridge ($item   = '',$amount = 0,$unit   = '',$useBy  = null) {
        $this->validateInputItems('item', $item);
        $this->validateInputItems('amount', $amount);
        $this->validateInputItems('unit', $unit);

        // use by is optional
        if ($useBy !== null) {
            $this->validateInputItems('useBy', $useBy);
            
            // convert the useBy to a timetamp and check if the item is expired
            $this->useBy = strtotime(str_replace('/', '-', $this->useBy));
            if ($this->useBy < time())
                $this->isExpired = true;
        }
    }

   
    public function getItem() {
        return $this->item;
    }

   
    public function getAmount() {
        return $this->amount;
    }

   
    public function getUnit() {
        return $this->unit;
    }

   
    public function getUseBy() {
        return $this->useBy;
    }

    
    public function getIsItemExpired() {
        return $this->isExpired;
    }

    private function validateInputItems($field = '', $input) {
        if (!preg_match($this->validationRules[$field],
                        $input))
            throw new IngredientValidationException("Invalid input on $field");
        $this->$field = $input;
    }
}
