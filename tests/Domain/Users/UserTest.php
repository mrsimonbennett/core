<?php
namespace Domain\Users;

use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\User\Events\UsersEmailHasChanged;
use FullRent\Core\User\User;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class UserTest
 * @package Domain\Users
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserTest extends \TestCase
{
    /**
     *
     */
    public function testCreatingUser()
    {
        $user = $this->registerUser();

        $events = $user->getUncommittedEvents()->getIterator();

        $this->assertCount(1, $events);
        $this->assertInstanceOf(UserRegistered::class, $events[0]->getPayload());
    }

    public function testUpdatingUsersEmail()
    {
        $user = $this->registerUser();

        $user->changeEmail(new Email('simon@test.com'));
        $events = $user->getUncommittedEvents()->getIterator();

        $this->assertCount(2, $events);
        $this->assertInstanceOf(UsersEmailHasChanged::class,$events[1]->getPayload());
    }
    /**
     * @return User
     */
    protected function registerUser()
    {
        $user = User::registerUser(UserId::random(), new Name("Mr Simon Bennett", 'Simon'),
            new Email('simon@bennett.im'), new Password('test'));

        return $user;
    }
}