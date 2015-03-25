<?php
namespace FullRent\Core\Contract\ValueObjects;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ContractMinimalPeriod
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractMinimalPeriod implements SerializableInterface
{
    /**
     * @var DateTime
     */
    private $start;
    /**
     * @var DateTime
     */
    private $end;
    /**
     * @var bool
     */
    private $continue;

    /**
     * @param DateTime $start
     * @param DateTime $end
     * @param bool $continue Does contract continue after period
     */
    public function __construct(DateTime $start, DateTime $end, $continue)
    {
        $this->start = $start;
        $this->end = $end;
        $this->continue = $continue;
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return boolean
     */
    public function isContinue()
    {
        return $this->continue;
    }


    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(DateTime::deserialize($data['start']),
                          DateTime::deserialize($data['start']),
                          $data['continues']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'start'     => $this->start->serialize(),
            'end'       => $this->end->serialize(),
            'continues' => $this->continue,
        ];
    }
}