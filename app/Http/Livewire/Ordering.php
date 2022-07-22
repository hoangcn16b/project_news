<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Ordering extends Component
{
    public $rowId;
    public $ordering;
    public $inTable;
    public $thisColumn;

    public function mount($thisColumn, $rowId, $ordering, $inTable)
    {
        $this->rowId = $rowId;
        $this->ordering = $ordering;
        $this->inTable = $inTable;
        $this->thisColumn = $thisColumn;
    }

    public function ordering($value)
    {
        $this->ordering = $value;
        if ($value > 0 && $value <= 20) {
            DB::table($this->inTable)
                ->where('id', $this->rowId)
                ->update([$this->thisColumn => $value]);
        }
    }

    public function render()
    {
        return view('livewire.selectOrdering');
    }
}
