<?php
/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * Command line interface
 */

include 'sqlite.php';
include 'spyc.php';
include 'api/yaml.php';
include 'array-to-texttable.php';

error_reporting(E_ERROR);

$func = $argv[1];

if($func == 'dump-schema'){
    $table = $argv[2];
    echo yaml::schema_to_yaml($table);
}

if($func == 'load-schema'){
    $table = $argv[2];
    echo yaml::load_schema_from_yaml($table);
}

if($func == 'drop-table'){
    $table = $argv[2];
    echo yaml::drop_table($table);
}

if($func == 'convert-table'){
    $source = $argv[2];
    $target = $argv[3];
    echo yaml::convert_table($source,$target);
}

if($func == 'dump-to-screen'){
    $table = $argv[2];
    $renderer = new ArrayToTextTable((array)yaml::dump_to_screen($table));
    $renderer->showHeaders(true);
    $renderer->render();
    echo "\r\n";
}

if($func == '' or $func == 'help'){
   echo "dump-schema <tablename> \r\n";
   echo "load-schema <tablename> \r\n";
   echo "drop-table <tablename> \r\n";
   echo "convert-table <source> <target> \r\n";
   echo "dump-to-screen <table>\r\n";
}
