<?php namespace FullRent\Core\Documents\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class DocumentType
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentType implements Serializable
{
    /** @var string */
    private $type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->type;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'document_type' => $this->type,
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data['document_type']);
    }
}