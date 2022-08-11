@php
use App\Helpers\Template as Template;
use App\Helpers\Hightlight as Hightlight;
use App\Models\CategoryModel;
// dd($items);
@endphp
<div class="x_content">


    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Name</th>
                    <th class="column-title">Ordering</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Hiện thị Home</th>
                    <th class="column-title">Kiểu hiện thị</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $id = $val['id'];
                            
                            $node = CategoryModel::find($id);
                            $resultPre = $node->getPrevSibling();
                            $resultNext = $node->getNextSibling();
                            // dd($resultPre);
                            $buttonDown = '<a href="' . route('category/ordering', ['ordering' => 'down', 'id' => $id]) . '"><i class="fa fa-arrow-down"></i></a>';
                            $buttonUp = '<a href="' . route('category/ordering', ['ordering' => 'up', 'id' => $id]) . '"><i class="fa fa-arrow-up"></i></a>';
                            
                            if ($resultPre == null) {
                                $buttonUp = '';
                            }
                            if ($resultNext == null) {
                                $buttonDown = '';
                            }
                            // $result = $val->getPrevSibling();
                            // dd($items[$key - 1]['depth'] . $val['depth']);
                            // if ($items[$key + 1]['depth'] > $val['depth']) {
                            //     $buttonDown = '<a href="' . route('category/ordering', ['ordering' => 'down', 'id' => $id]) . '">DOWN</a>';
                            // }
                            // if ($items[$key - 1] == 0) {
                            //     $buttonUp = '';
                            // } else {
                            //     if ($items[$key - 1]['depth'] < $val['depth']) {
                            //         $buttonUp = '<a href="' . route('category/ordering', ['ordering' => 'up', 'id' => $id]) . '">UP</a>';
                            //     }
                            // }
                            $index = $key + 1;
                            $class = $index % 2 == 0 ? 'even' : 'odd';
                            $name = Hightlight::show($val['name'], $params['search'], 'name');
                            $name = str_repeat('-----/ ', $val['depth'] - 1) . $name;
                            // $status          = Template::showItemStatus($controllerName, $id, $val['status']);
                            // $isHome          = Template::showItemIsHome($controllerName, $id, $val['is_home']);
                            // $display         = Template::showItemSelect($controllerName, $id, $val['display'], 'display');
                            $createdHistory = Template::showItemHistory($val['created_by'], $val['created']);
                            $modifiedHistory = Template::showItemHistory($val['modified_by'], $val['modified']);
                            $listBtnAction = Template::showButtonAction($controllerName, $id);
                            $fieldName = 'display';
                            $thisColumn = 'display';
                        @endphp

                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td width="25%">{!! $name !!}</td>
                            <td width="10%">
                                {!! $buttonUp !!}
                                &nbsp
                                &nbsp
                                &nbsp
                                {!! $buttonDown !!}
                            </td>
                            {{-- <td>{!! $status !!}</td> --}}
                            {{-- <td>{!! $isHome  !!}</td> --}}
                            <td>
                                <livewire:status :isStatus="$val['status']" :rowId="$id" :inTable="$inTable" />
                            </td>
                            <td>
                                <livewire:changehome :isHome="$val['is_home']" :rowId="$id" />
                            </td>
                            <td>
                                <livewire:select :thisColumn="$thisColumn" :thisType="$val['display']" :rowId="$id" :fieldName="$fieldName"
                                    :inTable="$inTable" />
                            </td>
                            {{-- <td>{!! $display !!}</td> --}}
                            <td>{!! $createdHistory !!}</td>
                            <td>{!! $modifiedHistory !!}</td>
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
