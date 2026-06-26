<?php

use Src\Services\AuthService;

$role = AuthService::getRole()->getId();

?>

<nav class="navbar">
    <div class="sidebar-backdrop"></div>
    <!-- Bouton de menu pour mobile -->
    <div class="menu-btn">
        <i class='bx bx-chevron-right icon'></i>
    </div>
    <aside class="sidebar">

        <!-- Logo et nom de l'application -->
        <div class="head">
            <div class="logo-details">
                <a href="/">
                    <img src="/assets/images/logos/logo-light.png" alt="Logo Speed Reporting" class="logo-details-img"
                        data-logo-big="/assets/images/logos/logo-light-big.png"
                        data-logo-small="/assets/images/logos/logo-light-small.png"
                        data-logo-dark="/assets/images/logos/logo-dark-big.png">
                </a>
            </div>
        </div>

        <!-- Menu principal -->
        <div class="nav">
            <div class="menu">
                <p class="title">Principal</p>
                <ul>
                    <li>
                        <a href="/">
                            <img src="/Icone/Maison.png" alt="Maison" width="32" height="32">
                            <span class="text">Home</span>
                        </a>
                    </li>
                    <?php if ($role == 1): ?>
                        <li>
                            <a href="/heures">
                                <img src="/Icone/Horaires.png" alt="Horaires" width="32" height="32">
                                <span class="text">Horaires</span>
                            </a>
                        </li>
                        <li>
                            <a href="/projets">
                                <img src="/Icone/Projet.png" alt="Projet" width="32" height="32">
                                <span class="text">Projets</span>
                            </a>
                        </li>
                        <li>
                            <a href="/utilisateurs">
                                <img src="/Icone/Utilisateur.png" alt="Utilisateur" width="32" height="32">
                                <span class="text">Utilisateurs</span>
                            </a>
                        </li>
                        <li>
                            <a href="/clients">
                                <img src="/Icone/Client.png" alt="Client" width="32" height="32">
                                <span class="text">Clients</span>
                            </a>
                        </li>
                        <li>
                            <a href="/planning"> <!--ATTENTION A GERER L'ACCES -->
                                <img src="/Icone/Planing.png" alt="Planning" width="32" height="32">
                                <span class="text">Planning</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($role == 2): ?>
                        <li>
                            <a href="/mes-projets"> <!--ATTENTION A GERER L'ACCES -->
                                <img src="/Icone/Projet.png" alt="Projet" width="32" height="32">
                                <span class="text">Projets</span>
                            </a>
                        </li>
                        <li>
                            <a href="/mon-planning"> <!--DEVIENDRA "MON PLANNING" --><!--ATTENTION A GERER L'ACCES -->
                                <img src="/Icone/Planing.png" alt="Planning" width="32" height="32">
                                <span class="text">Planning</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Menu de paramètres -->
        <div class="menu">
            <p class="title">Compte</p>
            <ul>
                <li>
                    <a href="#" class="ajax-link" id="settings-button">
                        <img src="/Icone/Paramètre.png" alt="Paramètre" width="32" height="32">
                        <span class="text">Paramètres</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="ajax-link" id="help-button">
                        <img src="/Icone/Aide.png" alt="Aide" width="32" height="32">
                        <span class="text">Aide</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</nav>
<div class="toast-container" id="toast-container"></div>
<?php include_once __DIR__ . "/_settings.html.php" ?>
<?php include_once __DIR__ . "/_help.html.php" ?>