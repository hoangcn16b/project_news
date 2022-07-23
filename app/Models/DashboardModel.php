<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DashboardModel extends AdminModel
{

    public function listItems($options = null)
    {
        $query = null;
        if ($options['task'] == 'dashboard-list-items') {
            $query = DB::select("SELECT
                (SELECT COUNT(id) FROM user) AS User, 
                (SELECT COUNT(id) FROM category) AS Category,
                (SELECT COUNT(id) FROM article) AS Article,
                (SELECT COUNT(id) FROM slider) AS Slider,
                (SELECT COUNT(id) FROM rss) AS Rss,
                (SELECT COUNT(id) FROM menu) AS Menu
            ");
        }
        
        return $query;
    }
}

