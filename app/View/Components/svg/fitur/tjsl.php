<?php

namespace App\View\Components\svg\fitur;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tjsl extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.svg.fitur.tjsl');
    }
}
