<?php

namespace app\View\Components\card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class produk extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.card.produk');
    }
}
