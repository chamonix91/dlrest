<?php

namespace DL\BackofficeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DLBackofficeBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
