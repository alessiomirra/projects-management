<?php 
    $defaultAvatarDir = '/sources/';
    $avatarDir = "/avatar/";
?>

<div class="container py-2">

    <p class="fs-4 fw-bold">ALL USERS</p>

    <div class="table-responsive-md">

        <table class="table">
            <caption><?= count($users) ?> users</caption>
            <thead>
                <tr>
                    <th style="width: 10%;" scope="col">AVATAR</th>
                    <th scope="col">USERNAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">NAME</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users)): ?>
                    <?php foreach($users as $user){ ?>
                        <tr class="<?= $user->roletype === "admin" ? 'table-info' : '' ?> <?= $user->username === getUserUsername() ? 'table-secondary' : '' ?>">
                            <td>
                                <img src="<?= !$user->avatar ? $defaultAvatarDir."thumb_default_avatar.jpeg" : $avatarDir.$user->avatar ?>" class="avatar-img"/>
                            </td>
                            <td><a href="/user/<?= $user->username ?>">@<?= $user->username ?></a></td>
                            <td><a href="mailto:<?= $user->email ?>">@<?= $user->email ?></a></td>
                            <td><?= $user->first_name && $user->last_name ? "$user->first_name $user->last_name" : " - "?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <p>NO USERS</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>