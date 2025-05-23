<?php

namespace App\View\Components\layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class delete extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.layout.delete');
    }
}
