<?php
require_once '../../vendor/autoload.php';


use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


function append_to_file(&$file, $name, $value) {
    fwrite($file, "$name=$value\n");
}



if ($_POST) {
    $envPath = dirname(dirname(__DIR__  )) . DIRECTORY_SEPARATOR . '.env';
    $envExamplePath = dirname(dirname(__DIR__  )) . DIRECTORY_SEPARATOR . '.env.example';

    file_put_contents($envPath, '');

    if (!file_exists( $envPath ) && !copy($envExamplePath, $envPath)) {
        echo '<code>نمیتوانیم فایل .env را ایجاد کنیم.</code>';
        exit(1);
    }

    $app = require_once __DIR__.'/../../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );


    $file = fopen($envPath,"a");

    append_to_file($file, 'APP_NAME', $_POST['APP_NAME']);
    append_to_file($file, 'APP_ENV', $_POST['APP_ENV']);
    append_to_file($file, 'APP_KEY', '');
    append_to_file($file, 'APP_DEBUG', $_POST['APP_DEBUG']);
    append_to_file($file, 'APP_URL', $_POST['APP_URL']);

    fwrite( $file, PHP_EOL );

    append_to_file($file, 'LOG_CHANNEL', $_POST['LOG_CHANNEL']);

    fwrite( $file, PHP_EOL );

    append_to_file($file, 'DB_CONNECTION', $_POST['DB_CONNECTION']);
    append_to_file($file, 'DB_HOST', $_POST['DB_HOST']);
    append_to_file($file, 'DB_PORT', $_POST['DB_PORT']);
    append_to_file($file, 'DB_DATABASE', $_POST['DB_DATABASE']);
    append_to_file($file, 'DB_USERNAME', $_POST['DB_USERNAME']);
    append_to_file($file, 'DB_PASSWORD', $_POST['DB_PASSWORD']);

    fwrite( $file, PHP_EOL );

    append_to_file($file, 'REDIS_HOST', $_POST['REDIS_HOST']);
    append_to_file($file, 'REDIS_PASSWORD', $_POST['REDIS_PASSWORD']);
    append_to_file($file, 'REDIS_PORT', $_POST['REDIS_PORT']);

    fwrite( $file, PHP_EOL );

    append_to_file($file, 'MAIL_DRIVER', $_POST['MAIL_DRIVER']);
    append_to_file($file, 'MAIL_HOST', $_POST['MAIL_HOST']);
    append_to_file($file, 'MAIL_PORT', $_POST['MAIL_PORT']);
    append_to_file($file, 'MAIL_USERNAME', $_POST['MAIL_USERNAME']);
    append_to_file($file, 'MAIL_PASSWORD', $_POST['MAIL_PASSWORD']);
    append_to_file($file, 'MAIL_ENCRYPTION', $_POST['MAIL_ENCRYPTION']);

    fwrite( $file, PHP_EOL );

    append_to_file($file, 'AWS_ACCESS_KEY_ID', $_POST['AWS_ACCESS_KEY_ID']);
    append_to_file($file, 'AWS_SECRET_ACCESS_KEY', $_POST['AWS_SECRET_ACCESS_KEY']);
    append_to_file($file, 'AWS_DEFAULT_REGION', $_POST['AWS_DEFAULT_REGION']);
    append_to_file($file, 'AWS_BUCKET', $_POST['AWS_BUCKET']);

    fwrite( $file, PHP_EOL );

    append_to_file($file, 'PUSHER_APP_ID', $_POST['PUSHER_APP_ID']);
    append_to_file($file, 'PUSHER_APP_KEY', $_POST['PUSHER_APP_KEY']);
    append_to_file($file, 'PUSHER_APP_SECRET', $_POST['PUSHER_APP_SECRET']);
    append_to_file($file, 'PUSHER_APP_CLUSTER', $_POST['PUSHER_APP_CLUSTER']);

    fwrite( $file, PHP_EOL );

    append_to_file($file, 'MIX_PUSHER_APP_KEY', $_POST['MIX_PUSHER_APP_KEY']);
    append_to_file($file, 'MIX_PUSHER_APP_CLUSTER', $_POST['MIX_PUSHER_APP_CLUSTER']);

    Artisan::call('key:generate');

    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    Artisan::call('migrate:install');
    Artisan::call('migrate:refresh', [
            '--force' => true
    ]);
    if ($_POST['SEED'] === '1'){
        Artisan::call('db:seed');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel installer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/installer/style.css">
</head>
<body>

<div class="container  h-100">
    <div class="row h-100 justify-content-center align-items-center mt-5">
        <div class="col-sm-6">
            <form action="" method="post">
                <div class="page d-none">
                    <h4>Config</h4>

                    <div class="form-group">
                        <label for="APP_NAME">Application Name</label>
                        <input type="text" name="APP_NAME" id="APP_NAME" class="form-control" value="Laravel">
                    </div>

                    <div class="form-group">
                        <label for="APP_ENV">Application ENV</label>
                        <input type="text" name="APP_ENV" id="APP_ENV" class="form-control" value="local">
                    </div>

                    <div class="form-group">
                        <label for="APP_DEBUG">Application Debug</label>
                        <select name="APP_DEBUG" id="APP_DEBUG" class="form-control">
                            <option value="true">true</option>
                            <option value="false">false</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="APP_URL">Application Url</label>
                        <input type="text" name="APP_URL" id="APP_URL" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <label for="LOG_CHANNEL">Log Channel</label>
                        <input type="text" value="stack" class="form-control" id="LOG_CHANNEL" name="LOG_CHANNEL">
                    </div>

                </div>
                <div class="page d-none">
                    <h4>Database</h4>

                    <div class="form-group">
                        <label for="DB_CONNECTION">Database Connection</label>
                        <input type="text" name="DB_CONNECTION" id="DB_CONNECTION" class="form-control" value="mysql">
                    </div>

                    <div class="form-group">
                        <label for="DB_HOST">Database Host</label>
                        <input type="text" name="DB_HOST" id="DB_HOST" class="form-control" value="localhost">
                    </div>

                    <div class="form-group">
                        <label for="DB_PORT">Database Port</label>
                        <input type="text" name="DB_PORT" id="DB_PORT" class="form-control" value="3306">
                    </div>

                    <div class="form-group">
                        <label for="DB_DATABASE">Database Name</label>
                        <input type="text" name="DB_DATABASE" id="DB_DATABASE" class="form-control" value="data_tables">
                    </div>


                    <div class="form-group">
                        <label for="DB_USERNAME">Database Username</label>
                        <input type="text" name="DB_USERNAME" id="DB_USERNAME" class="form-control" value="root">
                    </div>

                    <div class="form-group">
                        <label for="DB_PASSWORD">Database Password</label>
                        <input type="password" name="DB_PASSWORD" id="DB_PASSWORD" class="form-control" value="100">
                    </div>
                </div>
                <div class="page d-none">
                    <h4>Mail</h4>

                    <div class="form-group">
                        <label for="MAIL_DRIVER">Mail Driver</label>
                        <input type="text" name="MAIL_DRIVER" id="MAIL_DRIVER" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="MAIL_HOST">Mail Host</label>
                        <input type="text" name="MAIL_HOST" id="MAIL_HOST" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="MAIL_PORT">Mail Port</label>
                        <input type="text" name="MAIL_PORT" id="MAIL_PORT" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="MAIL_USERNAME">Mail Username</label>
                        <input type="text" name="MAIL_USERNAME" id="MAIL_USERNAME" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="MAIL_PASSWORD">Mail Password</label>
                        <input type="text" name="MAIL_PASSWORD" id="MAIL_PASSWORD" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="MAIL_ENCRYPTION">Mail Encryption</label>
                        <input type="text" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION" class="form-control">
                    </div>
                </div>
                <div class="page d-none">
                    <div class="form-group">
                        <label for="BROADCAST_DRIVER">Broadcast Driver</label>
                        <input type="text" class="form-control" id="BROADCAST_DRIVER" name="BROADCAST_DRIVER">
                    </div>
                    <div class="form-group">
                        <label for="CACHE_DRIVER">Cache Driver</label>
                        <input type="text" class="form-control" id="CACHE_DRIVER" name="CACHE_DRIVER">
                    </div>
                    <div class="form-group">
                        <label for="QUEUE_CONNECTION">Queue Connection</label>
                        <input type="text" class="form-control" id="QUEUE_CONNECTION" name="QUEUE_CONNECTION">
                    </div>
                    <div class="form-group">
                        <label for="SESSION_DRIVER">Session Driver</label>
                        <input type="text" class="form-control" id="SESSION_DRIVER" name="SESSION_DRIVER">
                    </div>
                    <div class="form-group">
                        <label for="SESSION_LIFETIME">Session Life Time</label>
                        <input type="text" class="form-control" id="SESSION_LIFETIME" name="SESSION_LIFETIME">
                    </div>
                </div>
                <div class="page d-none">
                    <div class="form-group">
                        <label for="REDIS_HOST">Redis Host</label>
                        <input id="REDIS_HOST" type="text" name="REDIS_HOST" value="127.0.0.1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="REDIS_PASSWORD">Redis Password</label>
                        <input id="REDIS_PASSWORD" type="text" name="REDIS_PASSWORD" value="null" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="REDIS_PORT">Redis Port</label>
                        <input id="REDIS_PORT" type="text" name="REDIS_PORT" value="6379" class="form-control">
                    </div>
                </div>
                <div class="page d-none">
                    <div class="form-group">
                        <label for="AWS_ACCESS_KEY_ID">AWS_ACCESS_KEY_ID</label>
                        <input id="AWS_ACCESS_KEY_ID" type="text" name="AWS_ACCESS_KEY_ID" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="AWS_SECRET_ACCESS_KEY">AWS_SECRET_ACCESS_KEY</label>
                        <input id="AWS_SECRET_ACCESS_KEY" type="text" name="AWS_SECRET_ACCESS_KEY"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="AWS_DEFAULT_REGION">AWS_DEFAULT_REGION</label>
                        <input id="AWS_DEFAULT_REGION" type="text" name="AWS_DEFAULT_REGION" value="us-east-1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="AWS_BUCKET">AWS_BUCKET</label>
                        <input id="AWS_BUCKET" type="text" name="AWS_BUCKET" value="us-east-1" class="form-control">
                    </div>
                </div>
                <div class="page d-none">
                    <div class="form-group">
                        <label for="PUSHER_APP_ID">PUSHER_APP_ID</label>
                        <input id="PUSHER_APP_ID" type="text" name="PUSHER_APP_ID" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="PUSHER_APP_KEY">PUSHER_APP_KEY</label>
                        <input id="PUSHER_APP_KEY" type="text" name="PUSHER_APP_KEY"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="PUSHER_APP_SECRET">PUSHER_APP_SECRET</label>
                        <input id="PUSHER_APP_SECRET" type="text" name="PUSHER_APP_SECRET" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="PUSHER_APP_CLUSTER">PUSHER_APP_CLUSTER</label>
                        <input id="PUSHER_APP_CLUSTER" type="text" name="PUSHER_APP_CLUSTER" value="mt1" class="form-control">
                    </div>
                </div>
                <div class="page d-none">
                    <div class="form-group">
                        <label for="MIX_PUSHER_APP_KEY">MIX_PUSHER_APP_KEY</label>
                        <input id="MIX_PUSHER_APP_KEY" type="text" name="MIX_PUSHER_APP_KEY"  value="${PUSHER_APP_KEY}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="MIX_PUSHER_APP_CLUSTER">MIX_PUSHER_APP_CLUSTER</label>
                        <input id="MIX_PUSHER_APP_CLUSTER" type="text" name="MIX_PUSHER_APP_CLUSTER"  value="${PUSHER_APP_CLUSTER}" class="form-control">
                    </div>
                </div>
                <div class="page d-none">
                    <div class="form-group">
                        <label for="SEED">Database seed</label>
                        <select name="SEED" id="SEED" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-group text-center">
                    <a href="#" class="btn btn-secondary d-none" id="previous-btn">Previous</a>
                    <a href="#" class="btn btn-primary" id="next-btn">Next</a>
                    <button class="btn btn-success d-none" id="submit-btn" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="/installer/main.js"></script>
</body>
</html>