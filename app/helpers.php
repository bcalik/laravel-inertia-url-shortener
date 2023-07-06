<?php

/**
 * @throws Exception
 */
function uniqid_real($lenght = 13): string
{
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception('No cryptographically secure random function available.');
    }
    return substr(bin2hex($bytes), 0, $lenght);
}
