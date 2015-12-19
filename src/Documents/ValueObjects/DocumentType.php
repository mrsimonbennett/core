<?php namespace FullRent\Core\Documents\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Documents\Exception\DocumentTypeNotFound;

/**
 * Class DocumentType
 *
 * @method static DocumentType Contract()
 * @method static DocumentType GasCertificate()
 * @method static DocumentType ElectricCertificate()
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentType implements Serializable
{
    /** @var string[] */
    private static $types = [
        'contract',
        'gas-cert',
    ];

    /** @var string */
    private $documentType;

    /**
     * DocumentType constructor.
     *
     * @param string $documentType
     */
    public function __construct($documentType)
    {
        if (!in_array($documentType, static::$types)) {
            throw new DocumentTypeNotFound("The document type {$documentType} was not found");
        }

        $this->documentType = $documentType;
    }

    /**
     * @param string $name
     * @param        $args
     * @return static
     */
    public static function __callStatic($name, $args)
    {
        return new static($name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->documentType;
    }

    /**
     * @return array
     */
    public static function types()
    {
        return static::$types;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['document_type' => $this->documentType];
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