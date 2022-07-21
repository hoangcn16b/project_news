@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
@endphp
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Name</th>
                    <th class="column-title">Link</th>
                    <th class="column-title">Dữ liệu của bảng<br>(dành cho loại hiển thị danh sách)</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Loại hiển thị</th>
                    <th class="column-title">Sắp xếp</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $index           = $key + 1;
                            $class           = ($index % 2 == 0) ? "even" : "odd";
                            $id              = $val['id'];
                            $name            = Hightlight::show($val['name'], $params['search'], 'name');
                            $link = $val['link'];
                            // $status          = Template::showItemStatus($controllerName, $id, $val['status']);
                            // $display         = Template::showItemSelect($controllerName, $id, $val['type'], 'display_menu');
                            // $ordering         = Template::showItemSelectOrdering($controllerName, $id, $val['ordering'], 'ordering');
                            $listBtnAction   = Template::showButtonAction($controllerName, $id);
                            $inConfigDisplay = 'display_menu';
                            $inConfigOrdering = 'ordering';
                        @endphp

                        <tr class="{{ $class }} pointer">
                            <td >{{ $index }}</td>
                            <td width="15%">{!! $name !!}</td>
                            <td>{!! $link !!}</td>
                            <td>{!! $val['in_table'] !!}</td>
                            <td><livewire:status :isStatus="$val['status']" :rowId="$id" :inTable="$controllerName"/> </td>
                            <td><livewire:select :isType="$val['type']" :rowId="$id" :inTable="$controllerName" :inConfig="$inConfigDisplay"/> </td>
                            <td><livewire:ordering :isOrdering="$val['ordering']" :rowId="$id" :inTable="$controllerName" :inConfig="$inConfigOrdering"/> </td>
                            {{-- <td width="15%">{!! $display !!}</td> --}}
                            {{-- <td><livewire:counter :isHome="$val['is_home']" :rowId="$id"/> </td> --}}
                            {{-- <td>{!! $ordering !!}</td> --}}
                            <td class="last">{!! $listBtnAction !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colspan' => 6])
                @endif
            </tbody>
        </table>
    </div>
</div>
           