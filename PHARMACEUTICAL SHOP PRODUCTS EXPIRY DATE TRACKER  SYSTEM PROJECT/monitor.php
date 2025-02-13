<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task=$_POST['task'];
     
    switch ($task) {
        case 'restart':
            $command= 'shutdown /r/t 0';
            break;
        case 'list_users':
            $command= 'net user';
            break;
        case 'check_disk':
            $command= 'wmic logicaldisk get size,freespace,caption';
            break;
        default:
            echo 'Invalid task';
            exit;
    }
    //Execute the command
    $output=shell_exec($command);

    if($output===null){
        echo 'Error executing command';
    }else{
        echo '<pre>' .htmlspecialchars($output). '<pre>';
    }
}
?>