<?php
/**
 * OutputRecipe.php
 *
/**
 * RecipeValidationException 
 * 
 */
class RecipeValidationException extends \Exception {}

/**
 * Recipe 
 * 
 */
class OutputRecipe {
    
    private $name = '';
    private $ingredients  = array();
    private $validationRule = '/^(.+)$/';
    
    /**
     * Constructor
     
     */
    public function OutputRecipe($name = '') {
        if (!preg_match($this->validationRule, $name))
            throw new RecipeValidationException("Invalid name for recipe");

        $this->name = $name;
    }

   
    public function addIngredient(InputFridge $item) {
        $this->ingredients[] = $item;
        return true;
    }

    /**
     * Checks whether the recipe matches a list of ingredients 
     * 
     */
    public function checkIngredients($ingredients = array()) {
        $earliestExpiry = 0;
        foreach ($this->ingredients as $recipeIngredient) {
            $ingredientFound = false;

            foreach ($ingredients as $ingredient) {
       
                if ($ingredient->getItem() == $recipeIngredient->getItem() &&
                    $ingredient->getUnit() == $recipeIngredient->getUnit() &&
                    $ingredient->getAmount() >= $recipeIngredient->getAmount() &&
                    $ingredient->getIsItemExpired() === false) {
                    // ingredient found
                    $ingredientFound = true;

                    // mark the earliest expiry
                    if ($earliestExpiry == 0 || 
                        $earliestExpiry > $ingredient->getUseBy())
                        $earliestExpiry = $ingredient->getUseBy();
                }
            }

            if ($ingredientFound == false) 
                return false;
        }

        //for sorting
        return $earliestExpiry;
    }

   
    public function getName() {
        return $this->name;
    }
}
