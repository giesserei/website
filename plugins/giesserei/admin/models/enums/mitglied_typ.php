<?php

/**
 * Definiert alle Typen eines Mitglieds.
 *
 * PHP unterstützt leider keine echten Enums, daher sind hier 'nur' Konstanten definiert.
 */
class MitgliedTypEnum
{

    /**
     * Bewohner der Giesserei -> Aktivmitglied.
     */
    const BEWOHNER = 1;

    /**
     * Gewerbe der Giesserei -> Aktivmitglied.
     */
    const GEWERBE = 2;

    /**
     * Passivmitglieder der Giesserei.
     */
    const PASSIVMITGLIED = 3;

    /**
     * Passivmitglieder der Giesserei, welche ihren Mitgliederbeitrag nicht bezahlt haben.
     */
    const PASSIVMITGLIED_DEAKTIVIERT = 4;

    /**
     * Unsere Siedlungsassistenz -> Passivmitglied
     */
    const SIEDLUNGSASSISTENZ = 5;

    /**
     * Der Hausverein als Mieter von Objekten / oder der Giessereistundenfonds.
     */
    const HAUSVEREIN = 6;

    /**
     * Giessereistundenfonds.
     */
    const STUNDENFONDS = 7;

}