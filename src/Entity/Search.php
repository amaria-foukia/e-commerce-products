<?php

namespace App\Entity;

class Search
{

    public int $page = 1;
    public string $q;
    public array $categories = [];
    public bool $promo = false;

}
