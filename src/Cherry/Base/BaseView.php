<?php

declare(strict_types=1);

namespace Cherry\Base;

use Twig\Extension\DebugExtension;
use Twig\FilesystemLoader;
use Twig\Environment;

/**
 * Class BaseView
 * 
 * @package Cherry
 * @subpackage Base
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class BaseView
{
    /**
     * Retrieves a template and renders it with the provided context using Twig.
     *
     * @param string $template The name of the template file to retrieve.
     * @param array $context An array of data to pass to the template for rendering.
     * @return mixed The rendered template.
     */
    public function getTemplate(string $template, array $context = []): mixed
    {
        static $twig;

        if ($twig === null) {
            $loader = new FilesystemLoader('templates', TEMPLATES_PATH);
            $twig = new Environment($loader, []);
            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new CherryTwigExtension());
        }

        return $twig->render($template, $context);
    }
}