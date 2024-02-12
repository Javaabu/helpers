<?php
namespace Javaabu\Helpers\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AppException extends HttpException
{
    private $name;

    /**
     * @param string $statusCode
     * @param string $name
     * @param null $message
     */
    public function __construct(string $statusCode, $name = 'AppError', $message = null)
    {
        $this->name = $name;

        parent::__construct($statusCode, $message);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  Request
     * @return JsonResponse|RedirectResponse
     */
    public function render($request)
    {
        if (expects_json($request)) {
            return $this->sendJsonResponse();
        }

        return $this->sendHttpResponse();
    }

    /**
     * Send json response
     */
    protected function sendJsonResponse()
    {
        return response()->json(['message' => $this->getMessage()], $this->getStatusCode());
    }

    /**
     * Send http response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function sendHttpResponse()
    {
        return back()->with('alerts', [
            [
                'text' => __($this->getMessage()),
                'type' => 'danger',
                'title' => __('Error!'),
            ]
        ]);
    }

}
