<?php
/**
 * miniJSON
 * - a very super simple, basic json php framework.
 */
class yaml
{
    public function __construct()
    {
    }

    /***
     * @param $table
     * @return string
     */
    public static function schema_to_yaml($table)
    {

        // Run SQL
        $sqlite = new sqlite();

        $result = $sqlite->query("PRAGMA table_info($table)");

        $array = array();

        foreach ($result as $k => $v) {
            $array[] = array(
                'name' => $v->name,
                'type' => $v->type,
                'notnul' => $v->notnull,
                'default' => $v->dflt_value,
                'isprimarykey' => $v->pk,
            );
        }

        // Write to file
        $fp = fopen('db/'.$table.'.yaml', 'w+');
        fwrite($fp, Spyc::YAMLDump($array));
        fclose($fp);

        // Return json
        // return array('yaml' => Spyc::YAMLDump($array));
        return Spyc::YAMLDump($array);
    }

    /***
     * @param $table
     */
    public static function load_schema_from_yaml($table)
    {
        $schema = Spyc::YAMLLoad('db/' . $table . '.yaml');

        $sqlite = new sqlite();

        $pragma = $sqlite->query("PRAGMA table_info($table)");

        foreach($pragma as $k=>$v){
            $pragma_fields[] = $v->name;
        }

        // If pragma returns info, table exists, enter ALTER mode
        if(count($pragma) > 0){

            echo "Table $table exists.\r\n";

            foreach($schema as $k=>$v){

                if(in_array($v['name'], $pragma_fields)){

                    echo 'Column ' . $v['name'] . " exists\r\n";

                } else {

                    echo $v['name'] . " does not exist\r\n";

                    if($v['notnul'] == 1){
                        $notnull = 'NOT NULL';
                    } else {
                        $notnull = 'NULL';
                    }

                    if($v['default'] != ''){
                        $default = 'DEFAULT ' . $v['default'];
                    }

                    $sql = "ALTER TABLE $table ADD COLUMN " . $v['name'] . " " . $v['type'] . " $notnull " . $v['default'] ;
                    $sqlite->exec($sql);

                    echo $v['name'] . " column added\r\n";

                }

            }

        // pragma returns zero, enter CREATE TABLE mode
        } else {

            $sql = "create table $table (";

            foreach($schema as $k=>$v){

                if($v['notnul'] == 1){
                    $notnull = 'NOT NULL';
                } else {
                    $notnull = 'NULL';
                }

                if($v['default'] != ''){
                    $default = 'DEFAULT ' . $v['default'];
                }

                if($v['isprimarykey'] == 0){
                    $sql .= $v['name'] . " " . $v['type'] . " $notnull $default,";
                } else {
                    $sql .= $v['name'] . " " . $v['type'] . " PRIMARY KEY,";
                }
            }

            // Trim trailing comma and close statement
            $sql = rtrim($sql, ",");
            $sql .= ")";

            echo "$sql \r\n";

            $sqlite->exec($sql);

            echo "Table $table created.\r\n";

        }


        // SQL create table syntax cheatsheet
        // Primary key: FIELDNAME INTEGER PRIMARY KEY
        // Fields:      FIELDNAME  TYPE(LENGTH) NULL DEFAULT ''
        // Timestamp:   timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL

    }

    /***
     * @param $table
     */
    public static function drop_table($table)
    {
        $sqlite = new sqlite();
        $sql = "DROP TABLE $table";
        $sqlite->exec($sql);
        echo "Table $table dropped.\r\n";
    }

    /***
     * @param $source
     * @param $target
     */
    public static function copy_table($source, $target)
    {
        $sqlite = new sqlite();

        $sql = "CREATE TABLE $target AS SELECT * FROM $source";
        $sqlite->exec($sql);

        $sql = "INSERT INTO $target AS SELECT * FROM $source";
        $sqlite->exec($sql);

        echo "Table $table copied.\r\n";
    }

    /***
     * @param $source
     * @param $target
     */
    public static function convert_table($source, $target)
    {
        $sqlite = new sqlite();

        // Get source fields
        $pragma = $sqlite->query("PRAGMA table_info($source)");

        foreach($pragma as $k=>$v){
            $fieldcsv .= $v->name . ',';
        }

        $fieldcsv = rtrim($fieldcsv, ",");

        // Copy records
        $sql = "INSERT INTO $target ($fieldcsv) SELECT $fieldcsv FROM $source";
        $sqlite->exec($sql);

        echo "$sql \r\n";

        echo "Table $source converted to $target.\r\n";

    }

    /***
     * @param $source
     * @param $target
     */
    public static function dump_to_screen($table)
    {
        $sqlite = new sqlite();
        $data = $sqlite->query("SELECT * FROM $table");
        $data = json_decode(json_encode($data), true);
        //print_r($data);
        return $data;
    }


}
