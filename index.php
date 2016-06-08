<?php

/**
 * index.php
 *
 * Gives us output what is cooking based on input of csv file.
 * 
 *
 *
*/

require_once('InputFridge.php');
require_once('OutputRecipe.php');

/**
 * RecipeFinderException 
 * 
 
 */
class RecipeFinderException extends \Exception {}

/**
 * InputException 
 * 
 
 */
class InputException extends \Exception {}

/**
 * RecipeFinder 
 * 
 
 */
class RecipeFinder {
    /**
     * Constant defined when No match is found
     */
    const EMPTY_RESPONSE = 'Order Takeout';

    /**
     * ingredients amd recipes
     */
    private $ingredients = array();
    private $recipes = array();
    /**
     * Finds suitable recipes from the fridge
     * 
     * @access public
     * @return string
     */
    public function findRecipe() {
        $matchesFound = array();
        
        foreach ($this->recipes as $recipe) {

            $matchedIngredient = $recipe->checkIngredients($this->ingredients);
            if ($matchedIngredient !== false) { 
                $recipeName = $recipe->getName();
                $matchesFound[$recipeName] = $matchedIngredient;
            }
            
        }

        // No recipe found
        if (count($matchesFound) == 0)
            return self::EMPTY_RESPONSE;

        // sort by timestamp increasing and return first result
        asort($matchesFound);
    
        return key($matchesFound);
    }

    /**
     * Inputs a list of items in a fridge in a csv format 
     * 
     * @param string $file 
     * @access public
     * 
     */
    public function inputIngredients($file = 'fridge.csv') {
        if (!is_readable($file))
            throw new InputException("CSV file is not readable.");

        $fp = file($file);

       
        foreach ($fp as $lineNumber => $line) {

            $fields = str_getcsv($line);
            try {

                
                $inputfridge = new InputFridge($fields[0],
                                              $fields[1],
                                              $fields[2],
                                              $fields[3]);
                
                $this->ingredients[] = $inputfridge;

            } catch (IngredientValidationException $e) {
                echo "There is error in CSV line number " . ++$lineNumber . "\n";
            }

            unset($fields, $ingredient);
        }
        
        return $this;

           
       
    }

    public function chooseRecipes($file = 'recipes.json') {
       
       if (!is_readable($file)) 
            throw new InputException("Json file not readable.");

        $fp   = file_get_contents($file);
        $data = json_decode($fp, true);

        if ($data === null) 
            throw new InputException("Json file could not be parsed. Please check and reload it.");

        foreach ($data as $dataRecipe) {
            try {
                $recipe = new OutputRecipe($dataRecipe['name']);

                foreach ($dataRecipe['ingredients'] as $dataIngredient) {
                    
                    try {
                        $ingredient = new InputFridge($dataIngredient['item'],
                                                     $dataIngredient['amount'],
                                                     $dataIngredient['unit']);
                        
                        $recipe->addIngredient($ingredient);
                    } catch (IngredientValidationException $e) {
                        echo "Ingredient is not valid.";
                    }
                }

                $this->recipes[] = $recipe;
            } catch (RecipeValidationException $e) {
                echo "Recipe name not valid\n";
            }
            unset($recipe, $dataIngredient, $ingredient);
        }

        return $this;
    }
}
/*Calling of all functions to get recipe.*/

try {
    // set timezone to avoid warnings for using function strtotime
    date_default_timezone_set('Australia/Sydney');

    if (!isset($_FILES['fridge_ingredients']) && !isset($argv[1])) 
        header('Location: findrecipe.php');
    
    $fridge_ingredients = isset($argv[1]) ? $argv[1] : $_FILES['fridge_ingredients']['tmp_name'];
    $recipes            = isset($argv[2]) ? $argv[2] : "data/recipes.json";
    
    
    $recipeFinder = new RecipeFinder();
    
    $get_recipe = $recipeFinder->inputIngredients($fridge_ingredients)
                      ->chooseRecipes($recipes)
                      ->findRecipe();
    
    echo "Great you are planning to cook ".$get_recipe."\n";

} catch (RecipeFinderException $e) {

    echo $e->getMessage() . "\n";

} catch (InputException $e) {

    /* Error Message*/
    echo "Please enter valid input."; 

}
?>
