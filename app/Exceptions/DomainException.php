<?php namespace FullRent\Core\Application\Exceptions;

use Log;
use DomainException as PhpDomainException;

/**
 * Class DomainException
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
abstract class DomainException extends PhpDomainException
{
    /**
     * DomainException constructor.
     *
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        Log::debug(sprintf('[Debug] Exception thrown: [%s]', get_class($this)));
    }
}
