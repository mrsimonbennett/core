<?php namespace FullRent\Core\User\Queries;

/**
 * Class FindUserSettings
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class FindUserSettings
{
    /** @var string */
    private $userId;

    /**
     * @param string $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function userId()
    {
        return $this->userId;
    }
}