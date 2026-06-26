<?php

function showMonPlanningPage() {
    
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

        td.caseSemaine, 
        td:not(:first-child) {
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

        tr.blackline td table td { background: #0d1527; }
        tr.greyline td table td { background: #1f293d; }

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
          color: #555; 
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

        /* 🚀 Grille de projets avec barre de défilement tout en bas */
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

        /* 💅 Personnalisation de la barre de défilement de la grille */
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
        .projects-grid::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.55);
        }

        /* Cartes projets */
        .proj-square {
            width: 175.5px;
            height: 120px;
            border-radius: 10px;
            display: flex;
            align-items: center;      
            justify-content: center;  
            text-align: center;
            position: relative;
            box-sizing: border-box;
            cursor: pointer;
            user-select: none;
            transition: transform 0.2s, border 0.2s;
            border: 3px solid transparent; 
            color: #fff;
            overflow: hidden;
            flex-shrink: 0; 
            padding: 15px;            
            font-size: 15px;
            font-weight: bold;
            line-height: 1.3;
        }

        .proj-square.selected,
        .proj-square:hover {
            border: 3px solid #00b0ff;
            transform: scale(1.02);
        }
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
                <tr class="blackline">
                    <td>Projet 1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="greyline">
                    <td>Projet 2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="blackline">
                    <td>Projet 3</td>
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
                        Dashboard 2.0
                    </div>

                    <div class="proj-square" style="background-color: #420000;" data-id="gestionsql">
                        Gestion SQL
                    </div>

                    <div class="proj-square" style="background-color: #007722;" data-id="greenvald">
                        GreenVald
                    </div>

                    <div class="proj-square" style="background-color: #999900;" data-id="parisgo">
                        ParisGo
                    </div>

                    <div class="proj-square" style="background-color: #330088;" data-id="educ">
                        Éduc+
                    </div>

                    <div class="proj-square" style="background-color: #b35900;" data-id="devweb">
                        Développement de site web
                    </div>

                </div>
            </div>

        </div>

    </div>

<script>
    // --- GESTION DU CALENDRIER / NAVIGATION TEMPORELLE ---
    let currentDate = new Date(2026, 0, 1); 

    const moisNoms = [
      "JANVIER", "FÉVRIER", "MARS", "AVRIL", "MAI", "JUIN",
      "JUILLET", "AOÛT", "SEPTEMBRE", "OCTOBRE", "NOVEMBRE", "DÉCEMBRE"
    ];

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
        if (weekNum > 52) weekNum = weekNum - 52;
        cell.textContent = `Semaine n°${weekNum}`;
      });
    }

    function getWeekNumber(d) {
      d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
      d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
      const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
      return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
    }

    // --- DONNÉES D'ORIGINE ---
    let projects = [
      { id: 'dashboard', name: 'Dashboard 2.0', consumed: 53, total: 60, created: '2026-01-10', finPrevue: '2026-06-26', finReelle: '2026-07-02', color: '#990000' },
      { id: 'gestionsql', name: 'Gestion SQL', consumed: 0, total: 80, created: '2027-01-10', finPrevue: '2027-06-26', finReelle: '2027-07-02', color: '#420000' },
      { id: 'greenvald', name: 'GreenVald',      consumed: 15, total: 50, created: '2026-02-15', finPrevue: '2026-07-15', finReelle: '2026-07-15', color: '#007722' },
      { id: 'parisgo',   name: 'ParisGo',        consumed: 0, total: 50, created: '2028-03-01', finPrevue: '2028-05-25', finReelle: '2028-05-25', color: '#999900' },
      { id: 'educ',      name: 'Éduc+',          consumed: 16, total: 16, created: '2026-01-05', finPrevue: '2026-06-30', finReelle: '2026-06-28', color: '#330088' },
      { id: 'devweb',    name: 'Développement de site web', consumed: 10, total: 40, created: '2026-04-10', finPrevue: '2026-09-10', finReelle: '2026-09-20', color: '#b35900' }
    ];

    let sortKey = 'nom';
    let sortAsc = true;
    let selectedProject = projects[0];

    let container = null;
    let searchInput = null;

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
        const parts = project.finPrevue.split('-');
        if (parts.length === 3) formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
      }
      
      document.getElementById('cntName').textContent = project.name;
      document.getElementById('cntPercent').textContent = percent + '%';
      document.getElementById('cntBar').style.width = percent + '%';
      document.getElementById('cntConsumed').textContent = `${project.consumed} J / ${project.total} J`;
      document.getElementById('cntRemaining').textContent = `${remaining} J`;
      document.getElementById('cntDate').textContent = formattedDate;
    }

    function initGridEvents() {
      if (!container) return;
      const cards = container.querySelectorAll('.proj-square');
      cards.forEach(square => {
        const id = square.getAttribute('data-id');
        
        if (selectedProject && selectedProject.id === id) {
          square.classList.add('selected');
        } else {
          square.classList.remove('selected');
        }

        square.onclick = () => {
          const p = projects.find(proj => proj.id === id);
          if (!p) return;

          selectedProject = p;
          updateCounter(p);
          
          container.querySelectorAll('.proj-square').forEach(el => el.classList.remove('selected'));
          square.classList.add('selected');
        };
      });
    }

    function applyLogic() {
      if (!container || !searchInput) {
        console.warn("⚠️ applyLogic() annulé : 'container' ou 'searchInput' manquant.");
        return;
      }

      console.log(`📊 Tri en cours... Clé : "${sortKey}" | Ordre Croissant : ${sortAsc}`);

      const searchTerm = searchInput.value.trim();
      let result = [...projects];

      if (searchTerm) {
        result = result.filter(p => {
          return p.name.toLowerCase().startsWith(searchTerm.toLowerCase());
        });
      }

      result.sort((a, b) => {
        if (sortKey === 'nom')       return a.name.localeCompare(b.name, undefined, { numeric: true, sensitivity: 'variant' });
        if (sortKey === 'creation')  return a.created.localeCompare(b.created);
        if (sortKey === 'finPrevue') return a.finPrevue.localeCompare(b.finPrevue);
        if (sortKey === 'finReelle') return a.finReelle.localeCompare(b.finReelle);
        if (sortKey === 'jours')     return a.total - b.total;
        if (sortKey === 'progression') {
          const progA = a.total > 0 ? (a.consumed / a.total) : 0;
          const progB = b.total > 0 ? (b.consumed / b.total) : 0;
          return progA - progB;
        }
        return 0;
      });

      if (!sortAsc) result.reverse();
      
      // --- 🔥 CORRECTION APPLIQUÉE ICI ---
      // 1. On cache d'abord toutes les cartes graphiquement
      const allSquares = container.querySelectorAll('.proj-square');
      allSquares.forEach(square => {
        square.style.display = 'none';
      });

      // 2. On parcourt le tableau "result" trié pour replacer les cartes dans le BON ORDRE
      result.forEach(project => {
        const square = container.querySelector(`.proj-square[data-id="${project.id}"]`);
        if (square) {
          square.style.display = 'flex'; // On l'affiche
          container.appendChild(square);        // On la ré-injecte (va se placer à la suite)
        }
      });
      // ------------------------------------

      const currentVisible = result.find(r => selectedProject && r.id === selectedProject.id);
      if (!currentVisible) {
         updateCounter(result[0] || null);
      } else {
         updateCounter(selectedProject);
      }

      initGridEvents();
    }

    function initialiserFiltresEtTris() {
      console.log("🚀 Lancement de l'initialisation du Planning...");

      container = document.getElementById('projectsContainer');
      searchInput = document.getElementById('searchInp');
      const sidebar = document.querySelector('.sidebar');
      const root = document.documentElement;

      console.log("🔍 Éléments trouvés :", { container, searchInput });

      if (searchInput) {
        searchInput.addEventListener('input', applyLogic);
      }

      document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          console.log(`👉 Clic bouton tri détecté : ${this.dataset.sort}`);
          document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
          this.classList.add('active');
          sortKey = this.dataset.sort;
          applyLogic();
        });
      });

      const orderAscBtn = document.getElementById('orderAsc');
      if (orderAscBtn) {
        orderAscBtn.addEventListener('click', function(e) {
          e.preventDefault();
          console.log("👉 Clic ordre croissant");
          sortAsc = true;
          this.className = "order-btn active";
          const desc = document.getElementById('orderDesc');
          if (desc) desc.className = "order-btn inactive";
          applyLogic();
        });
      }

      const orderDescBtn = document.getElementById('orderDesc');
      if (orderDescBtn) {
        orderDescBtn.addEventListener('click', function(e) {
          e.preventDefault();
          console.log("👉 Clic ordre décroissant");
          sortAsc = false;
          this.className = "order-btn active";
          const asc = document.getElementById('orderAsc');
          if (asc) asc.className = "order-btn inactive";
          applyLogic();
        });
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
        });
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

      updateCalendarDisplay();
      applyLogic(); 
    }

    if (document.readyState === "interactive" || document.readyState === "complete") {
      initialiserFiltresEtTris();
    } else {
      document.addEventListener("DOMContentLoaded", initialiserFiltresEtTris);
    }
</script>
    
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/partials/_bottom.html.php';
}
?>