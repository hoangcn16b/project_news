<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ContactModel extends AdminModel
{
    public function __construct()
    {
        $this->table               = 'contact';
        $this->folderUpload        = 'contact';
        $this->crudNotAccepted     = ['_token'];
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-new-contact') {
            self::insert($this->prepareParams($params));
        }
        // if ($options['task'] == 'change-status') {
        //     $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
        //     self::where('id', $params['id'])->update(['status' => $status]);
        // }

        // if ($options['task'] == 'add-item') {
        //     $params['created_by'] = "hailan";
        //     $params['created']    = date('Y-m-d');
        //     self::insert($this->prepareParams($params));
        // }

        // if ($options['task'] == 'edit-item') {
        //     $params['modified_by']   = "hailan";
        //     $params['modified']      = date('Y-m-d');
        //     self::where('id', $params['id'])->update($this->prepareParams($params));
        // }
    }
}
