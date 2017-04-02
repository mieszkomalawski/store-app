<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * ProjectUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/product')) {
            // create_product
            if ($pathinfo === '/product') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_create_product;
                }

                return array (  'service' => 'create_product_controller',  'method' => 'createProduct',  'format' => 'json',  '_route' => 'create_product',);
            }
            not_create_product:

            // search_product
            if ($pathinfo === '/product') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_search_product;
                }

                return array (  'service' => 'search_product_controller',  'method' => 'searchProduct',  'format' => 'json',  '_route' => 'search_product',);
            }
            not_search_product:

        }

        // index_page
        if ($pathinfo === '/') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_index_page;
            }

            return array (  'service' => 'index_controller',  'method' => 'viewIndex',  'format' => 'html',  '_route' => 'index_page',);
        }
        not_index_page:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
