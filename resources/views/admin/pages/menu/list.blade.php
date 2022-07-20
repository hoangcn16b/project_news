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
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Loại hiển thị</th>
                    {{-- <th class="column-title">Kiểu hiện thị</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th> --}}
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
                            $status          = Template::showItemStatus($controllerName, $id, $val['status']);
                            // $isHome          = Template::showItemIsHome($controllerName, $id, $val['is_home']);
                            $display         = Template::showItemSelect($controllerName, $id, $val['type'], 'display_menu');
                            // $createdHistory  = Template::showItemHistory($val['created_by'], $val['created']);
                            // $modifiedHistory = Template::showItemHistory($val['modified_by'], $val['modified']);
                            $listBtnAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{ $class }} pointer">
                            <td >{{ $index }}</td>
                            <td width="15%">{!! $name !!}</td>
                            <td>{!! $link !!}</td>
                            <td>{!! $status !!}</td>
                            <td width="15%">{!! $display !!}</td>
                            {{-- <td>{!! $isHome  !!}</td>
                            <td><livewire:counter :isHome="$val['is_home']" :rowId="$id"/> </td>
                            <td>{!! $display !!}</td>
                            <td>{!! $createdHistory !!}</td> 
                            <td>{!! $modifiedHistory !!}</td> --}}
                            <td>{!! $val['ordering'] !!}</td>
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
           