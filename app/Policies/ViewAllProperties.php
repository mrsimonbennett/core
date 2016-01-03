<?php

namespace FullRent\Core\Application\Policies;


final class ViewAllProperties extends BasePolicy
{

    public function check($user)
    {
        return $this->getUser($user)->role == 'landlord';
    }
}
