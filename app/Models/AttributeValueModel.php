<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AttributeValueModel extends AdminModel
{
    public function __construct()
    {
        $this->table               = 'attribute_values';
        $this->guarded = [];
    }

    public function deleteAttrValue($params = null, $options = null)
    {
        $attributeId = $params['id'];
        $result = self::select()->where('attribute_id', $attributeId)->delete();
    }
}
