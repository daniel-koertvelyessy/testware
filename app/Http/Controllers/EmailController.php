<?php

namespace App\Http\Controllers;

use Artisan;
use Dotenv\Exception\ExceptionInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool
     */
    public function testMailServer()
    : bool
    {

        /*      Mail::send([
                  ''
              ]);*/

        return true;
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
    $res['MAIL_HOST']=$this->changeenv('MAIL_HOST', $request->MAIL_HOST);
    $res['MAIL_PORT']=$this->changeenv('MAIL_PORT', $request->MAIL_PORT);
    $res['MAIL_USERNAME']=$this->changeenv('MAIL_USERNAME', $request->MAIL_USERNAME);
    $res['MAIL_PASSWORD']=$this->changeenv('MAIL_PASSWORD', $request->MAIL_PASSWORD);
    $res['MAIL_ENCRYPTION']=$this->changeenv('MAIL_ENCRYPTION', $request->MAIL_ENCRYPTION);
    $res['MAIL_FROM_ADDRESS']=$this->changeenv('MAIL_FROM_ADDRESS', $request->MAIL_FROM_ADDRESS);
    $res['MAIL_FROM_NAME']=$this->changeenv('MAIL_FROM_NAME', $request->MAIL_FROM_NAME);
    dump($res);
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return back();
}

private function changeenv($key, $value)
{
    $path = base_path('app.env');

    if (is_bool(env($key))) {
        $old = env($key) ? 'true' : 'false';
    } else {
        $old = env($key);
    }
    if (file_exists($path)) {
        return file_put_contents($path, str_replace("$key=" . $old, "$key=" . $value, file_get_contents($path)));
    } else {
        return false;
    }
}

    /**
     * Display the specified resource.
     *
     * @return false|Response|string
     */
    public function show()
    {
        return json_encode([
            'MAIL_HOST'         => getenv('MAIL_HOST'),
            'MAIL_PORT'         => getenv('MAIL_PORT'),
            'MAIL_USERNAME'     => getenv('MAIL_USERNAME'),
            'MAIL_PASSWORD'     => getenv('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION'   => getenv('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => getenv('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME'    => getenv('MAIL_FROM_NAME')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
