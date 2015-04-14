<?php
namespace Domain\Application\ValueObjects;

use Assert\InvalidArgumentException;
use FullRent\Core\Application\ValueObjects\RejectReason;

/**
 * Class RejectReasonTest
 * @package Domain\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RejectReasonTest extends \TestCase
{
    /**
     *
     */
    public function testCreatingRejectReason()
   {
       $reject = new RejectReason('No Thanks');

       $this->assertEquals('No Thanks',$reject->getReason());
       $this->assertEquals('No Thanks',(string)$reject);
   }

    /**
     *
     */
    public function testCreatingRejectReasonWithInt()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $reject = new RejectReason(1);
    }
}