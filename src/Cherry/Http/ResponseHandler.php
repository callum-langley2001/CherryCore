<?php

declare(strict_types=1);

namespace Cherry\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseHandler
 * 
 * @package Cherry
 * @subpackage Http
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class ResponseHandler
{
    /**
     * Creates a new Response object
     *
     * @return Response|null
     */
    public function handler(): ?Response
    {
        if (!isset($response)) {
            $response = new Response();
            if ($response) return $response;
        }
        return null;
    }
}
