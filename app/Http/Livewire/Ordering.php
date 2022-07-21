<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Ordering extends Component
{
    public $rowId;
    public $isOrdering;
    public $inTable;
    public $inConfig;

    public function mount($rowId, $isOrdering, $inTable, $inConfig)
    {
        $this->rowId = $rowId;
        $this->isOrdering = $isOrdering;
        $this->inTable = $inTable;
        $this->inConfig = $inConfig;
    }

    public function select()
    {
        // $this->isType = ($this->isType == 'active') ? 'inactive' : 'active';
        // DB::table($this->inTable)
        //     ->where('id', $this->rowId)
        //     ->update(['type' => $this->isType]);
    }

    public function render()
    {
        return view('livewire.selectOrdering');
    }
}
