@php
use App\Models\MenuModel as MenuModel;
use App\Helpers\URL;
use App\Models\CategoryModel as CategoryModel;
$menuModel = new MenuModel();
$categoryModel = new CategoryModel();
$itemsMenu = $menuModel->listItems(null, ['task' => 'news-list-items']);

$xhtmlMenu = '';
$xhtmlMenuMobile = '';
if (count($itemsMenu) > 0) {
    $xhtmlMenu = '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
    $xhtmlMenuMobile = '<nav class="menu_nav"><ul class="menu_mm">';
    $menuIdCurrent = Route::input('menu_name');
    // dd($itemsMenu);
    foreach ($itemsMenu as $item) {
        $linkMenu = $item['link'];
        if ($item['type'] == 'link') {
            // $linkMenu = URL::linkMenu($item['id'], $item['name']);
            $classActive = '';

            $xhtmlMenu .= sprintf('<li class="%s"><a target = "%s" href="%s">%s</a></li>', $classActive, $item['type_open'], $linkMenu, $item['name']);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a target = "%s" href="%s">%s</a></li>', $item['type_open'], $linkMenu, $item['name']);
        } elseif ($item['type'] == 'list_category') {
            $result = DB::table('categories')
                ->select('id', 'name')
                ->where('status', '=', 'active')
                ->get()
                ->toArray();
            // dd($result);
            // $ulList = '<ul class="child">';
            // $categoryIdCurrent = Route::input('category_id');

            // foreach ($result as $key => $value) {
            //     $classActiveSubList = $categoryIdCurrent == $value->id ? 'active' : '';
            //     $linkSubList = URL::linkCategory($value->id, $value->name);

            //     $ulList .= sprintf('<li class="parent %s"><a target = "%s" href="%s">%s</a></li>', $classActiveSubList, $item['type_open'], $linkSubList, $value->name);
            // }
            // $ulList .= '</ul>';
            // $xhtmlMenu .= sprintf('<li class="parent" %s><a> %s </a> %s </li>', $classActiveSubList, $item['name'], $ulList);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', $linkMenu, $item['name']);

            //---------------------------
            $categories = categoryModel::withDepth()
                ->having('depth', '>', 0)
                ->get()
                ->toTree();

            $xhtmlMenu .= sprintf(
                '<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"> %s </a> ',
                $item['name'],
            );
            $xhtmlMenu .= '<ul class="dropdown-menu">';

            function showCategory($categories, &$xhtml)
            {
                foreach ($categories as $category) {
                    $categoryIdCurrent = Route::input('category_id');

                    $linkSubList = URL::linkCategory($category->id, $category->name);
                    $classActiveSubList = $categoryIdCurrent == $category->id ? 'active' : '';
                    if ($category->children->count() > 0) {
                        $xhtml .= sprintf('<li><a class=" %s dropdown-item dropdown-toggle" href="%s">%s</a>', $classActiveSubList, $linkSubList, $category->name);
                    } else {
                        $xhtml .= sprintf('<li><a class="%s dropdown-item" href="%s">%s</a>', $classActiveSubList, $linkSubList, $category->name);
                    }
                    if ($category->children->count() > 0) {
                        $xhtml .= '<ul class="submenu dropdown-menu">';
                        showCategory($category->children, $xhtml);
                        $xhtml .= '</ul>';
                    }
                    $xhtml .= '</li>';
                }
            }

            showCategory($categories, $xhtmlMenu);
            $xhtmlMenu .= ' </ul>';
            $xhtmlMenu .= '</li>';

            //         $xhtmlMenu .= '
            // <li class="nav-item dropdown">
            // 	<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">  More items  </a>
            //     <ul class="dropdown-menu">
            // 	  <li><a class="dropdown-item" href="#"> Dropdown item 1 </a></li>
            // 	  <li><a class="dropdown-item dropdown-toggle" href="#"> Dropdown item 2 </a>
            // 	  	 <ul class="submenu dropdown-menu">
            // 		    <li><a class="dropdown-item" href="">Submenu item 1</a></li>
            // 		    <li><a class="dropdown-item" href="">Submenu item 2</a></li>
            // 		    <li><a class="dropdown-item" href="">Submenu item 3</a></li>
            // 		 </ul>
            // 	  </li>
            // 	  <li><a class="dropdown-item dropdown-toggle" href="#"> Dropdown item 3 </a>
            // 	  	 <ul class="submenu dropdown-menu">
            // 		    <li><a class="dropdown-item" href="">Another submenu 1</a></li>
            // 		    <li><a class="dropdown-item" href="">Another submenu 2</a></li>
            // 		    <li><a class="dropdown-item" href="">Another submenu 3</a></li>
            // 		    <li><a class="dropdown-item" href="">Another submenu 4</a></li>
            // 		 </ul>
            // 	  </li>
            // 	  <li><a class="dropdown-item dropdown-toggle" href="#"> Dropdown item 4 </a>
            // 	  	 <ul class="submenu dropdown-menu">
            // 		    <li><a class="dropdown-item" href="">Another submenu 1</a></li>
            // 		    <li><a class="dropdown-item" href="">Another submenu 2</a></li>
            // 		    <li><a class="dropdown-item" href="">Another submenu 3</a></li>
            // 		    <li><a class="dropdown-item" href="">Another submenu 4</a></li>
            // 		 </ul>
            // 	  </li>
            // 	  <li><a class="dropdown-item" href="#"> Dropdown item 4 </a></li>
            // 	  <li><a class="dropdown-item" href="#"> Dropdown item 5 </a></li>
            //     </ul>
            // </li>
            //             ';
            //=----------------------------
        } elseif ($item['type'] == 'list_article') {
            $result = DB::table('articles')
                ->select('id', 'name')
                ->where('status', '=', 'active')
                ->get()
                ->toArray();

            $ulList = '<ul class="child">';
            $categoryIdCurrent = Route::input('category_id');
            $categoryIdCurrent = '';

            foreach ($result as $key => $value) {
                $classActiveSubList = $categoryIdCurrent == $value->id ? 'active' : '';
                $linkSubList = URL::linkCategory($value->id, $value->name);

                $ulList .= sprintf('<li class="parent %s"><a target = "%s" href="%s">%s</a></li>', $classActiveSubList, $item['type_open'], $linkSubList, $value->name);
            }
            $ulList .= '</ul>';
            $xhtmlMenu .= sprintf('<li class="parent" %s><a> %s </a> %s </li>', $classActiveSubList, $item['name'], $ulList);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', $linkMenu, $item['name']);
        }
    }
    if (session('userInfo')) {
        $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/logout'), 'Logout');
    } else {
        $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/login'), 'Login');
    }

    // $category = CategoryModel::find(1);
    // $categories = $category->descendants()->pluck('id');

    // $categories[] = $category->getKey();
    // $goods = CategoryModel::whereIn('id', $categories)->get();

    // $categories = $categories[0];
    // dd($categories);

    $xhtmlMenu .= $xhtmlMenuUser . '</ul></nav>';
    $xhtmlMenuMobile .= $xhtmlMenuUser . '</ul></nav>';
}
// $categoryModel = new CategoryModel();
// $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items']);

// $xhtmlMenu = '';
// $xhtmlMenuMobile = '';

// if (count($itemsCategory) > 0) {

//     $xhtmlMenu = '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
//     $xhtmlMenuMobile = '<nav class="menu_nav"><ul class="menu_mm">';
//     $categoryIdCurrent = Route::input('category_id');

//     foreach ($itemsCategory as $item) {

//         $link       =  URL::linkCategory($item['id'], $item['name']);
//         $classActive = ($categoryIdCurrent == $item['id']) ? 'class="active"' : '';

//         $xhtmlMenu .= sprintf('<li %s><a href="%s">%s</a></li>', $classActive, $link, $item['name']);
//         $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', $link, $item['name']);
//     }

//     $xhtmlMenu .= sprintf('<li><a href="%s">Tin tức tổng hợp</a></li>', route('rss/index'));
//     $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">Tin tức tổng hợp</a></li>', route('rss/index'));

//     if (session('userInfo')) {
//         $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/logout'), 'Logout');
//     }else {
//         $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/login'), 'Login');
//     }

//     $xhtmlMenu .= $xhtmlMenuUser . '</ul></nav>';
//     $xhtmlMenuMobile .= $xhtmlMenuUser . '</ul></nav>';
// }
@endphp

<header class="header">
    <table class="table">

        <div class="header_content_container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="header_content d-flex flex-row align-items-center justfy-content-start">
                            <div class="logo_container">
                                <a href="{!! route('home') !!}">
                                    <div class="logo"><span>ZEND</span>VN</div>
                                </a>
                            </div>
                            <div class="header_extra ml-auto d-flex flex-row align-items-center justify-content-start">
                                <a href="#">
                                    <div class="background_image"
                                        style="background-image:url({{ asset('news/images/zendvn-online.png') }});background-size: contain">
                                    </div>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Navigation & Search -->
        <div class="header_nav_container" id="header">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="header_nav_content d-flex flex-row align-items-center justify-content-start">

                            <!-- Logo -->
                            <div class="logo_container">
                                <a href="#">
                                    <div class="logo"><span>ZEND</span>VN</div>
                                </a>
                            </div>

                            <!-- Navigation -->
                            {!! $xhtmlMenu !!}

                            <!-- Hamburger -->
                            <div class="hamburger ml-auto menu_mm"><i class="fa fa-bars  trans_200 menu_mm"
                                    aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</header>

<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
    <div class="menu_close_container">
        <div class="menu_close">
            <div></div>
            <div></div>
        </div>
    </div>

    {!! $xhtmlMenuMobile !!}


</div>
