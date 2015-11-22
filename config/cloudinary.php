<?php

return [
    'cloudName'  => getenv('CLOUDINARY_CLOUD'),
    'baseUrl'    => sprintf('http://res.cloudinary.com/%s', getenv('CLOUDINARY_CLOUD')),
    'secureUrl'  => sprintf('https://res.cloudinary.com/%s', getenv('CLOUDINARY_CLOUD')),
    'apiBaseUrl' => sprintf('https://api.cloudinary.com/v1_1/%s', getenv('CLOUDINARY_CLOUD')),
    'apiKey'     => getenv('CLOUDINARY_API_KEY'),
    'apiSecret'  => getenv('CLOUDINARY_API_SECRET'),
];