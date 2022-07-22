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
                    <th class="column-title">
                        <p>Dữ liệu từ bảng(dành cho <br>loại hiển thị danh sách con)
                    </th>
                    <th class="column-title">Sắp xếp</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $index = $key + 1;
                            $class = $index % 2 == 0 ? 'even' : 'odd';
                            $id = $val['id'];
                            $name = Hightlight::show($val['name'], $params['search'], 'name');
                            $link = $val['link'];
                            // $status          = Template::showItemStatus($controllerName, $id, $val['status']);
                            // $display         = Template::showItemSelect($controllerName, $id, $val['type'], 'display_menu');
                            // $ordering         = Template::showItemSelectOrdering($controllerName, $id, $val['ordering'], 'ordering');
                            $listBtnAction = Template::showButtonAction($controllerName, $id);
                            $inConfigDisplay = 'display_menu';
                            $inConfigOrdering = 'ordering';
                            $fieldNameInTable = 'in_table';
                            $fieldNameDisplay = 'display_menu';
                            $thisColumnInTable = 'in_table';
                            $thisColumnDisplay = 'type';
                            $thisColumnOrdering = 'ordering';
                            // category_product
                            // categoryProduct
                        @endphp

                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td width="15%">{!! $name !!}</td>
                            <td>{!! $link !!}</td>
                            {{-- <td>{!! $val['in_table'] !!}</td> --}}
                            <td>
                                <livewire:status :isStatus="$val['status']" :rowId="$id" :inTable="$inTable" />
                            </td>
                            <td>
                                <livewire:select :thisColumn="$thisColumnDisplay" :thisType="$val['type']" :rowId="$id" :fieldName="$fieldNameDisplay"
                                    :inTable="$inTable" />
                            </td>
                            <td width="15%" align="center">
                                @if (!empty($val['type']) && $val['type'] == 'sub_list_menu')
                                    <livewire:select :thisColumn="$thisColumnInTable" :thisType="$val['in_table']" :rowId="$id"
                                        :fieldName="$fieldNameInTable" :inTable="$inTable" />
                                @else
                                    N/A
                                @endif
                            </td>
                            <td style=" width:5%;">
                                <livewire:ordering :thisColumn="$thisColumnOrdering" :ordering="$val['ordering']" :rowId="$id"
                                    :inTable="$inTable" />
                            </td>
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
