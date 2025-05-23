<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BeritaCard extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.card.berita-card');
    }
}
