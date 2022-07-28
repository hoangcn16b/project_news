<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel as MainModel;
use App\Http\Requests\PasswordRequest as MainRequest;

class PasswordController extends Controller
{
    private $params             = [];
    public $pathViewController = 'admin.pages.password.';
    public $controllerName     = 'password';
    public $inTable     = 'user';
    public $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 10;
        view()->share('inTable', $this->inTable);
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field']  = $request->input('search_field', ''); // all id description
        $this->params['search']['value']  = $request->input('search_value', '');

        $items              = $this->model->listItems($this->params, ['task'  => 'admin-list-items']);
        $itemsStatusCount   = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']); // [ ['status', 'count']]

        return view($this->pathViewController .  'index', [
            'params'        => $this->params,
            'items'         => $items,
            'itemsStatusCount' =>  $itemsStatusCount
        ]);
    }


    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();

            // $task   = "add-item";
            // $notify = "Thêm phần tử thành công!";

            if ($params['id'] !== null) {
                // $task   = "edit-item";
                $task = '';
                $notify = "Cập nhật phần tử thành công!";
            }
            $this->model->saveItem($params, ['task' => $task]);
            return redirect()->route('password')->with("zvn_notify", $notify);
        }
    }

}
