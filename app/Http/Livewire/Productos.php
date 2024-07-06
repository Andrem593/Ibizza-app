<?php


namespace App\Models;

use Livewire\Wireable;

class Productos implements Wireable
{
    public $property;

    public function __construct($property = null)
    {
        $this->property = $property;
    }

    public function toLivewire()
    {
        return [
            'property' => $this->property,
        ];
    }

    public static function fromLivewire($value)
    {
        return new static($value['property']);
    }
}

