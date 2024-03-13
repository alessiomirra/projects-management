<div class="container py-2">

    <p class="fs-4 fw-bold">EDIT PROJECT</p>

    <form action="/project/<?= $project->id ?>" method="POST">

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
                placeholder="Project's Title"
                value="<?= $project->name ?>"
                required
            >
            <label for="floatingTitle">Project's Title</label>
        </div>

        <div class="form-floating mb-3">
            <textarea 
                name="description" 
                class="form-control" 
                placeholder="Add a project's description here" 
                id="floatingDescription" 
                style="height: 100px"
            >
                <?= $project->description ?>
            </textarea>
            <label for="floatingDescription">Project's Description</label>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-floating mb-3">
                    <input 
                        type="date" 
                        name="deadline" 
                        id="floatingDeadline"
                        class="form-control"
                        value="<?= $project->deadline ?>"
                    >
                    <label for="floatingDeadline">Deadline Date</label>
                </div>
            </div>
        </div>

        <div class="form-floating mb-3">
            <textarea 
                name="notes" 
                class="form-control" 
                placeholder="Add project's notes here" 
                id="floatingNotes" 
                style="height: 70px"
            >
                <?= $project->notes ?>
            </textarea>
            <label for="floatingNotes">Additional Notes</label>
        </div>

        <button type="submit" class="btn btn-primary">SAVE</button>

    </form>

</div>