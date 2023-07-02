<?php
loadLayout('header');
if (isPost()) {
    $body = getBody();
    $errors = [];
    empty(trim($body['task'])) ? $errors['task'] = 'Tasks cannot be left blank' : '';
    empty($body['date']) ? $errors['date'] = 'The start date cannot be left blank' : '';


    if (empty($errors)) {
        $userLogin = getUserLogin();
        if (!empty($userLogin)) {
            $userId = $userLogin['user_id'];
            $dataInsert = [
                'user_id' => $userId,
                'description' => $body['task'],
                'start_time' => $body['date'],
                'create_at' => date('Y-m-d H:i:s')
            ];
            $resultInsert = insertData('task', $dataInsert);
            if ($resultInsert) {
                showMessage('Add successfully', 'success');
                navigate('?module=task&action=list', 1500);
            } else {
                showMessage('Add failure', 'error');
            }
        }
    } else {
        setFlashData('errors', $errors);
        setFlashData('pre_data', $body);
        navigate('?module=task&action=add');
    }
}
$errors = getFlashData('errors');
$preData = getFlashData('pre_data');

?>
<section class="mt-5">
    <div class="container d-flex justify-content-center">
        <form class="w-100 d-flex flex-column justify-content-center align-items-center" method="POST" action="">
            <h2 class="mb-5">Add New Task</h2>
            <div class="" style="width: 700px;">
                <div class="input-group input-group-lg w-100">
                    <span class="input-group-text bg-success text-white" id="inputGroup-sizing-lg">Task</span>
                    <input value="<?= $preData['task'] ?? '' ?>" name="task" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Enter your task...">
                </div>
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['task'] ?? '' ?></p>
                <div class="h-100">
                    <div class="fw-bold mb-1">-- Star Date --</div>
                    <input value="<?= $preData['date'] ?? '' ?>" name="date" style="height: 47.6px; width: 200px; border-radius: 4px; border:1px solid #afafaf; padding:0 10px;" type="date">
                    <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['date'] ?? '' ?></p>

                </div>
            </div>
            <button class="btn btn-success px-5 py-2 mt-4">
                Add Task
                <i class="fa-solid fa-plus ms-1"></i>
            </button>

        </form>

    </div>
</section>
<?php
loadLayout('footer');
?>