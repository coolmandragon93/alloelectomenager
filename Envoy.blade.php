@servers(['web' => 'millionspare.com'])

@task('deploy')
    cd /var/www/millionspare.com/dev
    git pull origin master
@endtask
