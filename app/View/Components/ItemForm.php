<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ItemForm extends Component
{
    public $categories;
    public $action;
    public $isEdit;

    public function __construct($categories, $action, $isEdit = false)
    {
        $this->categories = $categories;
        $this->action = $action;
        $this->isEdit = $isEdit;
    }

    public function render()
    {
        return view('components.item-form');
    }
}

