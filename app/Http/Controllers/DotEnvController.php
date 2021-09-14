<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DotEnvController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param $env_fields
     * @param $env_file
     *
     * @return void
     */
    public function storeEnvFile($env_fields, $env_file)
    {
        $fp = fopen(base_path($env_file), 'w');

        fwrite($fp, '# setup mail server set on ' . date('Y-m-d H:i') . PHP_EOL);
        foreach ($env_fields as $field) {
            fwrite($fp, $field . '=' . $this->makeEnvValue(request($field)) . PHP_EOL);
        }
        fclose($fp);

//        Artisan::call('config:clear');
//        Artisan::call('cache:clear');
//        shell_exec('rm bootstrap/cache/config.php');

    }

    public function makeEnvValue($value)
    {
        if (is_null($value)) return NULL;
        if (is_bool(env($value))) return env($value) ? 'true' : 'false';
        return preg_match('/\s/', $value) ? '"' . $value . '"' : $value;
    }

    public function changeenv($enf_file, $key, $new_value)
    {
        $path = base_path($enf_file);
        if (file_exists($path)) {
            $current_value = $this->makeEnvValue(env($key));
            $new_value = $this->makeEnvValue($new_value);
//            dump($enf_file . ': ' . $key . ' - ' . $current_value . ' - ' . $new_value);
            file_put_contents($path, str_replace("$key=" . $current_value, "$key=" . $new_value, file_get_contents($path)));
        }
        Artisan::call('config:clear');

    }

}
