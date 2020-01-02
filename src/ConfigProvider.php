<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace MezzioSentry;

use MezzioSentry\Listener\Factory\LoggerSentryListenerFactory;
use MezzioSentry\Listener\LoggerSentryListener;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Zend\Stratigility\Middleware\ErrorHandler as ZendErrorHandler;
use Zend\ProblemDetails\ProblemDetailsMiddleware as ZendProblemDetailsMiddleware;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;
use MezzioSentry\Listener\LoggerSentryListenerDelegator;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'sentry' =>  $this->getConfig(),
        ];
    }

    public function getDependencies(): array
    {
        $dependencies = [
            'factories' => [
                LoggerSentryListener::class => LoggerSentryListenerFactory::class,
            ],
            'delegators' => [
                ErrorHandler::class => [
                    LoggerSentryListenerDelegator::class,
                ],
            ],
        ];

        if (class_exists(ZendErrorHandler::class)) {
            $dependencies['delegators'][ZendErrorHandler::class] = [
                LoggerSentryListenerDelegator::class,
            ];
        }

        if (class_exists(ZendProblemDetailsMiddleware::class)) {
            $dependencies['delegators'][ZendProblemDetailsMiddleware::class] = [
                LoggerSentryListenerDelegator::class,
            ];
        }

        if (class_exists(ProblemDetailsMiddleware::class)) {
            $dependencies['delegators'][ProblemDetailsMiddleware::class] = [
                LoggerSentryListenerDelegator::class,
            ];
        }

        return $dependencies;
    }

    public function getConfig(): array
    {
        return [
            'dsn' => @$_SERVER['sentry_dsn'],
            'development-environment' => false,
        ];
    }
}
