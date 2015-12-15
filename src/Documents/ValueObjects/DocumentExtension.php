<?php namespace FullRent\Core\Documents\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class DocumentExtension
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentExtension implements Serializable
{
    /** @var string */
    private $ext;

    /**
     * @param string $ext
     */
    public function __construct($ext)
    {
        $this->ext = $ext;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->ext;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'document_ext' => $this->ext,
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data['document_ext']);
    }

}