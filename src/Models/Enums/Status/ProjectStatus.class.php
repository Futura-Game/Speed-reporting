<?php

namespace Src\Models\Enums\Status;

use Src\Models\Enums\BaseEnum;

class ProjectStatus extends BaseEnum
{
    // 1. Déclaration de TOUTES les constantes de statuts
    public const EN_COURS = 'en_cours';
    public const EN_PAUSE = 'en_pause';     // <-- AJOUTÉ
    public const EN_URGENCE = 'en_urgence'; // <-- AJOUTÉ
    public const TERMINE = 'termine';
    public const ANNULE = 'annule';

    // 2. Options pour générer automatiquement ton <select> HTML
    public static function getEnumOptions(): array
    {
        return [
            self::EN_COURS   => 'En cours',
            self::EN_PAUSE   => 'En pause',     // <-- AJOUTÉ
            self::EN_URGENCE => 'En urgence',   // <-- AJOUTÉ
            self::TERMINE    => 'Terminé',
            self::ANNULE     => 'Annulé',
        ];
    }

    // 3. Gestion des couleurs/classes CSS pour tes badges de tableaux
    public static function getColor(string $status): string
    {
        return match ($status) {
            self::EN_COURS   => 'progress', // En Jaune
            self::EN_PAUSE   => 'paused',  // En Gris
            self::EN_URGENCE => 'danger',   // En Orange
            self::TERMINE    => 'success',  // En Vert
            self::ANNULE     => 'offline',  // En Rouge
        };
    }
}