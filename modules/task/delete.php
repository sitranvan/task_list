<?php
$taskId = getBody()['task_id'] ?? '';
$task = getData('task', 'task_id', "task_id='$taskId'");
if (!empty($task)) {
    $taskId = $task['task_id'];
    $resultDelete = deleteData('task', "task_id='$taskId'");
    if ($resultDelete) {
        navigate('?module=task&action=list');
    } else {
        showMessage('An error occurred', 'error');
        navigate('?module=task&action=list', 1500);
    }
} else {
    navigate('?module=task&action=list');
}
