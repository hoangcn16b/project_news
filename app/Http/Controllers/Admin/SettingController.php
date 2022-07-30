<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingModel as MainModel;
// use App\Http\Requests\SettingRequest as MainRequest;

class SettingController extends Controller
{
    private $params             = [];
    public $pathViewController = 'admin.pages.setting.';
    public $controllerName     = 'setting';
    public $inTable     = 'setting';
    public $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 5;
        view()->share('inTable', $this->inTable);
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {

        $item              = $this->model->listItems($this->params, ['task'  => 'admin-setting-general']);

        return view($this->pathViewController .  'index', [
            'params'        => $this->params,
            'item'         => $item,
        ]);
    }

    public function save(Request $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();

            $task   = "change-general-setting";
            $notify = "Cập nhật dữu liệu thành công!";
            $this->model->saveItem($params, ['task' => $task]);
            return redirect()->route($this->controllerName)->with("zvn_notify", $notify);
        }
    }
}
