<?php namespace FullRent\Core\Application\Storage;

use League\Flysystem\Config;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Filesystem\Filesystem;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\AdapterDecorator\DecoratorTrait;

/**
 * Class DocumentStore
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentStore implements AdapterInterface
{
    use DecoratorTrait;

    /** @var AdapterInterface */
    private $adapter;

    /** @var UserInterface */
    private $user;

    /**
     * DocumentStore constructor.
     *
     * @param AdapterInterface     $adapter
     * @param Guard            $auth
     */
    public function __construct(AdapterInterface $adapter, Guard $auth)
    {
        $this->user    = $auth->user();
        $this->base    = $adapter;
    }

    /**
     * @return AdapterInterface
     */
    protected function getDecoratedAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param string $path
     * @param string $contents
     * @param Config $config
     * @return array|false
     */
    public function write($path, $contents, Config $config)
    {
        $path = sprintf('%s/%s/%s', $this->company->getId(), $this->user->getId(), $path);

        return $this->getDecoratedAdapter()->write($path, $contents, $config);
    }
}