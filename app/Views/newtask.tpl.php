<div class="container py-2">

    <p class="fs-4 fw-bold">ADD TASK FOR: <?= $project->name ?></p>

    <form action="/project/<?= $project->id ?>/save-task" method="POST">

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
                            <option value="<?= $user->username ?>">@<?= $user->username ?></option>
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
                    >
                    <label for="floatingDeadline">Deadline Date</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">SAVE</button>

    </form>

</div>
