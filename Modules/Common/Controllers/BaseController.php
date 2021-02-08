<?php

namespace Modules\Common\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Common\Traits\RestfulResponse;

class BaseController extends Controller
{
    use RestfulResponse;
}
