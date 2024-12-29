<?php

function getPostField(string $key, array &$errors)
{
    if (isset($_POST[$key])) {
        return trim($_POST[$key]);
    }

    $errors[$key] = "Provided $key!";
    return null;
}

?>