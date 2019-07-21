<?php

    namespace netdjw\LoremIpsum;

    use Illuminate\Support\ServiceProvider;

    class LoremIpsumServiceProvider extends ServiceProvider {

        public function boot()
        {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        }

        public function register()
        {
            //
        }
    }
