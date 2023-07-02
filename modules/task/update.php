<?php
loadLayout('header');
$taskId = getBody()['task_id'];
$task = getData('task', 'task_id', "task_id='$taskId'");
if (!empty($task)) {
    $taskId = $task['task_id'];
    $task = getData('task', '*', "task_id='$taskId'");
    setFlashData('task', $task);
}
if (isPost()) {
    $body = getBody();
    $errors = [];
    empty(trim($body['task'])) ? $errors['task'] = 'Tasks cannot be left blank' : '';
    empty($body['date']) ? $errors['date'] = 'The start date cannot be left blank' : '';
    if (empty($errors)) {
        $dataUpdate = [
            'description' => $body['task'],
            'start_time' => $body['date'],
            'status' => $body['status'],
            'update_at' => date('Y-m-d H:i:s')
        ];
        $resultUpdate = updateData('task', $dataUpdate, "task_id='$taskId'");
        if ($resultUpdate) {
            showMessage('Update successfully', 'success');
            navigate('?module=task&action=list', 1500);
        } else {
            showMessage('Add failure', 'error');
        }
    } else {
        setFlashData('errors', $errors);
        navigate('?module=task&action=update&task_id=' . $taskId);
    }
}


$task = getFlashData('task');
$errors = getFlashData('errors');

?>

<section class="mt-5">
    <div class="container d-flex justify-content-center">
        <form class="w-100 d-flex flex-column justify-content-center align-items-center" method="POST" action="">
            <h2 class="mb-5">Update Task</h2>
            <div class="" style="width: 700px;">
                <div class="input-group input-group-lg w-100">
                    <span class="input-group-text bg-success text-white" id="inputGroup-sizing-lg">Task</span>
                    <input value="<?= $task['description'] ?? '' ?>" name="task" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Enter your task...">
                </div>
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['task'] ?? '' ?></p>
                <div>
                    <div class="fw-bold mb-1">-- Star Date --</div>
                    <input class="w-50" value="<?= !empty($task['start_time']) ? explode(' ', $task['start_time'])[0] :  false ?>" name="date" style="height: 47.6px; border-radius: 4px; border:1px solid #afafaf; padding:0 10px;" type="date">
                    <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['date'] ?? '' ?></p>
                </div>

                <div class="">
                    <div class="fw-bold mb-1">-- Status --</div>
                    <select name="status" class="form-select w-50" style="height: 47.6px;" aria-label="Default select example">
                        <option <?= (!empty($task['status']) && $task['status'] == 0) ? 'selected' : false ?> value="0">Pending</option>
                        <option <?= (!empty($task['status']) && $task['status'] == 1) ? 'selected' : false ?> value="1">Completed</option>
                    </select>
                </div>

            </div>
            <button class="btn btn-success px-5 py-2 mt-4">
                Update
                <i class="fa-solid fa-pen-to-square ms-1"></i>
            </button>
            <input type="hidden" name="task_id" value="<?= $taskId ?>">

        </form>

    </div>
</section>
<?php loadLayout('footer') ?>