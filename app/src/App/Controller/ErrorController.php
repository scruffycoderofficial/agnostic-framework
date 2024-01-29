<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

/**
 * Class ErrorController
 */
class ErrorController
{
    public function exception(FlattenException $exception): Response
    {
        return new Response(sprintf('ControllerError: %s', $exception->getMessage()), $exception->getStatusCode());
    }
}
