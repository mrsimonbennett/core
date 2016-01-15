<?php
namespace FullRent\Core\Projections\User;

use FullRent\Core\User\Events\UserAmendedName;
use FullRent\Core\User\Events\UsersEmailHasChanged;
use Illuminate\Contracts\Cache\Repository;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class UserRedisClear
 * @package FullRent\Core\Projections\User
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserRedisClear implements Subscriber, Projection
{
    /** @var Repository */
    private $cache;

    /**
     * UserRedisClear constructor.
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function whenUsersEmailHasChanged(UsersEmailHasChanged $e)
    {
        $this->cache->forget('user-' . (string)$e->getId());
    }

    public function whenUserAmendedName(UserAmendedName $e)
    {
        $this->cache->forget('user-' . (string)$e->getId());

    }

    /**
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], array['methodName2']]
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            UsersEmailHasChanged::class => ['whenUsersEmailHasChanged'],
            UserAmendedName::class      => ['whenUserAmendedName']
        ];
    }
}