<?php namespace FullRent\Core\Documents\Queries;

/**
 * Class FindDeletedDocumentsByPropertyId
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class FindDeletedDocumentsByPropertyId
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
    public function propertyId()
    {
        return $this->propertyId;
    }
}