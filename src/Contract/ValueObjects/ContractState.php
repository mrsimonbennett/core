<?php
namespace FullRent\Core\Contract\ValueObjects;

final class ContractState 
{
    private $state;

    /**
     * @param $state
     */
    public function __construct($state )
    {
        $this->state = $state;
    }
}