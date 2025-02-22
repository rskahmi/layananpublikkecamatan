<?php

namespace App\View\Components\svg\icon;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class users extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.svg.icon.users');
    }
}
