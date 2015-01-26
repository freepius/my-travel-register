<?php

namespace Freepius\Provider\HttpCache;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\Store as BaseStore;

class Store extends BaseStore
{
    /**
     * The cache key is generated from URI and Locale.
     */
    protected function generateCacheKey(Request $request)
    {
        return 'md'.$request->getLocale().hash('sha256', $request->getUri());
    }
}
