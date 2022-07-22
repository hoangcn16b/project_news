<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $pathViewController = 'admin.pages.dashboard.';  // slider
    public $controllerName     = 'dashboard';

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index()
    {
        return view($this->pathViewController .  'index', []);
    }
}
