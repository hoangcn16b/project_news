<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Status extends Component
{
    public $rowId;
    public $isStatus;
    public $inTable;

    public function mount($rowId, $isStatus, $inTable)
    {
        $this->rowId = $rowId;
        $this->isStatus = $isStatus;
        $this->inTable = $inTable;
    }

    public function changeStatus()
    {
        $this->isStatus = ($this->isStatus == 'active') ? 'inactive' : 'active';
        DB::table($this->inTable)
            ->where('id', $this->rowId)
            ->update(['status' => $this->isStatus]);
    }

    public function render()
    {
        return view('livewire.status');
    }
}
