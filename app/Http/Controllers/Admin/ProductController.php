<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\ProductModel as MainModel;
use App\Models\ProductModel;
use App\Models\AttributeModel;
use App\Models\AttributeValueModel;
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

        // $itemId = $this->model->createItemDraft();
        $itemId = 192;
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

    public function createAttribute(Request $request)
    {
        $listIdAttr = null;
        $listIdAttrVariant = null;
        $resultVal = null;
        $resultVariant = null;
        $productId = $request->id;
        $dataAttrId = json_decode(($request->jsonId));
        $dataAttrName = json_decode(($request->jsonName));
        $dataAttrVal = json_decode(($request->jsonValue));
        $resultVariant = null;
        foreach ($dataAttrVal as $key => $value) {
            $resultVal = str_replace('{"value":"', '', $value);
            $resultVal = str_replace('"}', '', $resultVal);
            $resultVariant[$dataAttrId[$key]] = explode(',', trim($resultVal, '[]'));
        }
        //update colmun in attributes
        if (!empty($dataAttrId)) {
            foreach ($dataAttrId as $key => $id) {
                DB::table('attributes')
                    ->where('id', $id)
                    ->update(['product_id' => $productId, 'name' => $dataAttrName[$key], 'value_taginput' => $dataAttrVal[$key]]);
            }
        }
        // //add new draft column
        DB::insert("insert into attributes (product_id, name, value_taginput) values ($productId,'','')");
        $newId = DB::getPdo()->lastInsertId();
        $dataAttrId[] = $newId;
        $dataAttrName[] = '';
        $dataAttrVal[] = '';
        $resultVariant[$newId] = '';
        //add variant to attribute values
        // foreach ($resultVariant as $key2 => $variants) {
        //     if (!empty($variants)) {
        //         foreach ($variants as $varis => $variant) {
        //             DB::insert("insert into attribute_values (name, attribute_id, product_id) values ('$variant','$key2','$productId')");
        //             // $listIdAttrVariant[] = DB::getPdo()->lastInsertId();
        //         }
        //     }
        // }
        return view($this->pathViewController .  'attribute', [
            'dataAttrName' => $dataAttrName,
            'dataAttrVal' => $dataAttrVal,
            'dataAttrId' => $dataAttrId,
            'productId' => $productId,
            // 'newId' => $newId
        ]);
    }

    public function addAttribute(Request $request)
    {
        $listIdAttr = null;
        $listIdAttrVariant = null;
        $resultVal = null;
        $resultVariant = null;
        $productId = $request->id;
        $attrName = $request->attribute_name;
        $attrValue = $request->attribute_value;
        // $dataAttrName = json_decode(stripslashes($request->jsonName));
        // $dataAttrVal = json_decode(stripslashes($request->jsonValue));

        // foreach ($attrValue as $key => $value) {
        //     $resultVal = str_replace('{"value":"', '', $value);
        //     $resultVal = str_replace('"}', '', $resultVal);
        //     $resultVariant[$key] = explode(',', trim($resultVal, '[]'));
        // }
        // echo '<pre>';
        // print_r($resultVariant);
        // echo '</pre>';
        // die;
        // foreach ($attrName as $key => $value) {
        //     $valueTaginput = json_encode($attrValue[$key]);
        //     DB::insert("insert into attributes (name, product_id, value_taginput) values ($value,$productId,$valueTaginput)");
        //     $listIdAttr[] = DB::getPdo()->lastInsertId();
        // }

        // $sortResultVairant = null;
        // foreach ($listIdAttr as $key1 => $value1) {
        //     $sortResultVairant[$value1] = $resultVariant[$key1];
        // }
        // echo '<pre>';
        // print_r($sortResultVairant);
        // echo '</pre>';
        // foreach ($sortResultVairant as $key2 => $variants) {
        //     if ($variants != '') {
        //         foreach ($variants as $varis => $variant) {
        //             DB::insert("insert into attribute_values (name, attribute_id, product_id) values ($variant,$key2,$productId)");
        //             $listIdAttrVariant[] = DB::getPdo()->lastInsertId();
        //         }
        //     }
        // }

        // echo '<pre>';
        // print_r($listIdAttrVariant);
        // echo '</pre>';
        return view($this->pathViewController .  'variants', [
            'productId'                  => $productId,
            'listIdAttr'                 => $listIdAttr
        ]);
    }

    public function deleteAttribute(Request $request)
    {
        $params = $request->all();
        AttributeModel::deleteAttribute($params);
        AttributeValueModel::deleteAttrValue($params);
        // $result = DB::table('attribute_values')->where('attribute_id', $params['id'])->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function updateAttributeName(Request $request)
    {
        $params = $request->all();
        AttributeModel::updateAttrName($params);
        return response()->json([
            'status' => 'success'
        ]);
    }
    
    public function updateAttributeValue(Request $request)
    {
        $params = $request->all();
        echo '<pre>';
        print_r($params);
        echo '</pre>';
        // AttributeModel::updateAttrValue($params);
        return response()->json([
            'status' => 'success'
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
