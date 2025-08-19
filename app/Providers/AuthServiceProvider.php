<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\WebConfig;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Đăng ký các policy ở trên để Laravel biết model nào dùng policy nào
        $this->registerPolicies();

        /**
         * View::composer() dùng để chia sẻ dữ liệu cho view.
         * Nghĩa là bất cứ khi nào view 'users.layout.web-config' được render,
         * thì nó sẽ tự động được truyền biến $config.
         * 
         * Ở đây, $config = WebConfig::first() => lấy bản ghi đầu tiên trong bảng web_configs.
         */
        View::composer('users.layout.web-config', function ($view) {
            $view->with('config', WebConfig::first());
        });

        // Có thể khai báo thêm Gate (quyền hạn) ở đây nếu cần
    }
}