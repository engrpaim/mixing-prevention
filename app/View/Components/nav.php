<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class nav extends Component
{
    public $title;
    public $route;
    public $isLast;
    public $tooltip;
    public $svg;
    public $color;
    public function __construct(string $title, $route,$isLast,$tooltip,$svg,$color)
    {
        $this->title = $title;
        $this->route = $route;
        $this->isLast = $isLast;
        $this->tooltip = $tooltip;
        $this->svg =$svg;
        $this->color =$color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }
}
