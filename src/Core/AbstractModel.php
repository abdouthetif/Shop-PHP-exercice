<?php

abstract class AbstractModel
{
    // Propriétés
    protected $database;
    protected $flashBag;

    // Constructeur
    public function __construct()
    {
        $this->database = new Database();
        $this->flashBag = new Flashbag();
    }
}