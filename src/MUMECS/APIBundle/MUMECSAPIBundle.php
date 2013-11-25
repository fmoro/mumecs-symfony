<?php

namespace MUMECS\APIBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use MUMECS\APIBundle\DependencyInjection\Security\Factory\WsseFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MUMECSAPIBundle extends Bundle {
    public function build(ContainerBuilder $container) {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseFactory());
    }
}
