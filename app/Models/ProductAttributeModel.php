<?php

namespace App\Models;

use App\Models\AdminModel;
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
    }

    public function attribute()
    {
        return $this->belongsTo(AttributeModel::class, 'attribute_id');
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;

        $query = $this->select('product_id', 'attribute_id', 'value')->get();
        // foreach ($query as $key => $value) {
        //     $result[$key] = json_decode($value, true);
        // }

        dd($query);
        return $result;
    }

    public function getSettings($params = null, $options = null)
    {
        $result = null;
        $this->getSettings();
        $result = $this->settings;
        if ($options['task'] == "admin-setting-general") {
            $result = $result['setting_general'];
        }
        if ($options['task'] == "admin-setting-email-account") {
            $result = $result['setting_email'];
        }
        if ($options['task'] == "admin-setting-email-bcc") {
            $result = $result['setting_bcc'];
        }
        if ($options['task'] == "admin-setting-social") {
            $result['facebook'] = $result['setting_social'];
            $result['youtube'] = $result['setting_video'];
        }
        return $result;
    }


    public function saveItem($params = null, $options = null)
    {
    }

    public function productAttr($params = null, $condition = null)
    {
        $result = null;
        $result =  self::with('attribute')->select('id', 'product_id', 'attribute_id', 'value')->get()->toArray();
        // if ($params['id']) {
        //     $result = $result->where('product_id', $params['id']);
        // }
        // $result = $result->get();
        return $result;
    }
}
