<?php
$taskId = getBody()['task_id'] ?? '';
$task = getData('task', 'task_id', "task_id='$taskId'");
if (!empty($task)) {
    $taskId = $task['task_id'];
    $dataUpdate = [
        'status' => 1,
        'update_at' => date('Y-m-d H:i:s')
    ];
    $resultUpdate = updateData('task', $dataUpdate, "task_id='$taskId'");
    if ($resultUpdate) {
        navigate('?module=task&action=list');
    } else {
        showMessage('An error occurred', 'error');
        navigate('?module=task&action=list', 1500);
    }
} else {
    navigate('?module=task&action=list');
}
