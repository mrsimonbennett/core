<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Name;
use SmoothPhp\Contracts\EventSourcing\Event;

/**
 * Class UserHasChangedName
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserHasChangedName implements Event
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