<?php
    /* Check the HTTPS variable of the $_SERVER array and assign it to a
     * variable, then check that variable to find out if the page is using
     * a secure connection */
    $https = filter_input(INPUT_SERVER, 'HTTPS');
    if (!$https){
        /* If we are here, then the page is not using a secure connection. Use
         * the $_SERVER array to get the host and URI for the current request,
         * and with those create an absolute URL that uses a secure connection
         * and redirect to that page. */
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $secure_url = 'https://' . $host . $uri;
        header("Location: " . $secure_url);
        exit(); // Exit this script after redirecting
    }

?>