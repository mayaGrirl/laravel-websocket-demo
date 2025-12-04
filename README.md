<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 说明
使用laravel 11, php8.2，主要依赖laravel的reverb做长连接，依赖laravel/sanctum做登录的token验证，绑定登录用户

## 使用
composer依赖安装完毕后 ,依次启动命令如下：
- php artisan serve #启动laravel服务
- php artisan reverb:start #启动官方WebSocket的服务
- php artisan queue:work  #启动工作队列运行
- php artisan test:push-loop 1 #启动自写的推送测试任务
- http://127.0.0.1:8000/index.html #访问页面

## 成功如图
![img.png](img.png)

## laravel支持的websocket的方式
安装方式（Laravel 11 适配）

Laravel 11 对应的版本是：
- 方案 1
✔ beyondcode/laravel-websockets:^2.0（官方维护，支持 PHP8+）

composer require beyondcode/laravel-websockets
发布配置：

php artisan vendor:publish --tag=websockets-config
php artisan vendor:publish --tag=websockets-migrations
php artisan migrate

启动 WebSocket：

php artisan websockets:serve


这是 最推荐的方案。

- 方案 2：Laravel Reverb（Laravel 官方 WebSocket 解决方案）

⚠️ Laravel 11 已经内置官方 Reverb 支持，这是 Laravel 官方最近发布的 WebSocket 系统（2024 年发布）。

优点：

Laravel 官方原生支持

不需要第三方扩展包

和 Laravel Broadcast、Echo 一体化

安装 Reverb（Laravel 11 官方 WebSocket）
php artisan install:broadcasting

开启 Reverb：

php artisan reverb:start

Reverb 是最近的新工具，非常稳定，也没有 beyondcode 的历史兼容问题。
👉 目前该系统选择这个

## 目前只跑win系统,linux系统注意配置nginx反向代理
server {
listen 80;
server_name your-domain.com;

    root /var/www/websocket-demo/public;
    index index.php;

    # Laravel
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # WebSocket 转发 Reverb 8080
    location /reverb {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
        proxy_http_version 1.1;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}

## 线上环境建议开Supervisor守护进程
[program:reverb]

# 配置文件/etc/supervisor/conf.d/reverb.conf
``command=php /var/www/websocket-demo/artisan reverb:start
user=www-data
autostart=true
autorestart=true
redirect_stderr=true
stdout_logfile=/var/log/reverb.log``

# 相关使用命令

`supervisorctl reread`
`supervisorctl update`
`supervisorctl start reverb`

