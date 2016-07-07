<?php
# Debug
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');
# Autoload
require dirname(__FILE__)
    . DIRECTORY_SEPARATOR . 'core'
    . DIRECTORY_SEPARATOR . 'autoload'
    . DIRECTORY_SEPARATOR . 'register.inc';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>FileCreator - Library to create files</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            html, body {
                margin: 0;
                padding: 0;
                color: #565656;
                font-size: 1em;
                text-align: left;
                font-family: sans-serif;
            }
            body {
                padding: 10px;
            }
            h1 {
                font-size: 2em;
            }
            h2 {
                font-size: 1.6em;
            }
            h3 {
                font-size: 1.2em;
            }
            h4 {
                font-size: 1em;
            }
            h5 {
                font-size: 0.8em;
            }
            h6 {
                font-size: 0.6em;
            }
            p, span {
                margin: 0;
                padding: 0;
                font-size: 0.85em;
            }
            form fieldset {
                margin: 0;
                padding: 10px;
                margin: 10px;
            }
            form fieldset legend {
                margin: 0;
                padding: 0 5px;
                font-weight: bold;
                font-size: 0.8em;
            }
            .container {
            }
            .container .container-form {
            }
            .container .container-form .form-result {
                margin: 0;
                padding: 0;
                height: 200px;
                overflow-y: scroll;
                border-top: 1px solid gray;
                border-bottom: 1px solid silver;
            }
            .container .container-form .form-result pre {
                font-size: 1.2em;
            }
            .container .container-form .form-group {
            }
            .container .container-form .form-group .form-field-label {
                font-size: 0.8em;
            }
            .container .container-form .form-group .form-field-value {
            }
            .container .container-form .form-group .form-field-value select {
                width: 100%;
                padding: 2px;
            }
            .container .container-form .form-group .form-field-value textarea,
            .container .container-form .form-group .form-field-value input[type='text'] {
                width: 99%;
                padding: 2px;
            }
            .container .container-form .form-group .form-field-button {
                padding: 10px;
                text-align: center;
                background-color: #fafafa;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="container-header">
                <h3>FileCreator</h3>
                <h4>FileCreator - Library to create files</h4>
            </div>
            <!-- Result -->
            <div class="form-result">
                <pre>
                    <?php
                    var_dump(new helionogueir\filecreator\file\ReadFile());
                    var_dump(new helionogueir\filecreator\file\ReplaceText());
                    ?>
                </pre>
            </div>
            <!-- /Result -->
        </div>
    </body>
</html>