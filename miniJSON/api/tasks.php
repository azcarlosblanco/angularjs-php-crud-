<?php
/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 */
class tasks
{
    public function __construct()
    {
    }

    public static function get($taskId=false)
    {

        $input = json_decode(file_get_contents('php://input'));

        $sqlite = new sqlite();

        if($taskId){
            $data['tasks'] = $sqlite->query('SELECT * FROM tasks WHERE taskId = :taskId', array(':taskId' => $taskId));
        } else {
            $data['tasks'] = $sqlite->query('SELECT * FROM tasks');
        }

        return $data;
    }

    public static function put()
    {
        $input = json_decode(file_get_contents('php://input'));

        $statement = 'INSERT INTO tasks (task, status, created_by, created_at, assigned_to, due_date)
                                  values (:task, :status, :created_by, :created_at, :assigned_to, :due_date)';

        $parameters = array(
            ':task' => $input->task,
            ':status' => $input->status,
            ':created_by' => $input->created_by,
            ':created_at' => $input->created_at,
            ':assigned_to' => $input->assigned_to,
            ':due_date' => $input->due_date
        );

        $sqlite = new sqlite();

        return $sqlite->exec($statement, $parameters);
    }

    public static function update()
    {

        $input = json_decode(file_get_contents('php://input'));

        $parameters = Array();
        $fields = "";

        foreach ($input as $k=>$v){
            if($k != 'username' && $k != 'token' && $k != 'taskId'){
                $parameters[$k] = $v;
                $fields .= "$k = :$k,";
            }
        }

        // debug
        error_log(implode(";", $parameters), 0);

        $parameters[':taskId'] = $input->taskId;

        $statement = 'UPDATE tasks SET ' . rtrim($fields, ',') . ' WHERE taskId = :taskId';

        $sqlite = new sqlite();

        return $sqlite->exec($statement, $parameters);

    }

    public static function delete()
    {
        $input = json_decode(file_get_contents('php://input'));

        $statement = 'DELETE FROM tasks WHERE taskId = :taskId';

        $parameters = array(
            ':taskId' => $input->taskId,
        );

        $sqlite = new sqlite();

        return $sqlite->exec($statement, $parameters);
    }

}
