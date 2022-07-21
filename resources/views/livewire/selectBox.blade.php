@php
use App\Helpers\Template as Template;

@endphp
<div wire:model.defer="select">
    {!! Template::showItemSelect($inTable, $rowId, $isType, $inConfig) !!}
</div>
