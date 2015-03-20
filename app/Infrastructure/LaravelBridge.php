<?php
namespace FullRent\Core\Application\Infrastructure;

use Mitch\LaravelDoctrine\LaravelDoctrineServiceProvider;
use ReflectionClass;

/**
 * Class DoctrineBridge
 * @package FullRent\Infrastructure\Laravel5Bridge
 * @author  Simon Bennett <simon@bennett.im>
 */
final class LaravelBridge extends LaravelDoctrineServiceProvider
{
    public $namespace = "laravel-doctrine";
    public $vendor = "mitchellvanw";

    public function package()
    {
        $this->loadViewsFrom($this->namespace, $this->guessPackagePath() . '/views');
        $this->loadTranslationsFrom($this->namespace, $this->guessPackagePath() . '/lang');
    }
    protected function guessPackagePath() {
        $path = (new ReflectionClass(get_parent_class()))->getFileName();

        return realpath(dirname($path).'/../../');
    }
}