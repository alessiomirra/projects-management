<main class="form-signin w-100 m-auto">
    <form class="text-center" action="<?= $signup ? '/signup' : '/login' ?>" method="POST">
        <input type="hidden" name="_csrf" value="<?= $token ?>">
        <p><i class="bi bi-cast" style="font-size: 3rem; color: cornflowerblue;"></i></p>
        <h1 class="h3 mb-5 fw-normal"><?= $signup ? 'Please Sign Up' : 'Please Sign In' ?></h1>

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

        <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="@username" name="username">
            <label for="floatingInput">Username</label>
        </div>
        <?php if($signup): ?>
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email">
                <label for="floatingInput">Email</label>
            </div>
        <?php endif;  ?>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
            <label for="floatingPassword">Password</label>
        </div>
        <button class="btn btn-primary w-100 py-2 mt-2 mb-3" type="submit">
            <?= $signup? 'Sign Up' : 'SIgn In' ?>
        </button>
        <?php if($signup): ?>
            <a href="/login" class="text-danger text-decoration-none">Sign In</a><br>
        <?php else:  ?>
            <a href="/signup" class="text-danger text-decoration-none">Sign Up</a><br>
            <a href="#" class="text-danger text-decoration-none">Password Forgot?</a><br>
        <?php endif  ?>
    </form>
</main>