<?php $data = $this->getParams(); ?>

<header class="dashboard-nav">
    <ul>
        <li><a href="/">Accueil</a></li>
        <li><a href="?action=logout">Déconnexion</a></li>
    </ul>
</header>
<main class="dashboard-wrapper">
    <div id="clickblock">
        <?php if (isset($data['noRights']) && $data['noRights']) : ?>
            <div class="alert-danger">Vous n'avez pas les permissions pour voir ce contenu !</div>
        <?php else: ?>
            <a onclick="autoCorrect(this); return false;">Il y a des fotes dan sete fraz. Cliké ici pour lé corrigés.</a>
        <?php endif; ?>
    </div>
</main>