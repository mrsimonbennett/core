<?php
if(!function_exists('uuid'))
{
    function uuid()
    {
        return (string)\Rhumsaa\Uuid\Uuid::uuid4();
    }
}