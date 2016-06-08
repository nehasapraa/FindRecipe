Usage
-----

Execute the application from CLI  
$ php index.php<fridge.csv><recipe.json>

Both the files are available in the data so you can run them directly as 
php index.php data/fridge.csv data/recipe.json

Execute the application from Web
path/to/folder/findrecipe.php
in my case recipe.localhost/findrecipe.php

Running Tests
For details on how to install PHPUnit click [here](http://phpunit.de/manual/current/en/installation.html)
You can run a PHPUnit test with the following command 
phpunit tests/InputFridgeTest.php  (Make sure that phpunit is installed globally)
OR
path/to/phpunit path/to/folderApplication/tests/InputFridgeTest.php