<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\CoreBundle\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

/**
 * Class ExceptionController
 */
class ExceptionController extends CommonController
{
    /**
     * {@inheritdoc}
     */
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        $class = $exception->getClass();

        //ignore authentication exceptions
        if (strpos($class, 'Authentication') === false) {
            $env            = $this->factory->getEnvironment();
            $currentContent = $this->getAndCleanOutputBuffering($request->headers->get('X-Php-Ob-Level', -1));
            $layout         = $env == 'prod' ? 'Error' : 'Exception';
            $code           = $exception->getStatusCode();
            if ($code === 0) {
                //thrown exception that didn't set a code
                $code = 500;
            }

            if ($request->get('prod')) {
                $layout = 'Error';
            }

            $anonymous    = $this->factory->getSecurity()->isAnonymous();
            $baseTemplate = 'MauticCoreBundle:Default:slim.html.php';
            if ($anonymous) {
                if ($templatePage = $this->factory->getTheme()->getErrorPageTemplate($code)) {
                    $baseTemplate = $templatePage;
                }
            }

            $template   = "MauticCoreBundle:{$layout}:{$code}.html.php";
            $templating = $this->factory->getTemplating();
            if (!$templating->exists($template)) {
                $template = "MauticCoreBundle:{$layout}:base.html.php";
            }

            $statusText = isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '';

            $url = $request->getRequestUri();
            $urlParts = parse_url($url);

            return $this->delegateView(array(
                'viewParameters'  => array(
                    'baseTemplate'   => $baseTemplate,
                    'status_code'    => $code,
                    'status_text'    => $statusText,
                    'exception'      => $exception,
                    'logger'         => $logger,
                    'currentContent' => $currentContent,
                    'isPublicPage'   => $anonymous
                ),
                'contentTemplate' => $template,
                'passthroughVars' => array(
                    'error' => array(
                        'code'      => $code,
                        'text'      => $statusText,
                        'exception' => ($env == 'dev') ? $statusText : '',
                        'trace'     => ($env == 'dev') ? $exception->getTrace() : ''
                    ),
                    'route' => $urlParts['path']
                )
            ));
        }
    }

    /**
     * @param int     $startObLevel
     *
     * @return string
     */
    protected function getAndCleanOutputBuffering($startObLevel)
    {
        if (ob_get_level() <= $startObLevel) {
            return '';
        }

        Response::closeOutputBuffers($startObLevel + 1, true);

        return ob_get_clean();
    }
}
