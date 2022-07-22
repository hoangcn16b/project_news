<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Notification;
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
        // $this->alertSuccess();
        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success',  'message' => 'Changed Successfully!']
        );
    }

    public function alertSuccess()
    {
        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success',  'message' => 'User Changed Successfully!']
        );
    }

    public function render()
    {
        return view('livewire.status');
    }
}
