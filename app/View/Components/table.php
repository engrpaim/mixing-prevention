<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class table extends Component
{
    public $title;
    public $array;
    public $column;
    public $compare;

    public function __construct($title,$array,$column,$compare)
    {
        $this->column = $column;
        $this->title = $title;
        $this->array = $array;
        $this->compare = $compare;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
