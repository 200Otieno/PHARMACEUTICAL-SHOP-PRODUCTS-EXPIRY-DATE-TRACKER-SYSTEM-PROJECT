<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $backupTask = $_POST['backupTask'];
    $serverTask =$_POST['serverTask'];
    $output= '';

    //Handle Backup Exec tasks
    switch($backupTask) {
        case 'start_backup':
            $command= 'bemcmd -o90 -fYOUR_BACKUP_JOB';
            break;
        case 'check_backup_status':
            $command= 'bemcmd -o503 -jYOUR_BACKUP_JOB';
            break;
        default:
            $command= '';
    }
    if ($command){
        //Execute Backup Exec command
        $output .=shell_exec($command);
    }

    //Handle Windows Server stalks
    switch($serverTask){
        case 'restart':
            $command= 'shutdown r/t 0';
            break;
        case 'list_users':
            $command= 'net user';
            break;
        case 'check_disk':
            $command= 'wmic logicaldisk get size,freespace,caption';
            break;
        default:
            $command='';
    }
    if($command){
        //Execute server command
        $output .=shell_exec($command);
    }
    if($output=== null){
        echo 'Error excuting command';
    }else{
        echo '<pre>'. htmlspecialchars($output). '<pre>';
    }
}
?>