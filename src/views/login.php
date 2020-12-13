<?php $data = $this->getParams(); ?>

<main class="login-wrapper">
    <h1>Identification</h1>
    <form method="post" action="/index.php?action=login">
        <fieldset>
            <?php if (isset($data['errors'])) : ?>
                <div class="alert-danger"><?php echo $data['errors']; ?></div>
            <?php endif; ?>
            <input type="text" name="username" id="username" placeholder="utilisateur" required/>
            <input type="password" name="password" id="password" placeholder="mot de passe" required/>
            <input type="submit" id="submit" name="login_process" value="Connexion" />
        </fieldset>
    </form>
</main>