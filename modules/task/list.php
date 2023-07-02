<?php loadLayout('header');
$userLogin = getUserLogin();
if (!empty($userLogin)) {
    $userId = $userLogin['user_id'];
    $allTask = getAllData('task', '*', "user_id='$userId'");
}

?>
<div class="container mt-5">
    <h1 style="color: #7532f9;" class="text-center fw-bold text-uppercase mb-5">
        TASK LIST
        <i class="fa-solid fa-check-double"></i>
    </h1>
    <a href="?module=task&action=add" class="btn btn-primary fw-bold px-4 mb-3">Add New Task
        <i class="fa-solid fa-plus"></i>
    </a>
    <table class="table">
        <thead style="background-color: #7532f9; color:#fff;">
            <tr>
                <th width="10%">No</th>
                <th>Task</th>
                <th width="15%">StartTime</th>
                <th width="15%">Status</th>
                <th width="15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($allTask)) :
                $count = 0;
                foreach ($allTask as $task) :
                    $count++;
            ?>
                    <tr class="table-light">
                        <td scope="row"><?= $count ?></th>
                        <td><?= $task['description'] ?></td>
                        <td><?= explode(' ', $task['start_time'])[0] ?></td>
                        <td>
                            <?= $task['status'] == 0 ? '<button class="btn btn-warning">Pending</button>' :
                                '<button class="btn btn-success">Completed</button>'
                            ?>
                        </td>
                        <td class="d-flex align-items-center gap-3">
                            <a class="btn btn-sm btn-success" href="?module=task&action=completed&task_id=<?= $task['task_id'] ?>">
                                <i class="fa-solid fa-check"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" href="?module=task&action=delete&task_id=<?= $task['task_id'] ?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                            <a class="btn btn-sm bg-success text-white" href="?module=task&action=update&task_id=<?= $task['task_id'] ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>

                <?php endforeach;
            else : ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php loadLayout('footer') ?>