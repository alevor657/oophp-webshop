<section class="profile-wrapper">
    <form class="profile-form" action="<?= $app->url->create('updateProfile') ?>" method="post">
        <h1>Hi, <?= $data->username ?></h1>

        <p>Id: <?= $data->id ?> </p>

        <p>Username:</p>
        <input type="text" name="uname" placeholder="<?= $data->username ?>" required>

        <p>Password:</p>
        <input type="password" name="psw" value="" required>

        <input type="text" name="id" value="<?= $data->id ?>" hidden>

        <p>
            Admin?
            <input class="admin-checkbox"type="checkbox" name="admin" value="1">
        </p>

        <input type="submit" name="" value="Update">

        <p><?= $app->cookie->get($data->username) ?></p>
    </form>
</section>
