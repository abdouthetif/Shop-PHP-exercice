<?php

class Formatter
{
    /* Formate un prix à la française xx,xx € */
    static public function formatPrice(float $price): string 
    {
        // return number_format($price, 2, ',', ' ') . ' €';
        $formatter = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($price, 'EUR');
    }

    /* Change le format de la date */
    static public function formatDate($date)
    {
        $objDate = new DateTime($date);
        return $objDate->format('d/m/Y');
    }
}