<?php

namespace Src;

function slimConfiguration(): \Slim\Container
{
    $configuration = [
        'settings' => [
            'displayErrorDetails' => true,
            'determineRouteBeforeAppMiddleware' => true
        ],
    ];
    return new \Slim\Container($configuration);
}