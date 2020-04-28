@setup
    $healthUrl = 'https://invoice.monitorbase.com/login';
@endsetup

@servers(['jump' => $user . '@10.10.100.100', 'lander' => '10.10.50.154', 'local' => '127.0.0.1'])

@story('deploy')
    agents
    jump
    healthCheck
@endstory

@task('agents', ['on' => 'local'])
    eval $(ssh-agent)
    ssh-add -k
@endtask

@task('jump', ['on' => 'jump'])
    php artisan down
    ssh -t 10.10.50.154
    cd /var/www/invoice
    git pull origin mb-master
    composer install --optimize-autoloader --no-dev
    npm install
    php artisan migrate
    npm run prod
    php artisan route:cache
    php artisan view:cache
    php artisan up
@endtask

@task('healthCheck', ['on' => 'local'])
    @php
    $headers = get_headers($healthUrl);
    $response = $headers[0];
    @endphp
    echo {{ $healthUrl }} - {{ $response }}
@endtask