<?php

class Psr4Autoloader
{
    private $paths;

    public function add(string $prefix, string $directory): self
    {
        $this->paths[] = [
            'prefix' => $prefix,
            'directory' => $directory
        ];

        return $this;
    }

    public function register()
    {
        spl_autoload_register(function ($class) {
            foreach ($this->paths as $reg) {
                $prefixlen = strlen($reg['prefix']);
                if (substr($class, 0, $prefixlen) === $reg['prefix']) {
                    $class = str_replace('\\', '/', $class);
                    $file = $reg['directory'] . substr($class, $prefixlen).'.php';
                    if (file_exists($file)) {
                        require $file;
                    }
                }
            }
        });
    }
}

$autoloader = new Psr4Autoloader();
$autoloader
    ->add('Nfq\\Academy\\Homework\\', __DIR__.'/src/')
    ->register();
