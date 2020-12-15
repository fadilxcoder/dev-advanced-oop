<?php $data = $this->getParams(); ?>

<main class="login-wrapper">
    <h1>LOGIN</h1>
    <form method="post" action="">
        <fieldset>
            <?php if (isset($data['errors'])) : ?>
                <div class="alert-danger"><?php echo $data['errors']; ?></div>
            <?php endif; ?>
            <?php if (isset($data['success'])) : ?>
                <div class="alert-success"><?php echo $data['success']; ?></div>
            <?php endif; ?>
            <input type="text" name="username" id="username" placeholder="utilisateur" required/>
            <input type="password" name="password" id="password" placeholder="mot de passe" required/>
            <input type="submit" id="submit" name="login_process" value="Login" />
            <p class="change-url">
                <a href="/register">register</a>
            </p>
        </fieldset>
    </form>
</main>