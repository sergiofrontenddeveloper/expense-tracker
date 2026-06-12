<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddButton extends Component
{
    public string $entity;

    public function __construct(string $entity)
    {
        $this->entity = $entity;
    }

    public function render(): View|Closure|string
    {
        return view('components.add-button');
    }
}
