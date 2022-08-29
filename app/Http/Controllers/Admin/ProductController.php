<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\ProductModel as MainModel;
use App\Models\ProductModel;
use App\Http\Requests\ProductRequest as MainRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends AdminController
{
    public $pathViewController = 'admin.pages.product.';  // slider
    public $controllerName     = 'product';
    public $inTable     = 'products';
    public $folderFileUpload     = 'product';
    public $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 50;
        view()->share('controllerName', $this->controllerName);
        view()->share('inTable', $this->inTable);
        view()->share('folderFileUpload', $this->folderFileUpload);
    }

    public function index(Request $request)
    {
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field']  = $request->input('search_field', ''); // all id description
        $this->params['search']['value']  = $request->input('search_value', '');
        $this->params['search']['filter']  = $request->input('search_filter', '');

        $items              = $this->model->listItems($this->params, ['task'  => 'admin-list-items']);
        $itemsStatusCount   = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']); // [ ['status', 'count']]
        $listCategory = $this->model->listCategory($this->params, ['task'  => 'get-category'], false, true);
        return view($this->pathViewController .  'index', [
            'params'        => $this->params,
            'items'         => $items,
            'itemsStatusCount' =>  $itemsStatusCount,
            'listCategory'   => $listCategory
        ]);
    }

    public function create(Request $request)
    {
        $item = null;
        // $this->model->table('products');
        $itemId = $this->model->createItemDraft();

        return view($this->pathViewController .  'create', [
            'itemId'        => $itemId
        ]);
    }

    public function form(Request $request)
    {
        $item = null;
        if ($request->id !== null) {
            $params["id"] = $request->id;
            $item = $this->model->getItem($params, ['task' => 'get-item']);
        }

        return view($this->pathViewController .  'form', [
            'item'        => $item
        ]);
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();

            $task   = "add-item";
            $notify = "Thêm phần tử thành công!";

            if ($params['id'] !== null) {
                $task   = "edit-item";
                $notify = "Cập nhật phần tử thành công!";
            }
            $this->model->saveItem($params, ['task' => $task]);
            return redirect()->route($this->controllerName)->with("zvn_notify", $notify);
        }
    }

    public function addAttribute(Request $request)
    {
        $resultVal = null;
        $resultName = null;
        $id = $request->id;
        $dataAttrName = json_decode(stripslashes($request->jsonName));
        $dataAttrVal = json_decode(stripslashes($request->jsonValue));
        // $dataAttrName = array_filter($dataAttrName);
        // $dataAttrVal = array_filter($dataAttrVal);
        // foreach ($dataAttrVal as $key => $value) {
        //     $resultVal[] = explode('|', $value);
        // }

        return view($this->pathViewController .  'variants', [
            'id'                  => $id,
            'dataAttrName'        => $dataAttrName,
            'dataAttrVal'         => $dataAttrVal,
            // 'resultName'          => $resultName,
            // 'resultVal'             => $resultVal
        ]);
    }

    public function category(Request $request)
    {
        $params["currentCategory"]    = $request->category;
        $params["id"]             = $request->id;
        $this->model->saveItem($params, ['task' => 'change-category']);
        return response()->json([
            'status' => 'success'
        ]);
    }

    // public function type(Request $request)
    // {
    //     $params["currentType"]    = $request->type;
    //     $params["id"]             = $request->id;
    //     $this->model->saveItem($params, ['task' => 'change-type']);
    //     return response()->json([
    //         'status' => 'success'
    //     ]);
    // }
}
