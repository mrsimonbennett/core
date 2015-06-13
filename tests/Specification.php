<?php

/**
 * Class Specification
 * @author Simon Bennett <simon@bennett.im>
 */
abstract class Specification extends \TestCase
{

    /**
     * @var string Class name of the aggregate
     */
    public $subjectType;

    public $subject;

    /**
     *
     */
    protected $caughtException;
    /**
     * @var array
     */
    protected $producedEvents = [];
    /**
     * Current state
     *
     * @var
     */
    protected $aggregate;

    /**
     * Given events
     *
     * @return array
     */
    abstract public function given();

    /**
     * @return Command
     */
    abstract public function when();

    /**
     * @return mixed
     * @internal param $repository
     */
    abstract public function handler($repository);

    public function tearDown()
    {
        $tests[] = $this->getName();
    }

    public function setUp()
    {
        $this->id = uuid();
        try {
            /** @var \Broadway\Domain\AggregateRootInterface $subject */
            $subjectType = $this->subjectType;

            $events = $this->given();

            if (count($events) > 0) {
                $this->subject = new $subjectType;
                $this->subject = $subjectType->initializeState($events);
            }

            $this->handler()->handle($this->when());

            $this->producedEvents = $this->subject->getUncommittedChanges();
        } catch (Exception $e) {
            $this->caughtException = $e;
        }
    }
}