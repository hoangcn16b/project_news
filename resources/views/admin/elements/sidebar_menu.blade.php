<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{ asset('admin/img/img.jpg') }}" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Welcome,</span>
        <h2>luutruonghailan</h2>
    </div>
</div>
<!-- /menu profile quick info -->
<br />
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('user') }}"><i class="fa fa-user"></i> User</a></li>
            <li><a href="{{ route('category') }}"><i class="fa fa fa-building-o"></i> Category</a></li>
            <li><a href="{{ route('article') }}"><i class="fa fa-newspaper-o"></i> Article</a></li>
            <li><a href="{{ route('slider') }}"><i class="fa fa-sliders"></i> Silders</a></li>
            <li><a href="{{ route('rss') }}"><i class="fa fa-newspaper-o"></i> Rss</a></li>
            <li><a href="{{ route('contact') }}"><i class="fa fa-comment"></i> Contact</a></li>
            <li><a href="{{ route('menu') }}"><i class="fa fa-bars"></i> Menu</a></li>
            <li><a href="{{ route('images') }}"><i class="fa fa-image"></i> Images</a></li>
            <li><a href="{{ route('setting') }}"><i class="fa fa-gear"></i> Setting Website</a></li>
            <li><a href="{{ route('productCategory') }}"><i class="fa fa-building"></i> Product Category </a></li>
            <li><a href="{{ route('product') }}"><i class="fa fa-product-hunt"></i> Products </a></li>
            <li><a href="{{ route('attribute') }}"><i class="fa fa-align-center"></i> Attributes </a></li>
            <li><a href="{{ route('productAttribute') }}"><i class="fa fa-tag"></i> Product Attributes </a></li>
            <li><a href="{{ route('password') }}"><i class="fa fa-key"></i> Change Password</a></li>

            {{-- <li><a href="{{ route('democategory') }}"><i class=""></i> Demo Category </a></li> --}}
        </ul>
    </div>
</div>
<!-- /sidebar menu -->
