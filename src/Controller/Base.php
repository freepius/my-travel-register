<?php

namespace App\Controller;

use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Summary :
 *  -> __construct
 *  -> connect
 *
 *  -> GLOBAL ACTIONS :
 *      => map
 *
 *  -> ADMIN ACTIONS :
 *      => admin
 *      => cacheClear
 *
 *  -> TECHNICAL ACTIONS :
 *      => login
 *      => manageErrors
 */
class Base implements ControllerProviderInterface
{
    public function __construct(\Freepius\Silex\Application $app)
    {
        $this->app = $app;
    }

    public function connect(\Silex\Application $app)
    {
        $ctrl = $app['controllers_factory'];

        // Global actions
        $ctrl->get('/'   , [$this, 'map']);
        $ctrl->get('/map', [$this, 'map']);

        // Admin routes
        $ctrl->get('/admin'            , [$this, 'admin']);
        $ctrl->get('/admin/cache-clear', [$this, 'cacheClear']);

        // Technical routes
        $ctrl->get('/login', [$this, 'login']);
        $app->error([$this, 'manageErrors']);

        return $ctrl;
    }


    /***************************************************************************
     * GLOBAL ACTIONS
     **************************************************************************/

    /**
     * CACHE: public ; validation
     */
    public function map(Request $request)
    {
        $response = $this->app['http_cache.mongo']->response(
            $request, 'base.map', ['media', 'register']
        );
        if ($response->isNotModified($request)) { return $response; }

        $registerRepo = $this->app['model.repository.register'];

        return $this->app->render('base/map.html.twig', [
            'register_entries_js' => $registerRepo->getGeoJsFile(),
        ], $response);
    }


    /***************************************************************************
     * ADMIN ACTIONS
     **************************************************************************/

    /**
     * Dashboard for admin actions
     */
    public function admin()
    {
        return $this->app->render('base/admin.html.twig');
    }

    public function cacheClear()
    {
        $app = $this->app;

        $fs = new Filesystem();

        // Empty the cache dir
        $fs->remove($app['path.cache']);
        $fs->mkdir ($app['path.cache']);

        // Empty the public register dir
        $app['model.repository.register']->clearCacheDir();

        $this->app->addFlash('success', $this->app->trans('admin.cacheCleared'));

        return $this->app->redirect('/admin');
    }


    /***************************************************************************
     * TECHNICAL ACTIONS
     **************************************************************************/

    public function login(Request $request)
    {
        return $this->app->render('base/login.html.twig',
        [
            'error' => $this->app['security.last_error']($request),
        ]);
    }

    public function manageErrors(\Exception $e, Request $request, $code)
    {
        if ($this->app['debug']) { return; }

        // Hack to don't make shout the "isGranted" function, in "layout.html.twig".
        $this->app['security']->setToken(
            new \Symfony\Component\Security\Core\Authentication\Token\AnonymousToken('', '')
        );

        // Case of an ajax request => return a "simple text" response
        if ($request->isXmlHttpRequest()) {
            return new Response($e->getMessage(), $code);
        }

        // Other cases => return a html response
        return $this->app->render('base/error.html.twig',
        [
            'message' => $e->getMessage(),
            'code'    => $code,
        ]);
    }
}
