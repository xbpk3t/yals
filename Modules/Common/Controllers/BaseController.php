<?php

namespace Modules\Common\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Common\Traits\RestfulResponse;

class BaseController extends Controller
{
    use RestfulResponse;
}
