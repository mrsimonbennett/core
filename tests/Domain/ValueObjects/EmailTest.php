<?php
namespace Domain\ValueObjects;

use FullRent\Core\ValueObjects\Person\Email;
use InvalidArgumentException;

/**
 * Class EmailTest
 * @package Domain\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class EmailTest extends \TestCase
{
    /**
     *
     */
    public function testCreatingEmail()
    {
        $email = $this->makeEmail();
        $this->assertEquals('simon@bennett.im', $email->getEmail());
    }

    /**
     *
     */
    public function testTwoEmails()
    {
        $email = $this->makeEmail();
        $email2 = $this->makeEmail();

        $this->assertTrue($email->equal($email2));
    }

    /**
     *
     */
    public function  testToString()
    {
        $email = $this->makeEmail();
        $this->assertSame('simon@bennett.im', (string)$email);
    }

    /**
     *
     */
    public function testInvalidEmail()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new Email('notemail');
    }

    /**
     * @return Email
     */
    protected function makeEmail()
    {
        return new Email('simon@bennett.im');
    }

}