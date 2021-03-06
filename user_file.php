<?php
include_once 'session.php';
include_once 'inc/util.php';

/**
 * Echo the filename form.
 *
 * @return void
 */
function echoFileForm()
{
    echo '<form method="GET" class="form nocsrf" action="">' .
            '<div class="form-group">' .
                '<label for="filename">Filename</label>' .
                '<input type="text" required name="filename" name class="form-control">' .
            '</div>' .
            '<input type="submit" value="Display" class="btn btn-success">' .
         '</form>';
}

/**
 * Echo the file content.
 *
 * @return void
 */
function getFileContent()
{
    if(!isset($_GET['filename'])) {
        return;
    }

    $filename = get_from_session('userID') . '/' . $_GET['filename'];
    $realPath = realpath($filename);

    if ($realPath === false) {
        trigger_error("File not found", E_USER_ERROR);
        return;
    }

    $expectedDir = realpath(__DIR__ . '/' . get_from_session('userID'));
    
    if ($expectedDir !== dirname($realPath)) {
        trigger_error("Path traversal attempt found", E_USER_ERROR);
        return;
    }
    
    echo '<div class="fileContent">' .
         '<div class="well">' .
         '<p>';
    xecho(file_get_contents($filename));
    echo '</p>' . 
         '</div>';
}
