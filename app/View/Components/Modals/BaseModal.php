<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseModal extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.modals.base-modal');
    }
}
