<?php

namespace App\Exceptions;

use Config;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendErrorToSlack($exception);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function renderHttpException(HttpExceptionInterface $e)
    {
        $status = $e->getStatusCode();
        return response()->view("errors.default", ['e' => $e]);
        /** 
        if (!view()->exists("errors.{$status}")) {
            return response()->view("errors.default", ['e' => $e]);
        } else {
            return response()->view("errors.{$status}", ['exception' => $e], $status, $e->getHeaders());
        }
        */
    }

    public function sendErrorToSlack(Exception $e)
    {
        try {
            $url = Config::get('services.slack.exception_webhook');
        } catch(Exception $e) {
            $url = "";
        }
        
        if ($url) {
            $parsedUrl = parse_url($url);

            $this->client = new \GuzzleHttp\Client([
                'base_uri' => $parsedUrl['scheme'] . '://' . $parsedUrl['host'],
            ]);

            $payload = json_encode(
                [
                    'text' => get_class($e) . ': ' . $e->getMessage() . ' (' . $e->getCode() . ')',
                    'username' => 'Exception EtuPAY',
                    'icon_emoji' => ':rotating_light:',
                    'attachments' => [
                        [
                            'title' => 'File',
                            'text' => $e->getFile() . ':' . $e->getLine(),
                            'color' => '#d80012',
                        ],
                        [
                            'title' => 'Trace',
                            'text' => $e->getTraceAsString(),
                            'color' => '#d80012',
                        ],
                    ],
                ]);
            $response = $this->client->post($parsedUrl['path'], ['body' => $payload]);
            return $response;
        }
    }
}
