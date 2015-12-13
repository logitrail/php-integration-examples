<?php

include_once './product_database.inc.php';

session_start();
if (!$noHtml) {
    ?>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Logitrail Checkout Integration Example</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://raw.githubusercontent.com/logitrail/javascript-library/master/src/logitrail.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
        
            <div><a href="index.php">Main Page</a></div>
            
        
    <?php

    register_shutdown_function(function() {
        echo "</div>";
        echo "</body></html>";
    });

}

