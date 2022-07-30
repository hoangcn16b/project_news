<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SettingModel extends AdminModel
{
    public function __construct()
    {
        $this->table               = 'setting';
        $this->folderUpload        = 'setting';
        $this->fieldSearchAccepted = ['id', 'username', 'email', 'fullname'];
        $this->crudNotAccepted     = ['_token', 'avatar_current', 'task_general_setting'];
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == "admin-setting-general") {
            $result = $this->select('value')->where('key_value', 'setting-general')->first();
            $result = $result->attributes['value'];
            $result = json_decode($result, true);
            // $result['hotline'] = json_decode($result['hotline'], true)[0]['value'];
        }

        return $result;
    }



    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'add-item') {
            $params['created_by'] = "hailan";
            $params['created']    = date('Y-m-d');
            $params['avatar']      = $this->uploadThumb($params['avatar']);
            $params['password']    = md5($params['password']);
            self::insert($this->prepareParams($params));
        }

        if ($options['task'] == 'change-general-setting') {
    
            if (!empty($params['logo'])) {
                $this->deleteLogo($params['avatar_current'] ?? '');
                $params['logo'] = $this->uploadLogo($params['logo']);
                // $params['logo'] =  $nameLogo . '.' . $extension;
            } else {
                $params['logo'] = $params['avatar_current'];
            }
            unset($params['_token']);
            unset($params['avatar_current']);
            unset($params['task_general_setting']);
            $result = null;
            $result['value'] = json_encode($params);
            self::where('key_value', 'setting-general')->update($this->prepareParams($result));
        }
    }
}
