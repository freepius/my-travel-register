<?php

namespace Freepius\Provider\HttpCache;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MongoNoCache extends MongoCache
{
    public function response(Request $request, $key, array $dependencies = [])
    {
        return new Response();
    }
}
