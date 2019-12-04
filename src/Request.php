<?php

namespace WebTheory\GuctilityBelt;

use Psr\Http\Message\ServerRequestInterface;

class Request
{
    /**
     *
     */
    public static function var(ServerRequestInterface $request, $param)
    {
        $request = static::find($request);

        return $request[$param] ?? null;
    }

    /**
     *
     */
    public static function has(ServerRequestInterface $request, $param): bool
    {
        $request = static::find($request);

        return isset($request[$param]);
    }

    /**
     *
     */
    protected static function find(ServerRequestInterface $request)
    {
        switch ($request->getMethod()) {
            case 'get' || 'GET':
                $request = $request->getQueryParams();
                break;

            default:
                $request = $request->getParsedBody();
                break;
        }

        return (array) $request;
    }
}
