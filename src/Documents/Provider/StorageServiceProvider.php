<?php namespace FullRent\Core\Documents\Provider;

use League\Flysystem\Filesystem;
use League\Flysystem\AdapterInterface;
use Illuminate\Support\ServiceProvider;
use GrahamCampbell\Flysystem\FlysystemManager;
use FullRent\Core\Documents\Storage\DocumentStore;

/**
 * Class StorageServiceProvider
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class StorageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(DocumentStore::class)
                  ->needs(AdapterInterface::class)
                  ->give(function () {
                      /** @var FlysystemManager $fs */
                      $fs = $this->app->make(FlysystemManager::class);
                      return $fs->connection('awss3')->getAdapter();
                  });
    }
}