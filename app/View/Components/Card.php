<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $description;
    public $link;
    public $waveColor;

    public function __construct(
        $title,
        $description,
        $link = '#',
        $waveColor = 'rgba(0, 123, 255, 0.3)'
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
        $this->waveColor = $this->parseColor($waveColor);
    }

    private function parseColor($color)
    {
        if (strpos($color, 'rgba') !== false) {
            return $color;
        }

        if (strpos($color, '#') === 0) {
            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
            return "rgba($r, $g, $b, 0.3)";
        }

        return $color;
    }

    public function render()
    {
        return view('components.card');
    }
}
