<?php

// routes.php

namespace Routing;

return [
    'GET'    => [
        'items' => 'getAllItems',
        'items/(\d+)' => 'getItem',
    ],
    'POST'   => [
        'items' => 'createItem',
    ],
    'PUT'    => [
        'items/(\d+)' => 'updateItem',
    ],
    'DELETE' => [
        'items/(\d+)' => 'deleteItem',
    ],
];
