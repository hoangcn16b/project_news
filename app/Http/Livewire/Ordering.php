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
        $check = false;
        $this->ordering = $value;
        if (($value > 0 && $value <= 20) && (!is_integer($value))) {
            DB::table($this->inTable)
                ->where('id', $this->rowId)
                ->update([$this->thisColumn => $value]);
            $check = true;
        }

        if ($check) {
            toastr()->success('Thay đổi thành công!');
        } else {
            toastr()->error('Thay đổi thất bại, giá trị phải là số nguyên, thuộc 1-20!');
        }
    }

    public function render()
    {
        return view('livewire.selectOrdering');
    }
}
