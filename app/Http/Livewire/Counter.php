<?php

namespace App\Http\Livewire;

use Livewire\Component;


class Counter extends Component
{
    public $rowId;
    public $isHome;
    // public function increment()
    // {
    //     $this->count++;
    // }
    public function mount($rowId, $isHome)
    {
        $this->rowId = $rowId;
        $this->isHome = $isHome;
    }
    public function changeIsHome()
    {
        $this->isHome = ($this->isHome == 'yes') ? 'no' : 'yes';

    }

    public function render()
    {
        return view('livewire.counter');
    }
}
