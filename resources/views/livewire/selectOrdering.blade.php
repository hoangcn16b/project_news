@php
use App\Helpers\Template as Template;

@endphp
<div wire:model.defer="select">
    {!! Template::showItemSelectOrdering($inTable, $rowId, $isOrdering, $inConfig) !!}
</div>
