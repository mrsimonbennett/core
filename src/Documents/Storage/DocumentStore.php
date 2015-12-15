<?php namespace FullRent\Core\Documents\Storage;

use Illuminate\Http\Request;
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

    /** @var Request */
    private $request;

    /**
     * DocumentStore constructor.
     *
     * @param AdapterInterface     $adapter
     */
    public function __construct(AdapterInterface $adapter, Request $request)
    {
        $this->adapter = $adapter;
        $this->request = $request;
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
        $path = sprintf(
            '%s/%s/%s',
            $this->request->request->get('company_id'),
            $this->request->request->get('user_id'),
            $path
        );

        \Log::debug(sprintf('Writing to location [%s]', $path));

        return $this->getDecoratedAdapter()->write($path, $contents, $config);
    }
}