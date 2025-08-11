
<?php

use App\Models\Course;
use App\Models\Policie;
use App\Models\WebConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


function get_config()
{
    return WebConfig::find(1);
}
function get_policies()
{
    return Policie::where('active', 1)
                        ->orderBy('created_at', 'desc')
                        ->get();
}

