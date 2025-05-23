<?php

namespace App\View\Components\svg;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class background2 extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.svg.background2');
    }
}
