@php
use App\Helpers\Template as Template;
@endphp
<div>
    {!! Template::selectDBByLiveWire('thisVal', $fieldName, false) !!}
</div>
