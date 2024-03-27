<?php 
    $defaultAvatarDir = '/sources/';
    $avatarDir = "/avatar/";
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Management</title>

    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>
    
    <header>

        <nav class="navbar bg-primary" data-bs-theme="dark">

            <div class="container-fluid">
                <a class="navbar-brand" href="/"><i class="bi bi-cast me-2" style="font-size: 1.2rem;"></i> PROJECTS MANAGEMENT</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

        </nav>

    </header>

    <main>

        <div>

            <div class="row">

                <div class="col-md-2">

                    <ul class="nav flex-column vh-100 overflow-y-scroll bg-primary bg-gradient" id="vertical-menu">
                        <li class="nav-item mb-3">
                            <div class="bg-primary">
                                <p class="nav-link text-white mb-0">
                                    <strong>Menu</strong>
                                </p>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?= $_SERVER['REQUEST_URI'] === '/' ? 'fw-bold' : '' ?>" href="/"><i class="bi bi-house"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#collapseProject" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseProject"><i class="bi bi-cast"></i> Projects</a>
                            <div class="collapse" id="collapseProject">
                                <div class="ms-3">
                                    <a class="nav-link text-white <?= $_SERVER['REQUEST_URI'] === '/project/create' ? 'fw-bold' : '' ?>" href="/project/create"><i class="bi bi-cloud-plus"></i> Add New</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?= $_SERVER['REQUEST_URI'] === '/users' ? 'fw-bold' : '' ?>" href="/users"><i class="bi bi-people"></i> Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#"><i class="bi bi-calendar"></i> Calendar</a>
                        </li>

                        <hr class="mx-2">

                        <li class="nav-item">
                            <?php if (isUserLoggedIn()): ?>
                            <div class="accordion container-fluid" id="userMenuAccordion">
                                <div class="accordion-item">
                                    <p class="accordion-header">
                                        <button class="accordion-button <?= getUserLoggedInFullname() === 'admin' ? 'bg-danger bg-opacity-50':''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <img src="<?= getUserAvatar() === "" ? $defaultAvatarDir."thumb_default_avatar.jpeg" : $avatarDir.getUserAvatar() ?>" alt="#" class="avatar-img me-2" />
                                            @<?= getUserLoggedInFullname() ?>
                                        </button>
                                    </p>
                                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#userMenuAccordion">
                                        <div class="accordion-body">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link text-dark" href="/user/<?= getUserUsername() ?>"><i class="bi bi-person"></i> My Page</a>
                                                    <form class="form" role="form" method="POST" action="/logout">
                                                        <input type="hidden" name="action" value="logout">
                                                        <button  class="nav-link text-dark"><i class="bi bi-box-arrow-left"></i> Logout</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="d-grid mx-2">
                                <a href="/login" class="btn btn-danger" type="button">Sign In</a>
                            </div>
                            <?php endif; ?>
                        </li>

                        <li class="nav-item text-center mt-3">
                            <p class="text-light mb-0"><?= date('j F Y') ?></p> 
                            <p class="text-light"><?= date('G:i') ?></p> 
                        </li>

                    </ul>

                </div>

                <div class="col-md-10">

                    <div class="vh-100 overflow-y-scroll">
                        <?= $this->content ?>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Offcanvas menu -->
    <div class="offcanvas offcanvas-start text-bg-primary" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">

        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">
                <strong>Menu</strong>
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a class="nav-link text-white" href="/"><i class="bi bi-house"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#collapseProject" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseProject"><i class="bi bi-cast"></i> Projects</a>
                    <div class="collapse" id="collapseProject">
                        <div class="ms-3">
                            <a class="nav-link text-white" href="/project/create"><i class="bi bi-cloud-plus"></i> Add New</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="bi bi-calendar"></i> Calendar</a>
                </li>

                <hr class="mx-2">

                <li class="nav-item">
                    <?php if (isUserLoggedIn()): ?>
                    <div class="accordion container-fluid" id="userMenuAccordion">
                        <div class="accordion-item">
                            <p class="accordion-header">
                                <button class="accordion-button <?= getUserLoggedInFullname() === 'admin' ? 'bg-danger bg-opacity-50':''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <img src="<?= getUserAvatar() === "" ? $defaultAvatarDir."thumb_default_avatar.jpeg" : $avatarDir.getUserAvatar() ?>" alt="#" class="avatar-img me-2" />
                                    @<?= getUserLoggedInFullname() ?>
                                </button>
                            </p>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#userMenuAccordion">
                                <div class="accordion-body">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" href="/user/<?= getUserUsername() ?>"><i class="bi bi-person"></i> My Page</a>
                                            <form class="form" role="form" method="POST" action="/logout">
                                                <input type="hidden" name="action" value="logout">
                                                <button  class="nav-link text-dark"><i class="bi bi-box-arrow-left"></i> Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="d-grid mx-2">
                            <a href="/login" class="btn btn-danger" type="button">Sign In</a>
                        </div>
                    <?php endif; ?>
                </li>

                <li class="nav-item text-center mt-3">
                    <p class="text-light mb-0"><?= date('j F Y') ?></p> 
                    <p class="text-light"><?= date('G:i') ?></p> 
                </li>

            </ul>

        </div>

    </div>
    <!---->

    <script src="/js/bootstrap.js"></script>
    <script src="/js/index.js"></script>

</body>
</html>
