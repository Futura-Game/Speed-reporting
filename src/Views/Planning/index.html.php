<?php

function showPlanningPage() {
    
    \Src\Services\AssetService::addStyle(['_sidebar.css', '_breadcrumb.css', 'Modal.css', 'Table.css', 'Button.css', '_settings.css', '_help.css']);
    \Src\Services\AssetService::addScript(['_sidebar.js', '_breadcrumb.js', 'Table.js', '_settings.js', '_help.js']);

    $page_title = "Planning";

    // Chargement des barres de ton application (Top, Sidebar, Breadcrumb)
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_top.html.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_sidebar.html.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_breadcrumb.html.php';
    ?>
    
    <style>
        .planning-container {
            margin-left: var(--sidebar-width, 100px); /* Utilise la variable calculée, ou 100px par défaut */
            margin-top: 80px;    /* Espace sous ton breadcrumb/barre du haut */
            padding: 20px;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: block;
            clear: both;
            transition: margin-left 0.2s ease-in-out; 
        }

        /* Style du Bandeau d'avancement (Compteur) */
        .counter-banner {
            background: #0d1527;
            border-radius: 10px 10px 0px 0px;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .progress-block { 
          flex: 1; 
          min-width: 300px; 
        }
        .progress-label { 
          font-size: 14px; 
          color: #e2e8f0; 
          margin-bottom: 8px; 
        }
        .progress-label .proj-name-highlight { 
          color: #00b0ff; 
          font-weight: bold; 
        }
        .progress-bar-bg { 
          background: #cccccc; 
          height: 24px; 
          border-radius: 12px; 
          overflow: hidden; 
          width: 100%; 
          max-width: 500px; 
        }
        .progress-bar-fill { 
          background: #00b0ff; 
          height: 100%; 
          width: 0%; 
          border-radius: 12px; 
          transition: width 0.4s ease; 
        }
        .stats-block { 
          display: flex; 
          gap: 40px; 
          flex-wrap: wrap; 
        }
        .stat-item { 
          display: flex; 
          flex-direction: column; 
          align-items: flex-start; 
        }
        .stat-label { 
          font-size: 13px; 
          color: #fff; 
          margin-bottom: 4px; 
        }
        .stat-value { 
          font-size: 15px; 
          color: #00b0ff; 
          font-weight: bold; 
        }

        /* La table globale */
        .table {
          background: #0d1527; 
          border-radius: 0px; 
          margin-bottom: 0px; 
        }

        table {
          width: 100%;
          border-spacing: 0px; 
          table-layout: fixed; 
        }

        button.date {
          width: 34px;
          height: 30px;
        }

        td {
          height: 40px;
          text-align: center;
          border: solid 1px white;
          color: white;
          padding: 0;          
        }

        td:first-child {
          width: 180px; 
        }

        td.caseSemaine, td:not(:first-child) {
          width: 25%;
        }

        td table {
          width: 100%;
          height: 100%;
          border-spacing: 0px; 
          table-layout: fixed; 
        }

        td table td {
          width: 20% !important;  
          height: 100%;
          box-sizing: border-box;
          overflow: hidden;       
        }

        td.nulcase {
          background: #141b2d; 
          font-size: 25px;
        }

        td.case1 {
          background: #1100a8;
        }

        td.case2 {
          background: #080c45;
        }

        td.caseSemaine {
          background: #2c48ff;
          border: solid 1px white;
          font-weight: bold;
        }

        tr.blackline td {
          background: #0d1527;
        }

        tr.greyline td {
          background: #1f293d;
        }

        /* 📦 Espace de travail bleu */
        .project-workspace {
            background: #0542b5;
            padding: 20px;
            border-radius: 0px 0px 10px 10px;
            box-sizing: border-box;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* 🔍 Style de la Barre de filtres */
        .filterbar-project {
            background: transparent; 
            padding: 0;
            display: flex;
            align-items: center; 
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 5px;
            width: 100%; 
            box-sizing: border-box;
        }

        .search-capsule { 
          display: inline-flex; 
          align-items: center; 
          background: #000; 
          border-radius: 24px; 
          height: 38px; 
        }

        .search-input-part { 
          background: #cbcbcb; 
          border-radius: 24px; 
          display: flex; 
          align-items: center; 
          padding: 0 16px; height: 100%; 
          width: 280px; 
        }

        .search-input-part span { 
          font-size: 16px; 
          user-select: none; 
        }

        .search-input-part input { 
          background: none; 
          border: none; 
          outline: none; 
          color: #000; 
          font-size: 14px; 
          font-weight: 500; 
          width: 100%; 
        }

        .search-input-part input::placeholder { 
          color: #666; 
        }
        
        .separator { 
          font-size: 18px; 
          user-select: none; 
          color: #fff;
        }

        .sort-group { 
          display: flex; 
          align-items: center; 
          gap: 16px; 
          flex-wrap: wrap; 
        }

        .pill-black-label { 
          background: #000; 
          color: #fff; 
          border-radius: 20px; 
          padding: 12px 20px; 
          font-size: 12px; 
          user-select: none; 
        }
        
        .sort-btn { 
          background: #000; 
          color: #fff; 
          border: none; 
          border-radius: 20px; 
          padding: 12px 20px; 
          font-size: 12px; 
          cursor: pointer; 
          transition: background 0.2s; 
        }

        .sort-btn.active { 
          background: #002699; 
          font-weight: bold; 
        }
        
        .order-stack { 
          display: flex; 
          flex-direction: column;
        }

        .order-btn { 
          border: none; 
          color: #fff; 
          font-size: 10px; 
          padding: 3px 12px; 
          cursor: pointer; 
          text-align: center; 
          border-radius: 12px; 
          min-width: 110px; 
        }

        .order-btn.active { 
          background: #002699; 
        }

        .order-btn.inactive { 
          background: #000; 
        }

        /* Conteneur de la ligne des cartes */
        .cards-row-container {
            display: flex;
            align-items: flex-start;
            width: 100%;
            gap: 16px;
        }

        /* 🚀 Grille de projets */
        .projects-grid {
            display: flex;
            flex-wrap: nowrap;     
            gap: 16px;
            flex: 1;
            overflow-x: auto;       
            overflow-y: hidden;     
            padding-bottom: 15px;   
            box-sizing: border-box;
        }

        .projects-grid::-webkit-scrollbar {
            height: 8px; 
        }
        .projects-grid::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }
        .projects-grid::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.35);
            border-radius: 4px;
        }

        /* Cartes projets */
        .proj-square {
            width: 175px;
            height: 120px;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            position: relative;
            box-sizing: border-box;
            cursor: pointer;
            user-select: none;
            transition: transform 0.2s, box-shadow 0.2s; 
            color: #fff;
            overflow: hidden;
            flex-shrink: 0; 
        }

        .proj-square.selected, .proj-square:hover {
            box-shadow: inset 0 0 0 5px #000000;
        }

        /* En-tête des cartes */
        .proj-card-header {
            background-color: #000000a3;
            display: flex;
            justify-content: flex-end; 
            align-items: center;       
            gap: 6px;                  
            width: 100%;
            box-sizing: border-box;
            height: 25px;
            padding-right: 8px; 
        }

        /* Icônes d'action supérieure */
        .proj-action-icon {
            cursor: pointer;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;  
            height: 18px; 
        }

        .proj-action-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain; 
            pointer-events: none; 
        }

        .proj-action-icon input[type="color"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2; 
        }

        /* Corps de la carte */
        .proj-card-body {
            flex: 1;
            display: flex;
            align-items: center;      
            justify-content: center;  
            text-align: center;
            padding: 0 10px 12px 10px;
            font-size: 15px;
            font-weight: bold;
            line-height: 1.2;
            outline: none; 
        }
        
        .proj-card-body[contenteditable="true"] {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
            cursor: text;
        }

        /* La carte "+" reste FIXE */
        .add-card {
            background: #000 !important;
            color: #00b3ff;
            font-size: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 175.5px;
            height: 120px;
            border-radius: 5px;
            cursor: pointer;
            flex-shrink: 0; 
        }

        /* 🆕 La ligne de l'employé devient le repère de position absolue */
        .timeline-lane {
            position: relative;
            height: 45px;
            padding: 0 !important;
            text-align: left !important;
            background: rgba(255,255,255,0.02);
        }

        /* 🆕 Le badge du projet déposé dans le calendrier */
        .allocated-project-badge {
            position: absolute;
            top: 4px;
            height: 36px;
            border-radius: 4px;
            color: white;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            padding: 0 8px;
            box-sizing: border-box;
            user-select: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            z-index: 5;
        }

        /* 🆕 Les poignées latérales pour le redimensionnement */
        .resize-handle {
            position: absolute;
            top: 0;
            width: 8px;
            height: 100%;
            cursor: ew-resize;
            background: rgba(0, 0, 0, 0.15);
            transition: background 0.2s;
            z-index: 10;
        }
        .resize-handle:hover {
            background: rgba(255, 255, 255, 0.6);
        }
        .resize-left { left: 0; border-top-left-radius: 4px; border-bottom-left-radius: 4px; }
        .resize-right { right: 0; border-top-right-radius: 4px; border-bottom-right-radius: 4px; }
    </style>

    <div class="planning-container">

        <div class="counter-banner" id="counterBanner">
            <div class="progress-block">
                <div class="progress-label">
                    État d’avancement du projet <span id="cntName" class="proj-name-highlight">-</span> : <span id="cntPercent">0%</span>
                </div>
                <div class="progress-bar-bg">
                    <div id="cntBar" class="progress-bar-fill"></div>
                </div>
            </div>
            <div class="stats-block">
                <div class="stat-item">
                    <span class="stat-label">Jours consommés :</span>
                    <span id="cntConsumed" class="stat-value">-</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Jours restants :</span>
                    <span id="cntRemaining" class="stat-value">-</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Délais final estimé :</span>
                    <span id="cntDate" class="stat-value">-</span>
                </div>
            </div>
        </div>
        
        <div class="table">
            <table>
                <tr>
                    <td id="currentMonthYear">JANVIER - 2026</td>
                    <td class="caseSemaine">Semaine n°1</td>
                    <td class="caseSemaine">Semaine n°2</td>
                    <td class="caseSemaine">Semaine n°3</td>
                    <td class="caseSemaine">Semaine n°4</td>
                    <td class="caseSemaine">Semaine n°5</td>
                    <td class="caseSemaine">Semaine n°6</td>
                </tr>
                <tr>
                    <td><button class="date">Y-1</button> | <button class="date">M-1</button> | <button class="date">M+1</button> | <button class="date">Y+1</button></td>
                    <td><table><tr><td class="case1">L</td><td class="case2">M</td><td class="case1">M</td><td class="case2">J</td><td class="case1">V</td></tr></table></td>
                    <td><table><tr><td class="case2">L</td><td class="case1">M</td><td class="case2">M</td><td class="case1">J</td><td class="case2">V</td></tr></table></td>
                    <td><table><tr><td class="case1">L</td><td class="case2">M</td><td class="case1">M</td><td class="case2">J</td><td class="case1">V</td></tr></table></td>
                    <td><table><tr><td class="case2">L</td><td class="case1">M</td><td class="case2">M</td><td class="case1">J</td><td class="case2">V</td></tr></table></td>
                    <td><table><tr><td class="case1">L</td><td class="case2">M</td><td class="case1">M</td><td class="case2">J</td><td class="case1">V</td></tr></table></td>
                    <td><table><tr><td class="case2">L</td><td class="case1">M</td><td class="case2">M</td><td class="case1">J</td><td class="case2">V</td></tr></table></td>
                </tr>
                <tr class="blackline employee-row" data-employee="Thomas">
                    <td>Thomas</td>
                    <td colspan="6" class="drop-target timeline-lane"></td>
                </tr>
                <tr class="greyline employee-row" data-employee="Donovan">
                    <td>Donovan</td>
                    <td colspan="6" class="drop-target timeline-lane"></td>
                </tr>
                <tr class="blackline employee-row" data-employee="Matteo">
                    <td>Matteo</td>
                    <td colspan="6" class="drop-target timeline-lane"></td>
                </tr>
                <tr class="greyline">
                    <td>+</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>                
             </table>
        </div>
        
        <div class="project-workspace">
            
            <div class="filterbar-project">
                <div class="search-capsule">
                    <div class="search-input-part">
                        <span>🔍</span>
                        <input type="text" id="searchInp" placeholder="Rechercher...">
                    </div>
                </div>

                <span class="separator">|</span>

                <div class="sort-group">
                    <div class="pill-black-label">Trier par :</div>
                    <button class="sort-btn active" data-sort="nom">Nom</button>
                    <button class="sort-btn" data-sort="creation">Date de création</button>
                    <button class="sort-btn" data-sort="finPrevue">Date de fin prévue</button>
                    <button class="sort-btn" data-sort="finReelle">Date de fin réelle</button>
                    <button class="sort-btn" data-sort="jours">Nombre de jours prévu</button>
                    <button class="sort-btn" data-sort="progression">Progression</button>
                    <div class="order-stack">
                        <button id="orderAsc" class="order-btn active">Ordre croissant</button>
                        <button id="orderDesc" class="order-btn inactive">Ordre décroissant</button>
                    </div>
                </div>
            </div>

            <div class="cards-row-container">
                <div class="projects-grid" id="projectsContainer">
                    
                    <div class="proj-square" style="background-color: #990000;" data-id="dashboard">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#990000">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">Dashboard 2.0</div>
                    </div>

                    <div class="proj-square" style="background-color: #420000;" data-id="dashboard2">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#420000">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">Dashboard 3.0</div>
                    </div>

                    <div class="proj-square" style="background-color: #007722;" data-id="greenvald">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#007722">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">GreenVald</div>
                    </div>

                    <div class="proj-square" style="background-color: #999900;" data-id="parisgo">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#999900">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">ParisGo</div>
                    </div>

                    <div class="proj-square" style="background-color: #330088;" data-id="educ">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#330088">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">Éduc+</div>
                    </div>

                    <div class="proj-square" style="background-color: #b35900;" data-id="devweb">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#b35900">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">Développement de site web</div>
                    </div>

                    <div class="proj-square" style="background-color: #00b3ff;" data-id="mobile">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#00b3ff">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">Application mobile de gestion</div>
                    </div>

                    <div class="proj-square" style="background-color: #880055;" data-id="ecommerce">
                        <div class="proj-card-header">
                            <span class="proj-action-icon">
                              <img src="../../../../Icone/chromaète.png" alt="Modifier">
                              <input type="color" value="#880055">
                            </span>
                            <span class="proj-action-icon btn-edit-name">
                                <img src="../../../../Icone/Modif.png" alt="Modifier">
                            </span>
                            <span class="proj-action-icon btn-delete-card">
                                <img src="../../../../Icone/Trash.png" alt="Supprimer">
                            </span>
                        </div>
                        <div class="proj-card-body">Refonte de la plateforme e-commerce</div>
                    </div>

                </div>

                <div class="proj-square add-card">+</div>
            </div>

        </div>

    </div>

<script>
    // --- DATA & CONFIGURATION GENERALE ---
    let projects = [
      { id: 'dashboard', name: 'Dashboard 2.0', consumed: 40, total: 60, created: '2026-01-10', finPrevue: '2026-06-26', finReelle: '2026-07-02', color: '#990000' },
      { id: 'dashboard2', name: 'Dashboard 3.0', consumed: 40, total: 60, created: '2027-01-10', finPrevue: '2027-06-26', finReelle: '2027-07-02', color: '#420000' },
      { id: 'greenvald', name: 'GreenVald',      consumed: 15, total: 50, created: '2026-02-15', finPrevue: '2026-07-15', finReelle: '2026-07-15', color: '#007722' },
      { id: 'parisgo',   name: 'ParisGo',        consumed: 0, total: 50, created: '2028-03-01', finPrevue: '2028-05-25', finReelle: '2028-05-25', color: '#999900' },
      { id: 'educ',      name: 'Éduc+',          consumed: 16, total: 16, created: '2026-01-05', finPrevue: '2026-06-30', finReelle: '2026-06-28', color: '#330088' },
      { id: 'devweb',    name: 'Développement de site web', consumed: 10, total: 40, created: '2026-04-10', finPrevue: '2026-09-10', finReelle: '2026-09-20', color: '#b35900' },
      { id: 'mobile',    name: 'Application mobile de gestion', consumed: 5, total: 30, created: '2026-05-01', finPrevue: '2026-10-15', finReelle: '2026-10-10', color: '#00b3ff' },
      { id: 'ecommerce', name: 'Refonte de la plateforme e-commerce', consumed: 60, total: 120, created: '2026-02-20', finPrevue: '2026-11-30', finReelle: '2026-12-15', color: '#880055' }
    ];

    // Array global pour mémoriser les projets affectés sur la ligne du temps
    let allocations = [];

    let sortKey = 'nom';
    let sortAsc = true;
    let selectedProject = projects[0];
    let currentDate = new Date(2026, 0, 1); // Janvier 2026

    const moisNoms = [
      "JANVIER", "FÉVRIER", "MARS", "AVRIL", "MAI", "JUIN",
      "JUILLET", "AOÛT", "SEPTEMBRE", "OCTOBRE", "NOVEMBRE", "DÉCEMBRE"
    ];

    const container = document.getElementById('projectsContainer');
    const searchInput = document.getElementById('searchInp');
    const sidebar = document.querySelector('.sidebar');
    const root = document.documentElement;

    // --- UTILS FONCTIONS TEMPORELLES ---
    function addDays(date, days) {
      const result = new Date(date);
      result.setDate(result.getDate() + days);
      return result;
    }

    // Récupérer le lundi de la première semaine affichée à l'écran
    function getFirstDisplayedDate() {
      const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
      const dayOfWeek = firstDayOfMonth.getDay(); 
      const diffToMonday = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
      return addDays(firstDayOfMonth, diffToMonday);
    }

    function updateCalendarDisplay() {
      const elLabel = document.getElementById('currentMonthYear');
      if (!elLabel) return;

      const currentMonth = currentDate.getMonth();
      const currentYear = currentDate.getFullYear();

      elLabel.textContent = `${moisNoms[currentMonth]} - ${currentYear}`;

      const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
      let startWeek = getWeekNumber(firstDayOfMonth);

      const weekCells = document.querySelectorAll('.caseSemaine');
      weekCells.forEach((cell, index) => {
        let weekNum = startWeek + index;
        if (weekNum > 52) {
          weekNum = weekNum - 52;
        }
        cell.textContent = `Semaine n°${weekNum}`;
      });
    }

    function getWeekNumber(d) {
      d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
      d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
      const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
      return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
    }

    // --- LOGIQUE DRAG AND DROP & RESIZE INTÉLLIGENT ---
    function initDragEventsOnCards() {
      const cards = document.querySelectorAll('.proj-square:not(.add-card)');
      cards.forEach(card => {
        card.setAttribute('draggable', 'true');

        card.ondragstart = (e) => {
          const projectId = card.getAttribute('data-id');
          const projectColor = card.style.backgroundColor;
          
          e.dataTransfer.setData('text/plain', projectId);
          e.dataTransfer.setData('project-color', projectColor);
          card.style.opacity = '0.6';
        };

        card.ondragend = () => {
          card.style.opacity = '1';
        };
      });
    }

    function initDropZones() {
      const dropTargets = document.querySelectorAll('.timeline-lane');

      dropTargets.forEach(target => {
        target.ondragover = (e) => {
          e.preventDefault();
        };

        target.ondrop = (e) => {
          e.preventDefault();
          
          const projectId = e.dataTransfer.getData('text/plain');
          const project = projects.find(p => p.id === projectId);
          const employeeRow = target.closest('.employee-row');
          
          if (!project || !employeeRow) return;
          const employee = employeeRow.dataset.employee;

          const rect = target.getBoundingClientRect();
          const clickX = e.clientX - rect.left; 
          const totalWidth = rect.width;
          
          const totalDaysDisplayed = 30; 
          const dayWidth = totalWidth / totalDaysDisplayed;
          
          let dayIndex = Math.floor(clickX / dayWidth);
          if (dayIndex < 0) dayIndex = 0;
          if (dayIndex >= totalDaysDisplayed) dayIndex = totalDaysDisplayed - 1;

          const startWeekIndex = Math.floor(dayIndex / 5);
          const dayInWeek = dayIndex % 5;
          const totalDaysToShift = (startWeekIndex * 7) + dayInWeek;

          const firstGridDate = getFirstDisplayedDate();
          const realStartDate = addDays(firstGridDate, totalDaysToShift);
          const realEndDate = addDays(realStartDate, 1); 

          allocations.push({
            id: 'alloc_' + Date.now(),
            projectId: project.id,
            employee: employee,
            startDate: realStartDate,
            endDate: realEndDate
          });

          renderAllocations();
        };
      });
    }

    function renderAllocations() {
      document.querySelectorAll('.timeline-lane').forEach(lane => lane.innerHTML = '');

      const firstDisplayedDate = getFirstDisplayedDate();
      const totalDaysDisplayed = 30;

      allocations.forEach(alloc => {
        const project = projects.find(p => p.id === alloc.projectId);
        const lane = document.querySelector(`.employee-row[data-employee="${alloc.employee}"] .timeline-lane`);
        
        if (!project || !lane) return;

        let startDayIndex = -1;
        let endDayIndex = -1;

        for (let i = 0; i < totalDaysDisplayed; i++) {
          const weekIndex = Math.floor(i / 5);
          const dayInWeek = i % 5;
          const currentGridDate = addDays(firstDisplayedDate, (weekIndex * 7) + dayInWeek);
          currentGridDate.setHours(0,0,0,0);

          const allocStart = new Date(alloc.startDate); allocStart.setHours(0,0,0,0);
          const allocEnd = new Date(alloc.endDate); allocEnd.setHours(0,0,0,0);

          if (currentGridDate >= allocStart && currentGridDate < allocEnd) {
            if (startDayIndex === -1) startDayIndex = i;
            endDayIndex = i + 1;
          }
        }

        if (startDayIndex !== -1 && endDayIndex !== -1) {
          const duration = endDayIndex - startDayIndex;

          const badge = document.createElement('div');
          badge.className = 'allocated-project-badge';
          badge.style.backgroundColor = project.color;
          badge.textContent = project.name;
          
          badge.style.left = ((startDayIndex / totalDaysDisplayed) * 100) + '%';
          badge.style.width = ((duration / totalDaysDisplayed) * 100) + '%';

          const leftHandle = document.createElement('div');
          leftHandle.className = 'resize-handle resize-left';
          const rightHandle = document.createElement('div');
          rightHandle.className = 'resize-handle resize-right';
          
          badge.appendChild(leftHandle);
          badge.appendChild(rightHandle);
          lane.appendChild(badge);

          let isResizing = false;
          let currentHandle = null;
          let initialX = 0;
          let initialStartDay = startDayIndex;
          let initialDuration = duration;

          const startResize = (e, handleType) => {
            e.stopPropagation();
            e.preventDefault();
            isResizing = true;
            currentHandle = handleType;
            initialX = e.clientX;
            initialStartDay = startDayIndex;
            initialDuration = duration;
            
            document.addEventListener('mousemove', handleResize);
            document.addEventListener('mouseup', stopResize);
          };

          leftHandle.addEventListener('mousedown', (e) => startResize(e, 'left'));
          rightHandle.addEventListener('mousedown', (e) => startResize(e, 'right'));

          function handleResize(e) {
            if (!isResizing) return;
            const deltaX = e.clientX - initialX;
            const laneWidth = lane.getBoundingClientRect().width;
            const dayWidth = laneWidth / totalDaysDisplayed;
            const deltaDays = Math.round(deltaX / dayWidth);

            let newStart = initialStartDay;
            let newDuration = initialDuration;

            if (currentHandle === 'right') {
              newDuration = Math.max(1, initialDuration + deltaDays);
              if (newStart + newDuration > totalDaysDisplayed) newDuration = totalDaysDisplayed - newStart;
            } else {
              newStart = initialStartDay + deltaDays;
              newDuration = initialDuration - deltaDays;
              if (newDuration < 1) {
                newStart = initialStartDay + initialDuration - 1;
                newDuration = 1;
              }
            }

            badge.style.left = ((newStart / totalDaysDisplayed) * 100) + '%';
            badge.style.width = ((newDuration / totalDaysDisplayed) * 100) + '%';
            
            const sWeek = Math.floor(newStart / 5); const sDay = newStart % 5;
            alloc.startDate = addDays(firstDisplayedDate, (sWeek * 7) + sDay);

            const eWeek = Math.floor((newStart + newDuration) / 5); const eDay = (newStart + newDuration) % 5;
            alloc.endDate = addDays(firstDisplayedDate, (eWeek * 7) + eDay);
          }

          function stopResize() {
            isResizing = false;
            document.removeEventListener('mousemove', handleResize);
            document.removeEventListener('mouseup', stopResize);
            renderAllocations(); 
          }
        }
      });
    }

    // --- MISE A JOUR DU COMPTEUR SUPÉRIEUR ---
    function updateCounter(project) {
      if (!project) {
        document.getElementById('cntName').textContent = "-";
        document.getElementById('cntPercent').textContent = '0%';
        document.getElementById('cntBar').style.width = '0%';
        document.getElementById('cntConsumed').textContent = "-";
        document.getElementById('cntRemaining').textContent = "-";
        document.getElementById('cntDate').textContent = "-";
        return;
      }
      const percent = project.total > 0 ? Math.round((project.consumed / project.total) * 100) : 0;
      const remaining = project.total - project.consumed;
      
      let formattedDate = "-";
      if (project.finPrevue) {
        const [year, month, day] = project.finPrevue.split('-');
        if (day && month && year) formattedDate = `${day}/${month}/${year}`;
      }
      
      document.getElementById('cntName').textContent = project.name;
      document.getElementById('cntPercent').textContent = percent + '%';
      document.getElementById('cntBar').style.width = percent + '%';
      document.getElementById('cntConsumed').textContent = `${project.consumed} J / ${project.total} J`;
      document.getElementById('cntRemaining').textContent = `${remaining} J`;
      document.getElementById('cntDate').textContent = formattedDate;
    }

    // --- INTERACTIONS SUR LA GRILLE DE PROJETS ---
    function initGridEvents() {
      const cards = container.querySelectorAll('.proj-square');
      cards.forEach(square => {
        const id = square.getAttribute('data-id');
        if (!id) return;

        const p = projects.find(proj => proj.id === id);
        if (!p) return;
        
        const cardBody = square.querySelector('.proj-card-body');

        if (selectedProject && selectedProject.id === id) {
          square.classList.add('selected');
        } else {
          square.classList.remove('selected');
        }

        square.onclick = (e) => {
          if (e.target.tagName === 'INPUT' || e.target.classList.contains('proj-action-icon') || cardBody.getAttribute('contenteditable') === 'true') return;

          selectedProject = p;
          updateCounter(p);
          container.querySelectorAll('.proj-square').forEach(el => el.classList.remove('selected'));
          square.classList.add('selected');
        };

        const colorInput = square.querySelector('input[type="color"]');
        if (colorInput) {
          colorInput.oninput = (e) => {
            const nouvelleCouleur = e.target.value;
            square.style.backgroundColor = nouvelleCouleur; 
            p.color = nouvelleCouleur;    
            renderAllocations(); 
          };
        }

        const editBtn = square.querySelector('.btn-edit-name');
        if (editBtn) {
          editBtn.onclick = (e) => {
            e.stopPropagation(); 
            cardBody.setAttribute('contenteditable', 'true');
            cardBody.focus();
            
            const range = document.createRange();
            range.selectNodeContents(cardBody);
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
          };
        }

        cardBody.onblur = () => {
          cardBody.setAttribute('contenteditable', 'false');
          const nouveauNom = cardBody.textContent.trim();
          if (nouveauNom !== "") {
            p.name = nouveauNom; 
            if (selectedProject && selectedProject.id === p.id) {
              updateCounter(p);
            }
            renderAllocations(); 
          }
        };

        cardBody.onkeydown = (e) => {
          if (e.key === 'Enter') {
            e.preventDefault();
            cardBody.blur();
          }
        };

        const deleteBtn = square.querySelector('.btn-delete-card');
        if (deleteBtn) {
          deleteBtn.onclick = (e) => {
            e.stopPropagation(); 
            const confirmation = confirm(`Voulez-vous vraiment supprimer le projet "${p.name}" ?`);
            if (confirmation) {
              projects = projects.filter(proj => proj.id !== id);
              square.remove();
              
              if (selectedProject && selectedProject.id === id) {
                selectedProject = projects.length > 0 ? projects[0] : null;
                updateCounter(selectedProject);
              }
              applyLogic();
            }
          };
        }
      });
    }

    function genererHtmlCarte(project) {
      const square = document.createElement('div');
      square.className = 'proj-square';
      square.setAttribute('data-id', project.id);
      square.style.backgroundColor = project.color;

      square.innerHTML = `
        <div class="proj-card-header">
            <span class="proj-action-icon">
                <img src="../../../../Icone/chromaète.png" alt="Couleur">
                <input type="color" value="${project.color}">
            </span>
            <span class="proj-action-icon btn-edit-name">
                <img src="../../../../Icone/Modif.png" alt="Modifier">
            </span>
            <span class="proj-action-icon btn-delete-card">
                <img src="../../../../Icone/Trash.png" alt="Supprimer">
            </span>
        </div>
        <div class="proj-card-body">${project.name}</div>
      `;
      return square;
    }

    // --- FILTRAGE ET RECONSTRUCTION DES CARTES ---
    function applyLogic() {
      const searchTerm = searchInput.value.toLowerCase().trim();
      
      // Nettoyage des accents (ex: Éduc -> educ)
      const normalizedSearch = searchTerm.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

      let result = [...projects];

      if (normalizedSearch) {
        result = result.filter(p => {
          const normalizedProjectName = p.name.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
          return normalizedProjectName.startsWith(normalizedSearch);
        });
      }

      result.sort((a, b) => {
        // 🔢 MODIFICATION ICI : Tri naturel pour gérer "6" avant "56" et ignorer la casse/les accents
        if (sortKey === 'nom')       return a.name.localeCompare(b.name, undefined, { numeric: true, sensitivity: 'base' });
        if (sortKey === 'creation')  return a.created.localeCompare(b.created);
        if (sortKey === 'finPrevue') return a.finPrevue.localeCompare(b.finPrevue);
        if (sortKey === 'finReelle') return a.finReelle.localeCompare(b.finReelle);
        if (sortKey === 'jours')     return a.total - b.total;
        if (sortKey === 'progression') {
          const pctA = a.total > 0 ? (a.consumed / a.total) : 0;
          const pctB = b.total > 0 ? (b.consumed / b.total) : 0;
          return pctA - pctB;
        }
        return 0;
      });

      if (!sortAsc) result.reverse();
      
      result.forEach(p => {
        let square = container.querySelector(`.proj-square[data-id="${p.id}"]`);
        if (!square) {
          square = genererHtmlCarte(p);
        }
        square.style.display = 'flex';
        container.appendChild(square);
      });
      
      const allSquares = container.querySelectorAll('.proj-square');
      allSquares.forEach(square => {
        const id = square.getAttribute('data-id');
        if (id) {
          const correspond = result.find(r => r.id === id);
          if (!correspond) {
            square.style.display = 'none';
          }
        }
      });

      initGridEvents();
      initDragEventsOnCards(); 
    }

    // --- INITIALISATION AU CHARGEMENT ---
    document.addEventListener("DOMContentLoaded", () => {
      initDropZones();
      updateCalendarDisplay();

      if (searchInput) {
        searchInput.addEventListener('input', applyLogic);
      }

      const buttons = document.querySelectorAll('button.date');
      buttons.forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          const action = btn.textContent.trim();

          if (action === 'M-1') currentDate.setMonth(currentDate.getMonth() - 1);
          else if (action === 'M+1') currentDate.setMonth(currentDate.getMonth() + 1);
          else if (action === 'Y-1') currentDate.setFullYear(currentDate.getFullYear() - 1);
          else if (action === 'Y+1') currentDate.setFullYear(currentDate.getFullYear() + 1);

          updateCalendarDisplay();
          renderAllocations(); 
        });
      });

      const btnAddCard = document.querySelector('.add-card');
      if (btnAddCard) {
          btnAddCard.onclick = (e) => {
              e.preventDefault();
              e.stopPropagation();

              const randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
              const uniqueId = 'proj_' + Date.now();
              
              const nouveauProjet = {
                id: uniqueId,
                name: 'Nouveau Projet',
                consumed: 0,
                total: 10,
                created: new Date().toISOString().split('T')[0],
                finPrevue: new Date(Date.now() + 30*24*60*60*1000).toISOString().split('T')[0],
                finReelle: '',
                color: randomColor
              };

              projects.push(nouveauProjet);
              selectedProject = nouveauProjet;
              updateCounter(nouveauProjet);
              applyLogic();
          };
      }

      document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
          this.classList.add('active');
          sortKey = this.dataset.sort;
          applyLogic();
        });
      });

      document.getElementById('orderAsc').addEventListener('click', function() {
        sortAsc = true;
        this.className = "order-btn active";
        document.getElementById('orderDesc').className = "order-btn inactive";
        applyLogic();
      });

      document.getElementById('orderDesc').addEventListener('click', function() {
        sortAsc = false;
        this.className = "order-btn active";
        document.getElementById('orderAsc').className = "order-btn inactive";
        applyLogic();
      });

      if (sidebar) {
        const resizeObserver = new ResizeObserver(entries => {
          for (let entry of entries) {
            const width = entry.borderBoxSize ? entry.borderBoxSize[0].inlineSize : entry.target.offsetWidth;
            root.style.setProperty('--sidebar-width', width + 'px');
          }
        });
        resizeObserver.observe(sidebar);
      }

      updateCounter(selectedProject);
      applyLogic();
    });
</script>
    
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_bottom.html.php';
}
?>