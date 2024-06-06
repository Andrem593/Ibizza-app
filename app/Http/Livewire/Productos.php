<?php

namespace App\Http\Livewire;

class Productos implements Livewire\Wireable
{
    public $items = [];
 
    public function __construct($items)
    {
        $this->items = $items;
    }


}