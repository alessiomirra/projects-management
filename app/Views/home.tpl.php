<div class="container py-2">
        <?php

        if (array_key_exists('signedUp', $_SESSION) && $_SESSION['signedUp']): ?>
            <div class="alert alert-success">
                <?php
                    $link = "/user/edit/".getUserId();
                    echo 'You have successfully signed up! Go to '."<a href='$link'>Account Settings</a> ".'and set a first and last name';
                    $_SESSION['signedUp'] = '';
                ?>
            </div>
        <?php endif; ?>

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

    <div class="table-responsive-md">

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50%;" scope="col">TITLE</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">OWNER</th>
                    <th scope="col">DEADLINE</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projects as $project){ ?>
                    <tr class="<?= $project->user_id === getUserId() ? 'table-info' : '' ?>">
                        <td><a href="/project/<?= $project->id ?>" class="text-black fw-bold text-decoration-none"><?= $project->name ?></a></td>
                        <td class="<?= $project->status == 'working' ? 'text-danger' : 'text-primary' ?>"><?= $project->status ?></td>
                        <td><a href="/user/<?= $project->username ?>" class="text-decoration-none">@<?= $project->username ?></a></td>
                        <td class="<?= getRemainingTime($project->deadline) ?>"><?= $project->deadline ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>
