<?php
namespace FullRent\Core\Contract;

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