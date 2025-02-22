<?php

namespace App\View\Components\Text;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PopUpMenu extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.text.pop-up-menu');
    }
}
