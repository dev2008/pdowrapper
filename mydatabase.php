<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                   //
//  Copyright (c) 2022 https://stackoverflow.com/users/5507893/deep64blue                            //
//                                                                                                   //
//  This is a PDO wrapper class, it can be used with any system however it was designed for          //
//  projects using the Dadabik framework https://dadabik.com                                         //
//                                                                                                   //
//  This class is based on the work of https://stackoverflow.com/users/285587/your-common-sense      //
//  Check out his website at https://phpdelusions.net                                                //
//  The core of this class is based on the 'singleton' example found at                              //
//  https://phpdelusions.net/pdo/pdo_wrapper                                                         //
//                                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////////////////////

//Dadabik sets the db values, for other systems change value as required
$_cp_host=$host;
$_cp_db=$db_name;
$_cp_user=$user;
$_cp_pass=$pass;
$_cp_char='utf8';

//alternatively delete above lines and define directly here
define('myDB_HOST', $_cp_host);
define('myDB_NAME', $_cp_db);
define('myDB_USER', $_cp_user);
define('myDB_PASS', $_cp_pass);
define('myDB_CHAR', $_cp_char);

class myDB
{
    protected static $instance = null;

    protected function __construct() {}
    protected function __clone() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => FALSE,
            );
            $dsn = 'mysql:host='.myDB_HOST.';dbname='.myDB_NAME.';charset='.myDB_CHAR;
            self::$instance = new PDO($dsn, myDB_USER, myDB_PASS, $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function run($sql, $args = [])
    {
        if (!$args)
        {
             return self::instance()->query($sql);
        }
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}

/*
 * Generic function to take an array and print all of the content in a basic format.
 * Used to understand the contents
 */
function debug_print($array)
	{
					echo "<pre><code>\n";
					print_r($array);
					echo "\n</code></pre>\n";
					return;
	}
