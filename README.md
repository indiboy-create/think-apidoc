## ThinkPHP-PanGu - 盘古ThinkPHP开源索引!
面向 ThinkPHP 的开源工程索引：组件、框架、服务与发布工具，按能力组织，持续整理。
仓库地址：**<https://github.com/indiboy-create/ThinkPHP-PanGu/>**
在线站点：**<https://indiboy-create.github.io/ThinkPHP-PanGu/>**

# think-apidoc

基于注解生成 API 文档的 ThinkPHP 8 扩展，移植自 [HGthecode/apidoc-php](https://github.com/HGthecode/apidoc-php)，仅保留 ThinkPHP 支持，并适配 ThinkPHP 8。

## 环境要求

- PHP >= 8.0
- ThinkPHP >= 8.0
- Composer

## 安装

```bash
composer require youvision/think-apidoc
```

安装完成后执行服务发现：

```bash
php think service:discover
```

如果项目没有自动加载服务，可在 `app/service.php` 中手动注册：

```php
return [
    \YouVision\ThinkApidoc\providers\ThinkPHP::class,
];
```

## 配置

将包内配置文件复制到项目配置目录：

```bash
cp vendor/youvision/think-apidoc/config/apidoc.php config/apidoc.php
```

未复制配置时，扩展会自动加载包内默认配置。

主要配置项：

| 配置项 | 说明 |
| --- | --- |
| `enable` | 文档总开关 |
| `apps` | 应用/版本列表，`path` 为控制器目录，`key` 为唯一标识 |
| `definitions` | 通用注解定义文件 |
| `auto_url` | 自动生成 URL 规则 |
| `auto_register_routes` | 根据注解自动注册接口路由 |
| `cache` | 文档缓存配置 |
| `auth` | 访问密码与 Token 配置 |
| `params` | 全局请求参数 |
| `responses` | 全局响应体 |
| `responses_status` | 全局响应状态码 |
| `route_prefix` | apidoc 路由前缀，默认 `/apidoc` |
| `database` | 数据表字段引用与代码生成器数据库配置 |
| `docs` | Markdown 文档菜单 |
| `generator` | 代码生成器配置 |
| `share` | 接口分享配置 |

多应用模式下，将 `apps[].path` 指向对应应用控制器目录，例如：

```php
'apps' => [
    [
        'title' => '后台接口',
        'path'  => 'app\admin\controller',
        'key'   => 'admin',
    ],
    [
        'title' => '前台接口',
        'path'  => 'app\index\controller',
        'key'   => 'index',
    ],
],
```

## 编写注解

```php
<?php

namespace app\controller;

use YouVision\ThinkApidoc\annotation\Param;
use YouVision\ThinkApidoc\annotation\Returned;
use YouVision\ThinkApidoc\annotation\Title;
use YouVision\ThinkApidoc\annotation\Url;

class User
{
    /**
     * 获取用户信息
     */
    #[Title('获取用户信息')]
    #[Url('/user/info')]
    #[Param(name: 'id', type: 'int', require: true, desc: '用户ID')]
    #[Returned(name: 'id', type: 'int', desc: '用户ID')]
    #[Returned(name: 'nickname', type: 'string', desc: '昵称')]
    public function info()
    {
        return json(['code' => 0, 'message' => 'ok', 'data' => []]);
    }
}
```

同时兼容注解写法：

```php
/**
 * @Apidoc\Title("获取用户信息")
 * @Apidoc\Url("/user/info")
 * @Apidoc\Param(name="id", type="int", require=true, desc="用户ID")
 * @Apidoc\Returned(name="nickname", type="string", desc="昵称")
 */
```

## 接口路由

默认注册以下接口：

| 路由 | 说明 |
| --- | --- |
| `/apidoc/config` | 文档配置 |
| `/apidoc/apiMenus` | 接口菜单 |
| `/apidoc/apiDetail` | 接口详情 |
| `/apidoc/docMenus` | Markdown 菜单 |
| `/apidoc/docDetail` | Markdown 内容 |
| `/apidoc/verifyAuth` | 密码验证 |
| `/apidoc/allApiMenus` | 全部接口菜单 |
| `/apidoc/createAllCache` | 生成全部缓存 |
| `/apidoc/cancelAllCache` | 清除全部缓存 |
| `/apidoc/generator` | 代码生成器 |
| `/apidoc/renderCodeTemplate` | 渲染代码模板 |
| `/apidoc/addApiShare` | 添加接口分享 |
| `/apidoc/getApiShareList` | 分享列表 |
| `/apidoc/getApiShareDetail` | 分享详情 |
| `/apidoc/deleteApiShare` | 删除分享 |
| `/apidoc/handleApiShareAction` | 执行分享操作 |

## 前端界面

本包只提供文档解析与接口数据，前端界面请使用 Apidoc UI，将构建产物放入项目 `public` 目录后访问对应页面即可。使用文档见 [https://docs.apidoc.icu](https://docs.apidoc.icu/)。

## 与上游的差异

- 仅保留 ThinkPHP 支持，移除 Laravel、Hyperf、Webman 适配代码
- 适配 ThinkPHP 8 的服务、路由、语言包 API
- 命名空间调整为 `YouVision\ThinkApidoc`
- 修复缓存目录、分享列表、目录扫描等问题
- 移除依赖缺失的 Swagger 导出功能

## 许可

MIT