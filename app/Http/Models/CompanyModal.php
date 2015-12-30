<?php
namespace FullRent\Core\Application\Http\Models;

/**
 * Class CompanyModal
 * @package FullRent\Core\Application\Http\Models
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyModal
{

    public static function fromStdClass($data)
    {
        $company = new static();

        foreach ($data as $key => $value) {
            $company->{$key} = $value;
        }

        return $company;
    }
}