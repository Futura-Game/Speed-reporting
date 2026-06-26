<?php

use Src\Services\AuthService;
use Src\Services\BreadcrumbService;

$breadcrumbs = BreadcrumbService::getBreadcrumbs();

?>

<div class="breadcrumb">
    <div class="profile">
        <div class="profile-photo" id="profile-photo">
            <a class="button view"><img src="<?= AuthService::getUser()->getPicture(); ?>" alt="Photo utilisateur"></a>
        </div>
        <div class="info">
            <p id="greeting">Bonjour <?= AuthService::getRole()->getFr(); ?>
            <span id="user-firstname"><?= AuthService::getUser()->getFirstname(); ?></span> !</p>
            <p>Bienvenue sur (<?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
            <span class="breadcrumb-item">
                <?php if ($breadcrumb["url"]): ?>
                    <a href="<?= htmlspecialchars($breadcrumb["url"]) ?>"><?= htmlspecialchars($breadcrumb["name"]) ?></a>
                <?php else: ?>
                    <span><?= htmlspecialchars($breadcrumb["name"]) ?></span>
                <?php endif; ?>
                
                <?php if ($index < count($breadcrumbs) - 1): ?>
                    <span class="breadcrumb-separator"> > </span>
                <?php endif; ?>
            </span>
                <?php endforeach; ?>)</p>
        </div>
    </div>
    
    <div>
        <a href="/deconnexion" class="ajax-link">
            <img src="Icone/DéconnexionR.png" alt="Déconnexion" width="60" height="60">
        </a>
    </div>
</div>