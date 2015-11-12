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

    /**
     * @var
     */
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
     * @param $repository
     */
    abstract public function handler($repository);

    /**
     * @return string
     */
    abstract public function subject();

    /**
     * @return string
     */
    abstract public function repository();


    public function tearDown()
    {
        $tests[] = $this->getName();
    }

    public function setUp()
    {
        $this->id = uuid();
        try {

            $events = $this->given();

            $repo = $this->getMockBuilder($this->repository())->getMock();


            $subject = $this->subject();
            $this->subject = new $subject;

            if (count($events) > 0) {
                $this->subject->initializeState($events);
            }
            $repo->method('load')->willReturn($this->subject);
            $repo->method('save')->will($this->returnCallback(function ($subject) {
                $this->subject = $subject;
            }));

            $this->handler($repo)->handle($this->when());

            $events = [];

            foreach ($this->subject->getUncommittedEvents() as $event) {
                $events[] = $event->getPayload();
            }
            $this->producedEvents = $events;


        } catch (Exception $e) {
            throw $e;
            $this->caughtException = $e;
        }
    }

    function Repocallback()
    {
        $args = func_get_args();
        // ...
        dd($args);
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->producedEvents;
    }
}
