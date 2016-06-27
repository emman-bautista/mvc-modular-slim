<?php 


// Sample event listener for login :))
$container->events->listen('auth.login', function($user_id) use($container){
    $logger = $container->logger;
    $logger->info('auth.login FIRED!');
    $user = \App\Models\User::find($user_id);
    $logger->info($user);

    return true;
});

// Sample event listener for logout :))
$container->events->listen('auth.logout', function($user_id) use($container){
    $logger = $container->logger;
    $logger->info('auth.logout FIRED!');
    $user = \App\Models\User::find($user_id);
    $logger->info($user);

    return true;
});



