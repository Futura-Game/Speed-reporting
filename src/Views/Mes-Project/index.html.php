<?php

function showMesProjectPage() {
    
    // 1. DÉMARRER LA SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2. VÉRIFICATION AVEC LA VRAIE CLÉ DE SESSION TRAUVÉE (user -> id)
    if (!isset($_SESSION['user']['id'])) {
        die("Erreur : Vous devez être connecté pour accéder à cette page.");
    }

    // On extrait le 10 de manière totalement dynamique
    $current_user_id = $_SESSION['user']['id']; 

    // 3. LE RESTE DE TON CODE RESTE IDENTIQUE
    \Src\Services\AssetService::addStyle(['_sidebar.css', '_breadcrumb.css', 'Modal.css', 'Table.css', 'Button.css', '_settings.css', '_help.css']);
    \Src\Services\AssetService::addScript(['_sidebar.js', '_breadcrumb.js', 'Table.js', '_settings.js', '_help.js']);

    $page_title = "Project";

    try {
        $db = new PDO('mysql:host=db;dbname=speed_reporting;charset=utf8', 'root', 'root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }

    $query = $db->prepare("
        SELECT p.* FROM table_project p
        JOIN table_project_user pu ON p.project_id = pu.project_user_project_id
        WHERE pu.project_user_user_id = :user_id
    ");
    $query->execute(['user_id' => $current_user_id]);
    $projects = $query->fetchAll(PDO::FETCH_ASSOC);

    require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_top.html.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_sidebar.html.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_breadcrumb.html.php';
    ?>
    
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
    background-color: #0f172a;
    color: #ffffff;
}

.container {
    display: flex;
    flex: 1; 
    width: 100%;
    position: relative;
    margin-top: 80px;
}

.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    width: 100%;
}

.workzone-container {
    flex: 1; 
    width: 100%;
    padding: 32px; 
    box-sizing: border-box; 
    overflow-y: auto; 
    display: flex;
    flex-direction: column;
}

/* --- FILTRES PASSÉS À 3 COLONNES (SANS BOUTON) --- */
.filter-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 32px;
}

.filter-box {
    background-color: #031898;
    padding: 12px 16px;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.filter-box h4 {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #d1d5db;
}

.filter-input {
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    color: #ffffff;
    font-size: 14px;
    padding: 6px 10px;
    outline: none;
    width: 100%;
    transition: border-color 0.2s;
}

.filter-input:focus {
    border-color: #feee01;
}

.filter-input::placeholder {
    color: #a1a1aa;
}

.filter-select {
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 14px;
    font-weight: bold;
    outline: none;
    cursor: pointer;
    width: 100%;
    padding: 4px 0;
}

.filter-select option {
    background-color: #031898;
    color: #ffffff;
}

/* PROJECTS GRID */
.projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.project-card {
    background-color: #031898;
    border-radius: 8px;
    padding: 24px;
    position: relative;
    min-height: 140px;          
    display: flex;
    flex-direction: row;        
    align-items: center;        
    justify-content: space-between; 
    cursor: pointer;
    transition: all 0.2s;
}

.project-card h3 {
    font-size: 18px;            
    font-weight: bold;
    margin-bottom: 0;           
    text-align: left;           
    flex: 1;                    
    padding-right: 15px;        
}

.status-bars {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: center;        
    justify-content: center;    
}

.status-bars .icon {
    display: flex;
    align-items: center;        
    justify-content: center;    
    width: 40px;
    height: 40px;
}

.status-bars .icon img {
    width: 100%;                
    height: 100%;
    object-fit: contain;
}

.bar {
    width: 64px;
    height: 16px;
    border-radius: 4px;
}

.bar.yellow { background-color: #feee01; }
.bar.gray   { background-color: #c2c2c2; }
.bar.red    { background-color: #e62112; }
.bar.orange { background-color: #ff9500; }
.bar.green  { background-color: #00a427; }

.no-project-message {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #a1a1aa;
    font-size: 16px;
    display: none;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
    .projects-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .sidebar { display: none; }
    .filter-row { grid-template-columns: 1fr; }
    .projects-grid { grid-template-columns: 1fr; }
}
</style>

    <div class="container">
        <main class="main-content">
            <div id="workzone" class="workzone-container">
                
                <div class="filter-row">
                    <div class="filter-box">
                        <h4>Rechercher un projet</h4>
                        <input type="text" id="search-name" class="filter-input" placeholder="Commence par...">
                    </div>
                    <div class="filter-box">
                        <h4>Date</h4>
                        <select id="filter-date" class="filter-select">
                            <option value="all">Toutes les dates (Par défaut)</option>
                            <option value="recent">Plus récent</option>
                            <option value="old">Plus ancien</option>
                        </select>
                    </div>
                    <div class="filter-box">
                        <h4>Statut</h4>
                        <select id="filter-status" class="filter-select">
                            <option value="all">Tous les statuts</option>
                            <option value="en_cours">En_cours (Jaune)</option>
                            <option value="en_pause">En_pause (Gris)</option>
                            <option value="annule">Annulé (Rouge)</option>
                            <option value="en_urgence">En_urgence (Orange)</option>
                            <option value="termine">Terminé (Vert)</option>
                        </select>
                    </div>
                </div>

<div class="projects-grid">
                    <div id="no-project" class="no-project-message">Aucun projet ne correspond à votre recherche.</div>

                    <?php if (!empty($projects)): ?>
                        <?php foreach ($projects as $project): 
                            // 1. Récupération avec le VRAI nom de ta colonne
                            $status = $project['project_status'] ?? 'en_cours';
                            
                            // Sécurité si la case est vide en base de données
                            if (empty($status)) {
                                $status = 'en_cours';
                            }
                            
                            // 2. Récupération des autres colonnes de ton fichier
                            $nomProjet = $project['project_name'] ?? 'Projet sans nom';
                            $dateProjet = $project['project_start'] ?? date('Y-m-d');

                            // 3. Association des couleurs et des icônes
                            if ($status === 'en_cours') {
                                $colorClass = 'yellow';
                                $iconSrc = 'Icone/reset.png';
                            } elseif ($status === 'en_pause') {
                                $colorClass = 'gray';
                                $iconSrc = 'Icone/pause.png';
                            } elseif ($status === 'annule') {
                                $colorClass = 'red';
                                $iconSrc = 'Icone/down.png';
                            } elseif ($status === 'en_urgence') {
                                $colorClass = 'orange';
                                $iconSrc = 'Icone/warning.png';
                            } elseif ($status === 'termine') {
                                $colorClass = 'green';
                                $iconSrc = 'Icone/verifier.png';
                            } else {
                                // Au cas où un statut inconnu soit écrit en BDD
                                $status = 'en_cours';
                                $colorClass = 'yellow';
                                $iconSrc = 'Icone/reset.png';
                            }
                        ?>
                            <div class="project-card" 
                                 data-name="<?php echo htmlspecialchars(strtolower($nomProjet), ENT_QUOTES, 'UTF-8'); ?>" 
                                 data-status="<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>" 
                                 data-date="<?php echo htmlspecialchars($dateProjet, ENT_QUOTES, 'UTF-8'); ?>">
                                
                                <h3><?php echo htmlspecialchars($nomProjet, ENT_QUOTES, 'UTF-8'); ?></h3>
                                <div class="status-bars">
                                    <div class="bar <?php echo $colorClass; ?>"></div>
                                    <div class="bar <?php echo $colorClass; ?>"></div>
                                    
                                    <div class="icon">
                                        <img src="<?php echo htmlspecialchars($iconSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="status">
                                    </div>
                                    
                                    <div class="bar <?php echo $colorClass; ?>"></div>
                                    <div class="bar <?php echo $colorClass; ?>"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-project-message" style="display: block;">Aucun projet ne vous est affecté pour le moment.</div>
                    <?php endif; ?>

                </div>
            </div>
        </main>
    </div>
    
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Navigation functionality
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('en_cours'));
            this.classList.add('en_cours');
        });
    });

    // Project card interactions
    document.querySelectorAll('.project-card').forEach(card => {
        card.addEventListener('mouseenter', function() { this.style.transform = 'translateY(-4px)'; });
        card.addEventListener('mouseleave', function() { this.style.transform = 'translateY(0)'; });
        card.addEventListener('click', function() {
            console.log('Projet sélectionné:', this.querySelector('h3').textContent);
        });
    });

    // --- LOGIQUE AUTOMATIQUE TEMPS RÉEL (ACCENTS STRICTS) ---
    const searchInput = document.getElementById('search-name');
    const selectStatus = document.getElementById('filter-status');
    const selectDate = document.getElementById('filter-date');
    const cards = document.querySelectorAll('.project-card');
    const noProjectMsg = document.getElementById('no-project');

    function strictClean(str) {
        return str.toLowerCase().trim();
    }

    function executerFiltresEtTri() {
        const searchText = strictClean(searchInput.value);
        const chosenStatus = selectStatus.value;
        let visibleCardsCount = 0;

        cards.forEach(card => {
            const cardName = strictClean(card.getAttribute('data-name'));
            const cardStatus = card.getAttribute('data-status');
            const words = cardName.split(' ');

            const matchName = cardName.startsWith(searchText) || words.some(word => word.startsWith(searchText));
            const matchStatus = (chosenStatus === 'all' || cardStatus === chosenStatus);

            if (matchName && matchStatus) {
                card.style.display = 'flex';
                visibleCardsCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noProjectMsg.style.display = visibleCardsCount === 0 ? 'block' : 'none';

        // --- CORRECTION DU TRI PAR DATE ---
        const chosenDateOrder = selectDate.value;
        if (chosenDateOrder !== 'all') {
            const grid = document.querySelector('.projects-grid');
            const cardsArray = Array.from(cards);

            cardsArray.sort((a, b) => {
                let rawA = a.getAttribute('data-date');
                let rawB = b.getAttribute('data-date');

                let dateA = rawA ? new Date(rawA) : new Date(0);
                let dateB = rawB ? new Date(rawB) : new Date(0);

                if (isNaN(dateA.getTime())) dateA = new Date(0);
                if (isNaN(dateB.getTime())) dateB = new Date(0);

                return chosenDateOrder === 'recent' ? dateB - dateA : dateA - dateB;
            });

            // Ré-injection obligatoire des éléments triés dans le DOM
            cardsArray.forEach(card => {
                grid.appendChild(card);
            });
        }
    }

    searchInput.addEventListener('input', executerFiltresEtTri);
    selectStatus.addEventListener('change', executerFiltresEtTri);
    selectDate.addEventListener('change', executerFiltresEtTri);

});
</script>

    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_bottom.html.php';
}
?>