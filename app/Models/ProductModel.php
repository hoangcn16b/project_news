<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategoryModel;

class ProductModel extends AdminModel
{
    public function __construct()
    {
        $this->table               = 'products as p';
        $this->folderUpload        = 'product';
        $this->fieldSearchAccepted = ['name', 'content'];
        $this->crudNotAccepted     = ['_token', 'thumb_current'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategoryModel::class, 'product_category_id');
    }

    public function listItems($params = null, $options = null)
    {

        $result = null;

        if ($options['task'] == "admin-list-items") {
            $query = $this->with('productCategory')->select('id', 'name', 'price', 'sale_off', 'status', 'description', 'content', 'thumb', 'ordering', 'product_category_id')->where('id', '>', 0);

            if ($params['filter']['status'] !== "all") {
                $query->where('status', '=', $params['filter']['status']);
            }

            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE',  "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE',  "%{$params['search']['value']}%");
                }
            }

            if ($params['search']['filter'] !== "") {
                if ($params['search']['filter'] == "all") {
                } else if (array_key_exists($params['search']['filter'], $this->listCategory(null, ['task' => 'get-category']))) {
                    $query->where('product_category_id', '=',  $params['search']['filter']);
                }
            }

            $result =  $query->orderBy('id', 'desc')
                ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if ($options['task'] == 'news-list-items') {
            $query = $this->select('id', 'name', 'thumb')
                ->where('status', '=', 'active')
                ->limit(5);

            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'news-list-items-featured') {

            $query = $this->select('p.id', 'p.name', 'p.content', 'p.created_at', 'p.category_id', 'c.name as category_name', 'p.thumb')
                ->leftJoin('categories as c', 'p.category_id', '=', 'c.id')
                ->where('p.status', '=', 'active')
                ->where('p.type', 'featured')
                ->orderBy('p.id', 'desc')
                ->take(3);

            $result = $query->get()->toArray();
        }


        if ($options['task'] == 'news-list-items-latest') {

            $query = $this->select('p.id', 'p.name', 'p.created_at', 'p.category_id', 'c.name as category_name', 'p.thumb')
                ->leftJoin('categories as c', 'p.category_id', '=', 'c.id')
                ->where('p.status', '=', 'active')
                ->orderBy('id', 'desc')
                ->take(4);;
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'news-list-items-in-category') {
            $query = $this->select('id', 'name', 'content', 'thumb', 'created_at')
                ->where('status', '=', 'active')
                ->where('category_id', '=', $params['category_id'])
                ->take(4);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'news-list-items-related-in-category') {
            $query = $this->select('id', 'name', 'content', 'thumb', 'created_at')
                ->where('status', '=', 'active')
                ->where('p.id', '!=', $params['product_id'])
                ->where('product_category_id', '=', $params['product_category_id'])
                ->take(4);
            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function getCategoryNestedset($params = null, $options  = null)
    {
        $result = null;
        if ($options['task'] == 'get-category') {
            $category = new ProductCategoryModel();
            $result = $category->getItem(null, ['task' => 'get-item']);
        }
        return $result;
    }

    public function listCategory($params = null, $options  = null, $hasDefault = false, $root = false)
    {
        $result = null;
        if ($hasDefault) $result['all'] = 'Filter by All';
        if ($options['task'] == 'get-category') {
            $query = ProductCategoryModel::withDepth()->defaultOrder();
            $query = $query->get();
            foreach ($query as $key => $value) {
                $depth = $value->depth <= 1 ? 0 : $value->depth - 1;
                $result[$value->id] = str_repeat('-----/ ', $depth) . $value->name;
            }
        }
        if (!$root) unset($result[6]);
        return $result;
    }

    public function countItems($params = null, $options  = null)
    {

        $result = null;

        if ($options['task'] == 'admin-count-items-group-by-status') {

            $query = $this::groupBy('status')
                ->select(DB::raw('status , COUNT(id) as count'));

            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE',  "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE',  "%{$params['search']['value']}%");
                }
            }

            if ($params['search']['filter'] !== "") {
                if ($params['search']['filter'] == "all") {
                } else if (array_key_exists($params['search']['filter'], $this->listCategory(null, ['task' => 'get-category']))) {
                    $query->where('product_category_id', '=',  $params['search']['filter']);
                }
            }

            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'name', 'price', 'sale_off', 'description', 'special', 'content', 'status', 'thumb', 'product_category_id')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'news-get-item') {
            $result = self::select('p.id', 'p.name', 'content', 'p.product_category_id', 'c.name as category_name', 'p.thumb', 'p.created_at', 'c.display')
                ->leftJoin('product_categories as c', 'p.product_category_id', '=', 'c.id')
                ->where('p.id', '=', $params['product_id'])
                ->where('p.status', '=', 'active')->first();
            if ($result) $result = $result->toArray();
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        $this->table = 'products';
        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'change-type') {
            self::where('id', $params['id'])->update(['type' => $params['currentType']]);
        }


        if ($options['task'] == 'add-item') {
            $params['created_by'] = "hailan";
            $params['created_at']    = date('Y-m-d H:i:s');
            if ($params['thumb1']) {
                $arrJson = [];
                foreach ($params['thumb1'] as $key => $value) {
                    // echo $thumbName        = Str::random(10) . '.' . $params['thumb1'][$key]->clientExtension() . '<br>';
                    $thumbName = $this->uploadMultiThumb($params['thumb1'][$key]);
                    $arrJson['image'][] = $thumbName;
                    $arrJson['alt'][] = $params['alt'][$key];
                }
                $arrJson = json_encode($arrJson);
                $params['thumb'] = $arrJson;
            }
            unset($params['thumb1']);
            unset($params['alt']);
            // $params['thumb']      = $this->uploadThumb($params['thumb']);
            self::insert($this->prepareParams($params));
        }

        if ($options['task'] == 'edit-item') {

            if ($params['thumbCur']) {
                $newThumbCur = [];
                foreach ($params['thumbCur'] as $keyThumbCur => $valueThumbCur) {
                    $newThumbCur['image'][] = $valueThumbCur;
                    $newThumbCur['alt'][] = $params['altCur'][$keyThumbCur];
                }
            }
            $thumbDecode = json_decode($params['thumb_current'], true);
            $removeThumb = array_diff($thumbDecode['image'], $newThumbCur['image']);
            // $removeAlt = array_diff($thumbDecode['alt'], $newThumbCur['alt']);
            if (!empty($removeThumb)) {
                foreach ($removeThumb as $key1 => $curImg) {
                    $this->deleteThumb($curImg);
                }
            }
            if (!empty($params['thumb1'])) {
                foreach ($params['thumb1'] as $key => $value) {
                    // $thumbName        = Str::random(10) . '.' . $params['thumb1'][$key]->clientExtension() . '<br>';
                    $thumbName = $this->uploadMultiThumb($params['thumb1'][$key]);
                    $newThumbCur['image'][] = $thumbName;
                    $newThumbCur['alt'][] = $params['alt'][$key];
                }
                $params['thumb'] = $newThumbCur;
            } else {
                $tmp = [];
                foreach ($newThumbCur['image'] as $keyNewThumb => $valueNewThumb) {
                    $tmp['image'][] = $valueNewThumb;
                    $tmp['alt'][] = $newThumbCur['alt'][$keyNewThumb];
                }
                $params['thumb'] = $tmp;
            }
            $params['thumb'] = json_encode($params['thumb']);
            unset($params['thumb1']);
            unset($params['thumbCur']);
            unset($params['alt']);
            unset($params['altCur']);
            $price = explode('.', $params['price']);
            $params['price'] = implode('', $price);
            $params['updated_by']   = "hailan";
            $params['updated_at']      = date('Y-m-d H:i:s');
            self::where(['id' => $params['id']])->update($this->prepareParams($params));
        }

        if ($options['task'] == 'change-category') {
            $params['created_by'] = "hailan";
            $params['created_at']    = date('Y-m-d');
            self::where('id', $params['id'])->update(['product_category_id' => $params['currentCategory']]);
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        $this->table = 'products';
        if ($options['task'] == 'delete-item') {
            $item   = $this->getItem($params, ['task' => 'get-thumb']);
            $this->deleteThumb($item['thumb']);
            self::where('id', $params['id'])->delete();
        }
    }
    public function getPriceProductAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function getNameCategoryAttribute()
    {
        $depth = $this->depth <= 1 ? 0 : $this->depth - 1;
        return str_repeat('-----/ ', $depth) . $this->name;
    }
}
