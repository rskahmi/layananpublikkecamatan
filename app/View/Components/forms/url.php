<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class url extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.forms.url');
    }
}
