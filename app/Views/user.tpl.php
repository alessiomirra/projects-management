<?php 
    $defaultAvatarDir = '/sources/';
    $avatarDir = "/avatar/";
?>

<div class="container py-2">

    <ul class="nav container">
        <li class="nav-item">
            <img src="<?= !$result->avatar ? $defaultAvatarDir."thumb_default_avatar.jpeg" : $avatarDir.$result->avatar ?>" class="avatar-img me-2"/>
        </li>
        <li class="nav-item">
            <p class="fs-4 fw-bold">@<?= $result->username ?></p>
        </li>
        <?php if ($result->username !== getUserUsername()): ?>
            <li class="nav-item">
                <a class="nav-link" href="mailto:<?= $result->email ?>"><?= $result->email ?></a>
            </li>
            <li class="nav-item ms-auto">
                <a class="nav-link text-decoration-none text-secondary"><?= count($tasks) ?> Tasks</a>
            </li>
        <?php endif; ?>
        <?php if($result->username === getUserUsername()): ?>
            <li class="nav-item ms-auto">
                <a class="nav-link" href="/user/edit/<?= $result->id ?>"><i class="bi bi-gear"></i> Account Settings</a>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete Account</button>
            </li>
        <?php endif; ?>
    </ul>

    <?php if ($result->username === getUserUsername()): ?>
        <p><?= count($tasks) ?> Tasks</p>
    <?php endif; ?>

    <table class="table border mb-4">
        <tbody>
            <tr>
                <td><span class="fw-bold">Username: </span>@<?= $result->username ?></td>
                <td><span class="fw-bold">Email: </span><a href="mailto:<?= $result->email ?>"><?= $result->email ?></a></td>
            </tr>
            <tr>
                <?php if($result->first_name && $result->last_name): ?>
                    <td><span class="fw-bold">Name: </span><?= $result->first_name ?> <?= $result->last_name ?></td>
                <?php endif; ?>
                <td><span class="fw-bold">Role: </span><?= $result->roletype ?></td>
            </tr>
        </tbody>
    </table>

    <p class="fs-5 fw-bold">Tasks List</p>
    
    <?php if (count($tasks)): ?>
        <div class="list-group mb-5">
            <?php foreach($tasks as $task): ?>
                <div class="list-group-item list-group-item-action" aria-current="true">
                    <div class="d-flex w-100 justify-content-between">
                        <div>
                            <h5 class="mb-1"><?= $task->name ?></h5>
                            <?php if($task->username === getUserUsername() || isUserAdmin()): ?>
                                <div class="form-group d-flex mb-2">
                                    <?php if ($task->status === 'completed'): ?>
                                        <form action="/task/<?= $task->id ?>/delete" method="POST">
                                            <button class="btn btn-sm btn-outline-danger">DELETE</button>
                                        </form>
                                    <?php else:  ?>
                                        <form action="/task/<?= $task->id ?>/completed" method="POST">
                                            <button class="btn btn-sm btn-outline-success">COMPLETED</button>
                                        </form>
                                    <?php endif;  ?>
                                        <form action="/project/<?= $task->project_id ?>/task/<?= $task->id ?>" method="GET" class="ms-2">
                                            <button class="btn btn-sm btn-outline-primary">EDIT</button>
                                        </form>
                                </div>
                            <?php endif; ?>
                        </div>
                        <small><?= $task->creation ?></small>
                    </div>
                    <p class="mb-1"><?= $task->description ?></p>
                    <div class="d-flex w-100 justify-content-between">
                        <div>
                            <small>ASSIGNED TO: <a href="/user/<?= $task->username ?>"><?= $task->username ?></a></small><br>
                            <small>STATUS: <span class="<?= $task->status === 'working' ? 'text-danger' : 'text-primary' ?>">
                                <?php if($task->status === 'working'): ?>
                                        <?= 'WORKING' ?>
                                <?php else: ?>
                                        <?= 'COMPLETED' ?>
                                <?php endif; ?>
                                </span>
                            </small>
                        </div>
                        <small>DEADLINE: <span class="<?= getRemainingTime($task->deadline) ?>"><?= $task->deadline ?></span></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div>
            <p>No tasks for this user</p>
        </div>
    <?php endif; ?>


</div>


<!-- Delete Account Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">DELETE YOUR ACCOUNT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete your account?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        <form action="/delete-account/<?= $result->id ?>" method="POST">
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
        
      </div>
    </div>
  </div>
</div>