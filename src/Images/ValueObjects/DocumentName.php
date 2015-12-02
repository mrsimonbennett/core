<?php namespace FullRent\Core\Images\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class DocumentName
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentName implements Serializable
{
    /** @var string */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'document_name' => $this->name,
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data['document_name']);
    }
}