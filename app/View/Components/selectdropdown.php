<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class selectdropdown extends Component
{
    /**
     * Create a new component instance.
     */
    //{{--  array $allModel $column $show $title--}}

    public $column;
    public $show;
    public $title;
    public $array;

    public function __construct($column,$show,$title,$array)
    {

        $this->column = $column;
        $this->show = $show;
        $this->title = $title;
        $this->array = $array;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.selectdropdown');
    }
}