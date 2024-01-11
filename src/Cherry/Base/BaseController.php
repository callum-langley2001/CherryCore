<?php

declare(strict_types=1);

namespace Cherry\Base;

use Cherry\Base\Exception\BaseLogicException;
use Cherry\Base\BaseView;

/**
 * Class BaseController
 * 
 * @package Cherry
 * @subpackage Base
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class BaseController
{
    /**
     * The route parameters.
     * 
     * @var array $routeParams The route parameters.
     */
    protected array $routeParams;

    /**
     * The Twig instance.
     * 
     * @var object $twig The Twig instance.
     */
    private object $twig;

    /**
     * Constructs a new instance of the class.
     *
     * @param array $routeParams The route parameters.
     */
    public function __construct(array $routeParams)
    {
        $this->routeParams = $routeParams;
        $this->twig = new BaseView();
    }

    /**
     * Renders a template with the given context using Twig.
     *
     * @param string $template The path to the template file.
     * @param array $context An associative array of variables to pass to the template.
     * @throws BaseLogicException If the Twig instance is null.
     * @return mixed The rendered template.
     */
    public function render(string $template, array $context = [])
    {
        if ($this->twig === null) {
            throw new BaseLogicException('You cannot render without a Twig instance.');
        }

        return $this->twig->getTemplate($template, $context);
    }
}
