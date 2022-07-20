<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

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
        DB::table('category')
            ->where('id', $this->rowId)
            ->update(['is_home' => $this->isHome]);
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
