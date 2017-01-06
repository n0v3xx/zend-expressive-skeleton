<?php
namespace App\Action;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HelloAction
{
    private $router;

    private $template;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $query  = $request->getQueryParams();
        $target = isset($query['target']) ? $query['target'] : 'World';
        $target = htmlspecialchars($target, ENT_HTML5, 'UTF-8');

        $response->getBody()->write(sprintf(
            '<h1>Hello, %s!</h1>',
            $target
        ));

        return new HtmlResponse(
            $this->template->render('app::hello-world', ['target' => $target])
        );
    }
}