<?php

return [
    /*
     * The database connection to be used
     * Defaults to the default database connection
     */
    'db_connection' => null,

    'weight' => [
        'title' => 1.5,
        'content' => 1,
    ],

    'limit-results' => 100,

    /*
     *  Enable wildcard after words
     */
    'enable_wildcards' => true,

    /*
     * Exclude some rows
     */
    'exclude_feature_enabled' => false,
    'exclude_records_column_name' => 'default_column',
];
