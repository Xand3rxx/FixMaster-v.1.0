<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    /**
     * The card title.
     *
     * @var string
     */
    public $cardtitle;

    /**
     * The card number.
     *
     * @var int
     */
    public $cardnumber;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($cardtitle, $cardnumber)
    {
        $this->cardtitle = $cardtitle;
        $this->cardnumber = $cardnumber;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
