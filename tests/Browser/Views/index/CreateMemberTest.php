<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateMemberTest extends DuskTestCase
{
    /**
     * Un visiteur arrive sur la page /
     * - Il saisie son email
     * - Il soumet le formulaire
     * - Un message l'informe qu'il va de recevoir un email "index.success"
     *
     * 2 Points
     */

    /**
     * Un visiteur arrive sur la page /
     * - Il saisie son email (déjà existant en base de donnée)
     * - Il soumet le formulaire
     * - Un message l'informe qu'il va de recevoir un email "index.success"
     *
     * 2 Points
     */

    /**
     * Un visiteur arrive sur la page /
     * - Il ne saisi pas d'email
     * - Il soumet le formulaire
     * - Un message l'informe qu'il doit saisir son email
     *
     * 2 Points
     */
}
