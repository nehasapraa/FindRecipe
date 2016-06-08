<?php

/**
 * findrecipe.php
 *

 */?>
<!DOCTYPE html>

<html>
    <head>
        <title>Recipe Finder Application</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            
            <form method="POST" action="index.php" enctype="multipart/form-data" class = "form-horizontal">
             <div class="form-group">
                 <label for="formGroupFileInput" class="file" >Choose Csv Fridge Input File</label>
            <input name="fridge_ingredients" id="fridge_ingredients" type="file"/>
                 <span class="file-custom"></span>
             </div>
            <input type="submit" value="Submit" name="find_recipe"  class="btn btn-primary"/>
        </form>
        </div>
        
    </body>
</html>
