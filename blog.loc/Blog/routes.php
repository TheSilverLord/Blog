<?php

return
[
    '~^articles/add$~' => [\Blog\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/edit$~' => [\Blog\Controllers\ArticlesController::class, 'edit'],
    '~^users/register$~' => [\Blog\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\Blog\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\Blog\Controllers\UsersController::class, 'logout'],
    '~^users/admin$~'=> [\Blog\Controllers\UsersController::class, 'admin'],
    '~^$~' => [\Blog\Controllers\MainController::class, 'main'],
];
?>