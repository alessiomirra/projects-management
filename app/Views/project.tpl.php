<div class="container py-2">

    <div class="row">

        <div class="col-md-10">
            <h3><?= $project->name ?></h3>
            <?php if (isUserLoggedIn() && userCanManageProject($project->username)): ?>
                <div class="form-group d-flex mb-2">
                    <a href="/project/<?= $project->id ?>/new-task" class="btn btn-sm btn-outline-primary">+ ADD TASK</a>
                    <form action="/project/<?= $project->id ?>/edit" method="GET" class="ms-2">
                        <button type="submit" class="btn btn-sm btn-outline-success"> EDIT</button>
                    </form>
                    <form action="/project/<?= $project->id ?>/delete" method="POST" class="ms-2">
                        <button type="submit" class="btn btn-sm btn-outline-danger">DELETE</button>
                    </form>
                </div>
            <?php endif;  ?>
        </div>

        <div class="col-md-2">
            <p class="text-muted"><?= count($tasks); ?> TASKS</p>
        </div>
    </div>

    <p><?= $project->description ?></p>

    <div class="container border rounded-3 py-2">
        <div class="row">
            <div class="col-md-4">
                <p><span class="fw-bold">SUPERVISOR:</span> <a href="/user/<?= $project->username ?>">@<?= $project->username ?></a></p>
            </div>
            <div class="col-md-4">
                <p><span class="fw-bold">START:</span> <span><?= $project->start ?></span></p>
            </div>
            <div class="col-md-4">
                <p><span class="fw-bold">DEADLINE:</span> <span class="<?= getRemainingTime($project->deadline) ?>"><?= $project->deadline ?></span></p>
            </div>
        </div>
    </div>

    <!-- Tasks --> 
    <div class="mt-3">
        <p class="fw-bold">TASKS LIST</p>

        <div class="list-group mb-2">
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
                                    <form action="/project/<?= $project->id ?>/task/<?= $task->id ?>" method="GET" class="ms-2">
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

    </div>
    <!-- Tasks --> 

    <?php if($project->notes): ?>
        <hr>

        <p><span class="fw-bold">NOTES:</span></p>
        <p><?= $project->notes ?>

    <?php endif;  ?>

    <hr>
    
    <?php if(count($tasks)): ?>
        <p><span class="fw-bold">PARTECIPANTS:</span></p>
        <p>
            <?php foreach($partecipants as $partecipant) ?>
                <a class="me-2" href="/user/<?= $partecipant ?>">@<?= $partecipant ?></a>
            <?php ?>
        </p>
    <?php endif; ?>
    
    <hr>

    <p><span class="fw-bold">PROJECT'S RESOURCES</span></p>

    <!-- Add file resource form --> 
    <?php if ((in_array(getUserUsername(), $partecipants) || userCanManageProject($project->username)) && isUserLoggedIn()): ?>
        <div class="mb-3">
            <a class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" href="#fileForm" role="button" aria-expanded="false" aria-controls="fileForm">
                + ADD A RESOURCE
            </a>
            <div class="collapse" id="fileForm">
                <div class="card card-body">
                    
                    <form action="/addFile/<?= $project->id ?>/<?= $_SESSION["userData"]["id"] ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <input type="file" class="form-control" id="fileInput" name="resource" accept=".jpeg, .jpg, .pdf" required>
                            </div>
                            <div class="col-md-7 mb-3">
                                <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">SAVE</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <!---->
    
    <?php if (count($files)): ?>
        <div class="table-responsive-md">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">FILE</th>
                        <th scope="col">DESCRIPTION</th>
                        <th scope="col">TYPE</th>
                        <th scope="col">OWNER</th>
                        <th scope="col">DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($files as $file){ ?>
                        <tr>
                            <td><a href="/file/<?= $file->id ?>" class="text-decoration-none"><?= $file->path ?></a></td>
                            <td><?= $file->description ?></td>
                            <td><?= $file->extension ?></td>
                            <td><a href="/user/<?= $file->username ?>" class="text-decoration-none">@<?= $file->username ?></a></td>
                            <td><?= $file->timestamp ?></td>
                            <?php  if ($file->user_id === getUserId() || isUserAdmin()): ?>
                                <td>
                                    <form action="/file/delete/<?= $file->id ?>" method="POST">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">DELETE</button>
                                    </form>
                                </td>
                            <?php  endif; ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    <?php else: ?>
        <div class="text-center">
            <p>No resources for that project</p>
        </div>
    <?php endif; ?>

</div>
