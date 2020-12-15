<?php $data = $this->getParams(); ?>

<main class="login-wrapper">
    <h1>REGISTER</h1>
    <form method="post" action="">
        <fieldset>
            <?php if (isset($data['errors'])) : ?>
                <div class="alert-danger"><?php echo $data['errors']; ?></div>
            <?php endif; ?>
            <input type="text" name="username" id="username" placeholder="utilisateur" required/>
            <input type="password" name="password" id="password" placeholder="mot de passe" required/>
            <input type="submit" id="submit" name="register_process" value="Register" />
            <p class="change-url">
                <a href="/login">login</a>
            </p>
        </fieldset>
    </form>
</main>