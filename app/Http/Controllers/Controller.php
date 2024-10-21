<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="News Aggregator",
 *      description="News aggregator provides a RESTful API that pulls articles from various sources and provides endpoints for a frontend application to consume.",
 *      @OA\Contact(
 *          email="engr.saud94@gmail.com",
 *          name="Engineer Saud",
 *          url="https://www.linkedin.com/in/Engineersaud"
 *      )
 * ),
 * @OA\SecurityScheme(
 *        type="apiKey",
 *        in="header",
 *        securityScheme="bearerAuth",
 *        name="Authorization",
 *        description="Enter your bearer token in the format **Bearer &lt;token>**"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}//end class
