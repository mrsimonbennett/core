<?php
namespace FullRent\Core\Application\Infrastructure;

/**
 * Class WriteEventsToElasticSearch
 * @package FullRent\Core\Application\Infrastructure
 * @author Simon Bennett <simon@bennett.im>
 */
final class WriteEventsToElasticSearch
{
    private $es;

    public function __construct()
    {
        /*$this->es = KeenIOClient::factory([
                                              'projectId' => '555f855696773d33037d0b71',
                                              'writeKey'  => '32580fb6402ad166ca38d56cda2df08bc56c6774518f9d214acd3e82f395c9f013e19e26a7eb08ba96c64ad71bb38c356e676348e0c1f1a53d7cde31b9c4a53b840d4e56b237e461451284b08fc4fc67cc53e00a719a16edd2503224836f66bcb40ca01d79be3e3703f82cac801d6e0e',
                                              'readKey'   => '9bbed2b30572890cb257021889d30a6a3478623724367712cb7aa793bdb54a0db5bc3db199d853796a6409b6a977d9a2d9cedce82f9d785eb5c682fd0943b4fc3e76b282e3f27c03eb2fcab380a41d6e8d656f83b58af3c36e48eb06650aeebad04daabf1371fcbfc8ee9543e91137f4'
                                          ]);
    */
    }

    /**
     * @param $e
     * @hears("FullRent.Core.*")
     */
    public function saveEventToElasticSearch($e)
    {
        //$this->es->addEvent(str_replace('FullRent.Core.', '', str_replace('\\', '', get_class($e))), $e->serialize());
    }
}