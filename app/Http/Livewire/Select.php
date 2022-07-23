<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use App\Helpers\Template as Template;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Select extends Component
{
    public $rowId;
    public $thisType;
    public $inTable;
    public $inConfig;
    public $fieldName;
    public $thisColumn;

    public function mount($thisColumn, $rowId, $thisType, $fieldName, $inTable)
    {
        $this->rowId = $rowId;
        $this->thisType = $thisType;
        $this->inTable = $inTable;
        $this->fieldName = $fieldName;
        $this->thisColumn = $thisColumn;
    }

    public function updatedThisType($value)
    {
        $this->thisType = $value;
        DB::table($this->inTable)
            ->where('id', $this->rowId)
            ->update([$this->thisColumn => $value]);
        toastr()->success('Thay đổi thành công!');
    }

    public function render()
    {
        return view('livewire.selectBox');
    }
}
