<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class select extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.forms.select');
    }
}
