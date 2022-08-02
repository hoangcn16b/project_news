<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\News\ContactRequest as MainRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactModel;
use App\Helpers\Feed;
use App\Mail\TestMail;
use App\Http\Controllers\SendMailController;
class ContactController extends Controller
{
    private $pathViewController = 'news.pages.contact.';  // slider
    private $controllerName     = 'contact';
    private $params             = [];
    private $model;

    public function __construct()
    {

        view()->share('controllerName', $this->controllerName);
        view()->share('title', 'Liên hệ');
    }

    public function index(Request $request)
    {
        return view($this->pathViewController .  'index', []);
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $this->model = new ContactModel();
            $this->params = $request->all();
            $this->params['created']    = date('Y-m-d H:i:s');
            $notify = "Cảm ơn bạn đã gửi thông tin liên hệ. Chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất.";
            $this->model->saveItem($this->params, ['task' => 'home-add-new-contact']);
            $mailSend = new SendMailController();
            $this->params['subject'] = 'Thông báo từ Website News69!';
            $this->params['view'] = 'emails.contact_email';
            $mailSend->sendMail($this->params);
            // Mail::send('emails.contact_email', ['infoContact' => $this->params], function ($message) {
            //     $message->to($this->params['email'])->subject('Thông báo từ Website News69 - Đã nhận được thông tin liên hệ của bạn!');
            // });
            return redirect()->route($this->controllerName . '/index')->with("zvn_notify", $notify);
        }
    }
}
