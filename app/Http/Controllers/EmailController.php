<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_TransportException;

class EmailController extends Controller
{

    protected array $env_fields = [
        'MAIL_HOST',
        'MAIL_PORT',
        'MAIL_USERNAME',
        'MAIL_PASSWORD',
        'MAIL_ENCRYPTION',
        'MAIL_FROM_ADDRESS',
        'MAIL_FROM_NAME',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function testMailServer()
    : string
    {
        dump(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION'));
        try {
            $transport = new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION'));
            $transport->setUsername(env('MAIL_USERNAME'));
            $transport->setPassword(env('MAIL_PASSWORD'));
            $mailer = new Swift_Mailer($transport);
            $mailer->getTransport()->start();
            return json_encode(['status' => true]);
        } catch (Swift_TransportException | Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse
    {
        Artisan::call('config:clear');

        foreach ($this->env_fields as $field) {
            (new DotEnvController)->changeenv('.env', $field, request($field));
            (new DotEnvController)->changeenv('app.env', $field, request($field));
        }
        return back();
    }

}
