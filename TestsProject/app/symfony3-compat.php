<?php

if (Symfony\Component\HttpKernel\Kernel::MAJOR_VERSION >= 3) {
    $container->loadFromExtension(
        'framework',
        array(
            'assets' => array(),
        )
    );
}
