<?php

// Router.php

namespace Routing;

class Router
{
    /** @var array The defined routes for different HTTP methods */
    private $routes;

    /**
     * Router constructor.
     *
     * @param array $routes The array of defined routes.
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Find the appropriate handler for the given HTTP method and parameters.
     *
     * @param string $method The HTTP method (GET, POST, PUT, DELETE, etc.).
     * @param mixed $params The parameters or route path to match against.
     *
     * @return string|null The handler method to be executed or null if no match is found.
     */
    public function findHandler($method, $params)
    {
        // Iterate through the defined routes for the given HTTP method
        foreach ($this->routes[$method] as $pattern => $handler) {
            // Use regular expression to match the route pattern against the provided parameters
            if (preg_match('#^' . $pattern . '$#', $params, $matches)) {
                // Remove the full match from the matches array
                array_shift($matches);
                return $handler; // Return the matched handler method
            }
        }

        return null; // Return null if no matching route is found
    }
}
