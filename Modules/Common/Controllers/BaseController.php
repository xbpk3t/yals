<?php

namespace Modules\Common\Controllers;

use Illuminate\Routing\Controller;
use Modules\Common\Traits\RestfulResponse;

class BaseController extends Controller
{
    use RestfulResponse;
}
