<?php

return [

    /************************
     * The database connection to be used
     * This will use the db connection from config/database.php
     */
    'db_connection' => 'mysql',

    'weight' => [
        'title' => 1.5,
        'content' => 1,
    ],

    'limit-results' => 100,

    /**
     *  Enable wildcard after words
     */
    'enable_wildcards' => true,
];
