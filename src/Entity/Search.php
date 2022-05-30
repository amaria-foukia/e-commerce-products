<?php

namespace App\Entity;

class Search
{

    public string $q;
    public array $categories = [];
    public bool $promo = false;

}
