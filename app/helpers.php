
<?php

use App\Models\Course;
use App\Models\WebConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


function get_config()
{
    return WebConfig::find(1);
}

