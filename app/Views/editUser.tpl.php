<div class="container py-2">

    <p class="mb-0 fs-4"><span class="fw-bold">Edit your account: </span>@<?= $user->username ?></p>
    <small class="mt-0">After the profile editing you will be logged out</small>

    <form action="/user/edit/<?= $user->id ?>" method="POST" class="mt-4">

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

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input
                        type="text" 
                        name="username" 
                        class="form-control" 
                        id="floatingUsername" 
                        placeholder="Username"
                        value="<?= $user->username ?>"
                        required
                    >
                    <label for="floatingTitle">Username</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input
                        type="email" 
                        name="email" 
                        class="form-control" 
                        id="floatingEmail" 
                        placeholder="Email"
                        value="<?= $user->email ?>"
                        required
                    >
                    <label for="floatingEmail">Email</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input 
                        type="text"
                        name="first_name"
                        class="form-control"
                        id="floatingFirstName"
                        placeholder="First Name"
                        value="<?= $user->first_name ?>"
                    >
                    <label for="floatingFirstName">First Name</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input 
                        type="text"
                        name="last_name"
                        class="form-control"
                        id="floatingLastName"
                        placeholder="Last Name"
                        value="<?= $user->last_name ?>"
                    >
                    <label for="floatingLastName">Last Name</label>
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">SAVE</button>
        </div>

    </form>

</div>