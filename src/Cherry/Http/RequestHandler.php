<?php

declare(strict_types=1);

namespace Cherry\Http;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestHandler
 * 
 * @package Cherry
 * @subpackage Http
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class RequestHandler
{
    /**
     * Creates a new Request object
     *
     * @return Request|null
     */
    public function handler(): ?Request
    {
        if (!isset($request)) {
            $request = new Request();
            if ($request) {
                $create = $request->createFromGlobals();

                if ($create) return $create;
            }
        }
        return null;
    }
}