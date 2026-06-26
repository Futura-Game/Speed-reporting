<?php
$projectsStatus_data = $data['projectStatus_data'] ?? [];

$labelMapping = [
    'en_cours'   => 'En cours',
    'en_pause'   => 'En pause',
    'en_urgence' => 'En urgence',
    'termine'    => 'Validé',
    'annule'     => 'Annulé'
];

$statusMap = [
    'En cours'   => 0,
    'En pause'   => 0,
    'En urgence' => 0,
    'Validé'     => 0,
    'Annulé'     => 0
];

foreach ($projectsStatus_data as $status) {
    $key = $status['project_status'] ?? '';
    if (isset($labelMapping[$key])) {
        $label = $labelMapping[$key];
        $statusMap[$label] = (int) $status['status_count'];
    }
}
?>

<div class="card" data-card="projectStatus">
    <div class="card-container">
        <h2>Statuts des projets</h2>
        <div>
            <canvas id="projectStatus"></canvas>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('projectStatus').getContext('2d');
                const projectStatusData = {
                    labels: ['En cours', 'En pause', 'En urgence', 'Validé', 'Annulé'],
                    datasets: [{
                        label: 'Nombre de projets',
                        data: [
                            <?= $statusMap['En cours'] ?>,
                            <?= $statusMap['En pause'] ?>,
                            <?= $statusMap['En urgence'] ?>,
                            <?= $statusMap['Validé'] ?>,
                            <?= $statusMap['Annulé'] ?>
                        ],
                        backgroundColor: [
                            'rgba(255, 187, 0, 0.2)',   // En cours (Jaune)
                            'rgba(73, 76, 80, 0.2)',    // En pause (Gris)
                            'rgba(255, 127, 80, 0.2)',  // En urgence (Orange)
                            'rgba(40, 167, 69, 0.2)',   // Validé (Vert)
                            'rgba(225, 5, 30, 0.2)'     // Annulé (Rouge)
                        ],
                        borderColor: [
                            'rgba(255, 187, 0, 0.4)',   // En cours
                            'rgba(73, 76, 80, 0.4)',    // En pause
                            'rgba(255, 127, 80, 0.4)',  // En urgence
                            'rgba(40, 167, 69, 0.4)',   // Validé
                            'rgba(225, 5, 30, 0.4)'     // Annulé
                        ], 
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'pie',
                    data: projectStatusData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Répartition des projets par statut'
                            }
                        }
                    }
                });
            });
        </script>
        <div class="buttons">
            <a href="/projets" class="button primary">Voir plus</a>
        </div>
    </div>
</div>