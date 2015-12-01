<?php namespace FullRent\Core\Documents\Queries;

/**
 * Class FindDocumentsByPropertyId
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class FindDocumentsByPropertyId
{
    /** @var string */
    private $propertyId;

    /**
     * @param string $propertyId
     */
    public function __construct($propertyId)
    {
        $this->propertyId = $propertyId;
    }

    /**
     * @return string
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }
}