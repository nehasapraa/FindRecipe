<?php


/**
 * InputFridge.php
 *
*/

require_once('InputFridge.php');

/**
 * InputFridgeTest 
 * 
 */
class InputFridgeTest extends PHPUnit_Framework_TestCase {
  
   
   public function testValidation1() {
        $this->setExpectedException('IngredientValidationException');

        $inputfridge = new InputFridge(); 
   }

   
   public function testValidation2() {
        $this->setExpectedException('IngredientValidationException');

        $ingredient = new InputFridge('Foo',
                                     'a10',
                                     'of',
                                     '17/10/16'); 
   }

   
   public function testValidation3() {
        $this->setExpectedException('IngredientValidationException');

        $ingredient = new InputFridge('Foo',
                                     10,
                                     'bar',
                                     '12/05/2017'); 
   }


   
   public function testValidation4() {
        $this->setExpectedException('IngredientValidationException');

        $ingredient = new InputFridge('Foo',
                                     10,
                                     'slices',
                                     'bar'); 
   }

   /**
    * Tests valid input 
    * 
    */
   public function testInputItems() {
        $expectedOutput = array(
            'item'   => 'Test',
            'amount' => 5,
            'unit'   => 'slices',
            'useBy'  => 1381363200
        );

        date_default_timezone_set('Australia/Sydney');
        $ingredient = new InputFridge('Test',
                                     5,
                                     'slices',
                                     '19/12/2012');

        $this->assertEquals($expectedOutput, array(
            'item'   => $ingredient->getItem(),
            'amount' => $ingredient->getAmount(),
            'unit'   => $ingredient->getUnit(),
            'useBy'  => $ingredient->getUseBy()
        ));
   }
    

}
