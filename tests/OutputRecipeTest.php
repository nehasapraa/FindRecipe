<?php

/**
 * OutputRecipeTest.php
 */

require_once('OutputRecipe.php');

/**
 * outputRecipeTest 

 */
class OutputRecipeTest extends PHPUnit_Framework_TestCase {
   /**
    * testValidation 
    * 
    */
   public function testValidation() {
        $this->setExpectedException('RecipeValidationException');

        $recipe = new OutputRecipe();
     
   }
}
