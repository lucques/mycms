<?php
    // This script uses the database configuration from `config.php` and fills the database with sample data from `dump.sql`.
    // - If there is already any data present in the database, no data is imported
    // - This works only if `$databaseRelationPrefix=mycms_` since this prefix is hard-wired in `dump.sql`

    require_once 'config.php';

    $connection = mysqli_connect($databaseHost, $databaseUser, $databasePassword);

    if ($connection === false)
        die('Connecting failed.');
    if (!mysqli_select_db($connection, $databaseName))
        die('Selecting database failed.');
    if (!mysqli_set_charset($connection, 'utf8'))
        die('Setting charset to UTF8 failed.');

    // Only perform installation if database is completely empty
    $databaseEmptyResult = mysqli_query($connection, 'SELECT COUNT(DISTINCT table_name) ' .
                                                     'FROM information_schema.columns ' .
                                                     'WHERE table_schema = "' . $databaseName . '"');
    $databaseEmpty = mysqli_fetch_array($databaseEmptyResult)[0] == 0;

    if ($databaseEmpty) {
        // Import `dump.sql`
        $sql = file_get_contents('dump.sql');        
        $success = mysqli_multi_query($connection, $sql);

        if ($success)
            echo('Database import successful.');
        else
            die('Database import failed.');
    }
    else
        die('Database is not empty.');
?>