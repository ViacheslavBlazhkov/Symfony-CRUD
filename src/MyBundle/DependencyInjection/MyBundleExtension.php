<?php
// src/MyBundle/DependencyInjection/MyBundleExtension.php

namespace App\MyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class MyBundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Some code
    }
}
