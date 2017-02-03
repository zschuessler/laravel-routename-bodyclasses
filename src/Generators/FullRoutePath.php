<?php

namespace Zschuessler\RouteToClass\Generators;

/**
 * Class FullRoutePath
 *
 * A route2class generator which converts a full route path to a single class, sans parameters.
 *
 * Example:
 *
 * ```
 * Route: /admin/product/12/edit
 *
 * Generates: admin-product-edit
 * ```
 *
 * Note that the product ID parameter is removed.
 *
 * @author Zachary Schuessler <zlschuessler@gmail.com>
 * @package Zschuessler\RouteToClass\Generators
 * @see https://github.com/zschuessler/laravel-route-to-class
 */
class FullRoutePath extends GeneratorAbstract
{
    public function generateClassName()
    {
        $route = $this->getRoute();

        if(!$route) // if this route is error page (404..)
            return 'error-404-page';

        $path = $route->getPath();
        
        // Return early if no route path exists (such as viewing homepage/index)
        if ('/' === $path) {
            return null;
        }

        // Remove route parameters. product_id is removed here: `controller/product/{product_id}`
        $className = preg_replace("/\{([^}]+)\}/", '', $path);

        // Remove characters that aren't alpha, numeric, or dashes
        $className = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $className);

        // Remove any double dashes from replace functions. eg: `product--name` should be `product-name`
        $className = strtolower(trim($className, '-'));

        // Replace special characters with a dash
        $className = preg_replace("/[\/_|+ -]+/", '-', $className);

        return $className;
    }
}
