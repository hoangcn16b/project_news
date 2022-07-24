<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\News\ContactRequest as MainRequest;

use App\Models\ContactModel;
use App\Helpers\Feed;

class ContactController extends Controller
{
    private $pathViewController = 'news.pages.contact.';  // slider
    private $controllerName     = 'contact';
    private $params             = [];
    private $model;

    public function __construct()
    {
        $this->model = new ContactModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        view()->share('title', 'Liên hệ');
        return view($this->pathViewController .  'index', []);
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();
            $notify = "Cảm ơn bạn đã gửi thông tin liên hệ. Chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất.";
            $this->model->saveItem($params, ['task'=> 'add-new-contact']);
            return redirect()->route($this->controllerName . '/index')->with("zvn_notify", $notify);
        }
    }
}
