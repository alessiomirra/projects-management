<div class="container py-2">

    <p class="fs-4 fw-bold">EDIT TASK</p>

    <form action="/project/<?= $task->project_id ?>/task/<?= $task->id ?>" method="POST">

        <?php
            if(!empty($_SESSION['message'])) :?>
            <div class="alert alert-danger">
                <?php
                    echo htmlentities($_SESSION['message']);
                    $_SESSION['message'] = '';
                ?>
            </div>
            <?php
            endif;
        ?>

        <div class="form-floating mb-3">
            <input
                type="text" 
                name="name" 
                class="form-control" 
                id="floatingTitle" 
                placeholder="Task's Title"
                value="<?= $task->name ?>"
                required
            >
            <label for="floatingTitle">Task's Title</label>
        </div>

        <div class="form-floating mb-3">
            <textarea 
                name="description" 
                class="form-control" 
                placeholder="Add a task's description here" 
                id="floatingDescription" 
                style="height: 100px"
            >
                <?= $task->description ?>
            </textarea>
            <label for="floatingDescription">Task's Description</label>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <select
                        name="user" 
                        class="form-select" 
                        id="floatingUser" 
                        aria-label="Floating label select example"
                        required
                    >
                        <option></option>
                        <?php foreach($users as $user): ?>
                            <option
                                value="<?= $user->username ?>"
                                <?= $task->username === $user->username ? 'selected' : '' ?>
                            >
                            @<?= $user->username ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="floatingUser">Assigned To</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input 
                        type="date" 
                        name="deadline" 
                        id="floatingDeadline"
                        class="form-control"
                        value="<?= $task->deadline ?>"
                    >
                    <label for="floatingDeadline">Deadline Date</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <select name="status" id="floatingStatus" class="form-select">
                        <option value=""></option>
                        <option value="completed" <?= $task->status === 'completed' ? 'selected' : ''  ?>>completed</option>
                        <option value="working" <?= $task->status === 'working' ? 'selected' : ''  ?>>working</option>
                    </select>
                    <label for="floatingStatus">Status</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">SAVE</button>

    </form>

</div>

