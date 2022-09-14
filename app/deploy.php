<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'shelter-admin-api');

// Project repository
set('repository', 'git@shelter-admin-api.github.com:sharecrest/shelter-admin-api.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ['vendor']);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
inventory('hosts.yml');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');

// Change Release Path
after('deploy:update_code', 'change_dir');

task('change_dir', function () {
    set('release_path', get('release_path') . '/' . 'app');
    run('cd {{release_path}}');
});

// Copy .env file
before('deploy:shared','deploy:copy:env');

task('deploy:copy:env', function () {
    run("cp {{release_path}}/.env.{{stage}} {{deploy_path}}/shared/.env");
});

// php-fpm restart
after('success', 'php-fpm:restart');

task('php-fpm:restart', function() {
    run('sudo service php-fpm restart');
});
