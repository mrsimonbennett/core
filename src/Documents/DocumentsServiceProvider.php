<?php namespace FullRent\Core\Documents;

use FullRent\Core\Infrastructure\FullRentServiceProvider;

/**
 * Class DocumentsServiceProvider
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentsServiceProvider extends FullRentServiceProvider
{
    /**
     * @return array
     */
    public function getEventSubscribers()
    {
        return [
            Listeners\DocumentsMysqlListener::class,
        ];
    }

    public function register()
    {
        $this->app->bind(Repository\DocumentRepository::class, Repository\SmoothDocumentRepository::class);
    }
}