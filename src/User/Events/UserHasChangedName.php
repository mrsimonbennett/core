<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Name;

/**
 * Class UserHasChangedName
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserHasChangedName 
{
    /**
     * @var Name
     */
    private $name;

    /**
     * @param Name $name
     */
    public function __construct(Name $name)
    {
        $this->name = $name;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

}