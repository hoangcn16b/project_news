<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use App\Helpers\Template as Template;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Selectdb extends Component
{
    public $rowId;
    public $thisVal;
    public $inTable;
    public $inConfig;
    public $thisCol;
    public $fieldName;
    public function mount($thisCol, $rowId, $thisVal, $fieldName, $inTable)
    {
        $this->rowId = $rowId;
        $this->thisVal = $thisVal;
        $this->inTable = $inTable;
        $this->fieldName = $fieldName;
        $this->thisCol = $thisCol;
    }

    public function updatedThisVal($value)
    {
        $this->thisVal = $value;
        DB::table($this->inTable)
            ->where('id', $this->rowId)
            ->update([$this->thisCol => $value]);
        toastr()->success('Thay đổi thành công!');
        // $this->dispatchBrowserEvent(
        //     'alert',
        //     ['type' => 'success',  'message' => 'Changed Successfully!']
        // );
    }

    public function render()
    {
        return view('livewire.selectBoxFromDB');
    }
}
