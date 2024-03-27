<?php 
    $configs = require './config/app.config.php'; 
?>

<div class="container py-2">

    <?php

        if (array_key_exists('signedUp', $_SESSION) && $_SESSION['signedUp']): ?>
            <div class="alert alert-success">
                <?php
                    $link = "/user/edit/".getUserId();
                    echo 'You have successfully signed up! Go to '."<a href='$link'>Account Settings</a> ".'and set a first and last name, and an avatar for your account.';
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

    <!-- Query params and search --> 
    <div class="mb-2">
        <div class="row">
            <div class="col-md-6">

                <!-- Pagination navbar -->
                <?php
                    $totalPages =  $search ? ceil(count($projects) / $configs["page"]["recordsPerPage"]) : ceil($total / $configs["page"]["recordsPerPage"]);
                    $prevDisabled = ($page <= 1) ? "disabled" : "";
                    $nextDisabled = ($page >= $totalPages) ? "disabled" : "";    
                ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?= $prevDisabled ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= $search ?>">Previous</a>
                        </li>
                        <?php for ($i=1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $nextDisabled ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= $search ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <!---->

            </div>
            <div class="col-md-6">
                <!-- Search Form -->
                <form action="/" method="GET" class="d-flex justify-content-md-end">
                    <div class="me-1">
                        <label class="visually-hidden" for="searchField">Search Project</label>
                        <input type="text" class="form-control" name="search" id="searchField" placeholder="Title or Username">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
                <!---->
            </div>
        </div>
    </div>
    <!---->

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
                <?php if (count($projects)): ?>
                    <?php foreach($projects as $project){ ?>
                        <tr class="<?= $project->user_id === getUserId() ? 'table-info' : '' ?>">
                            <td><a href="/project/<?= $project->id ?>" class="text-black fw-bold text-decoration-none"><?= $project->name ?></a></td>
                            <td class="<?= $project->status == 'working' ? 'text-danger' : 'text-primary' ?>"><?= $project->status ?></td>
                            <td><a href="/user/<?= $project->username ?>" class="text-decoration-none">@<?= $project->username ?></a></td>
                            <td class="<?= getRemainingTime($project->deadline) ?>"><?= $project->deadline ?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <p>NO PROJECTS IN DATABASE</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <p>ALL PROJECTS NUMBER: <?= $total ?></p>

    </div>
</div>
