<?php

namespace App\Models;

use App\Models\AdminModel;
use Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductAttributeModel extends AdminModel
{
    public $settings;
    public function __construct()
    {
        $this->table               = 'product_attributes';
        $this->folderUpload        = 'product attribute';
        // $this->fieldSearchAccepted = ['id', 'username', 'email', 'fullname'];
        $this->crudNotAccepted     = ['_token'];
        $this->guarded = [];
    }

    public function changePrice($params = null)
    {
        $price = str_replace('.', '', $params['price']);
        $price = explode(',', $price);
        $price = implode('', $price);
        self::where('attribute_value_id', $params['idVariant'])->update(['price' => $price]);
    }

    public function listVariant($id = null)
    {
        $result = null;
        $result = self::select('name', 'price', 'attribute_value_id')->where('product_id', $id)->get()->toArray();
        return $result;
    }
}
