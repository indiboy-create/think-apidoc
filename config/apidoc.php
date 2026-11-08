<?php
return [
    // 文档总开关，false 时所有 apidoc 接口返回“文档已关闭”
    'enable' => true,

    // 文档标题，显示在左上角与首页
    'title' => 'Apidoc',

    // 文档描述，显示在首页
    'desc' => '',

    // 文档的应用/版本配置，支持多应用、多版本嵌套（items）
    'apps' => [
        [
            // 应用标题
            'title' => 'Api接口',
            // 控制器目录，相对项目根目录；多应用模式示例：app\admin\controller
            // 支持字符串或字符串数组
            'path' => 'app\controller',
            // 应用唯一标识，多个应用不可重复
            'key' => 'api',
            // 选配：只解析指定控制器（相对 path 的类名），为空则解析 path 下全部控制器
            'controllers' => [],
            // 选配：应用访问密码，设置后访问该应用需要输入密码
            // 'password' => '123456',
            // 选配：应用级分组，可多级嵌套
            'groups' => [],
            // 选配：应用级全局请求参数，结构同下方 params
            'params' => [],
            // 选配：应用级全局响应体，结构同下方 responses
            'responses' => [],
            // 选配：应用级响应状态码，结构同下方 responses_status
            'responses_status' => [],
            // 选配：应用级调试事件，结构同下方 debug_events
            'debug_events' => [],
            // 选配：应用级解析排除的控制器类名
            'filter_controllers' => [],
            // 选配：应用级解析排除的目录
            'filter_dirs' => [],
            // 选配：关闭该应用的在线调试
            'notDebug' => false,
        ],
    ],

    // 通用注解定义文件，供 @Param(ref="xxx") 等引用
    'definitions' => 'app\common\controller\Definitions',

    // 接口未使用 @Apidoc\Url 时自动生成 URL 的规则
    'auto_url' => [
        // 类名首字母规则：lcfirst=首字母小写，ucfirst=首字母大写
        'letter_rule' => 'lcfirst',
        // 自动生成的 URL 前缀
        'prefix' => '',
        // 自动生成 URL 时忽略的命名空间片段
        'filter_keys' => ['app', 'controller'],
        // 选配：对每个 URL 片段做自定义处理，回调参数为片段字符串
        // 'handle_key' => function ($key) { return $key; },
        // 选配：完全自定义 URL，回调参数为类名、方法名、默认 URL
        // 'custom' => function ($className, $methodName, $url) { return $url; },
    ],

    // 是否根据注解自动注册接口路由，开启后无需在 route 目录手动注册
    'auto_register_routes' => false,

    // 文档缓存配置
    'cache' => [
        // 是否开启缓存
        'enable' => false,
        // 缓存目录名，位于 runtime 目录下
        'folder' => 'apidoc',
    ],

    // 访问权限认证
    'auth' => [
        // 是否启用密码验证
        'enable' => false,
        // 全局访问密码
        'password' => '123456',
        // 密码加密盐
        'secret_key' => 'apidoc#hg_code',
        // 授权访问后的有效期，单位秒
        'expire' => 24 * 60 * 60,
    ],

    // 全局请求参数
    'params' => [
        // 全局请求 Header
        // name=字段名，type=类型，require=是否必须，default=默认值，desc=描述，md=Markdown 说明
        'header' => [
            ['name' => 'Authorization', 'type' => 'string', 'require' => true, 'desc' => '身份令牌Token'],
        ],
        // 全局请求 Query，结构同上
        'query' => [],
        // 全局请求 Body，结构同上
        'body' => [],
    ],

    // 全局响应体
    'responses' => [
        // 成功响应体
        'success' => [
            ['name' => 'code', 'desc' => '业务代码', 'type' => 'int', 'require' => 1],
            ['name' => 'message', 'desc' => '业务信息', 'type' => 'string', 'require' => 1],
            // main=true 表示接口 @Returned 参数挂载到该节点下
            ['name' => 'data', 'desc' => '业务数据', 'main' => true, 'type' => 'object', 'require' => 1],
        ],
        // 异常响应体
        'error' => [
            ['name' => 'code', 'desc' => '业务代码', 'type' => 'int', 'require' => 1, 'md' => '/docs/HttpError.md'],
            ['name' => 'message', 'desc' => '业务信息', 'type' => 'string', 'require' => 1],
        ],
    ],

    // 全局响应状态码
    'responses_status' => [
        [
            'name' => '200',
            'desc' => '请求成功',
        ],
        [
            'name' => '401',
            'desc' => '登录令牌无效',
            'contentType' => '',
        ],
    ],

    // apidoc 路由前缀，默认 /apidoc
    // 最终地址为：/apidoc/config、/apidoc/apiMenus、/apidoc/apiDetail 等
    'route_prefix' => '/apidoc',

    // 默认作者
    'default_author' => '',

    // 默认请求类型
    'default_method' => 'GET',

    // 是否允许跨域访问 apidoc 接口
    'allowCrossDomain' => false,

    // 解析时忽略的非 Apidoc 注解名
    // 例如注释中存在 @key test 且未 use 对应注解类时，可在此加入 'key'
    'ignored_annitation' => [],

    // 解析时忽略的控制器方法名
    'ignored_methods' => [],

    // 全局关闭在线调试
    'notDebug' => false,

    // 解析时排除的控制器类名
    'filter_controllers' => [],

    // 解析时排除的目录
    'filter_dirs' => [],

    // 数据库配置，用于数据表字段引用和代码生成器
    'database' => [
        // 表前缀，留空时自动读取 database.php 中当前连接的 prefix
        'prefix' => '',
        // 数据表编码
        'charset' => 'utf8mb4',
        // 数据表引擎
        'engine' => 'InnoDB',
    ],

    // Markdown 文档配置，可多级嵌套
    // 示例：
    // [
    //     ['title' => '开发规范', 'path' => '/docs/standard'],
    //     ['title' => '错误码', 'path' => '/docs/error', 'appKey' => 'api'],
    //     ['title' => '分组', 'children' => [
    //         ['title' => '接入说明', 'path' => '/docs/start'],
    //     ]],
    // ]
    'docs' => [],

    // 代码生成器配置，二维数组，每项为一个生成器
    'generator' => [],

    // 代码模板配置
    'code_template' => [],

    // 接口分享
    'share' => [
        // 是否开启接口分享
        'enable' => false,
        // 自定义分享操作，二维数组，每项配置一个按钮操作
        // 'actions' => [
        //     [
        //         'title' => '导出JSON',
        //         'click' => function ($shareData, $apiData) { return $apiData; },
        //     ],
        // ],
        'actions' => [],
    ],

    // 在线调试事件
    'debug_events' => [
        // 请求前事件
        'before' => [],
        // 请求后事件
        'after' => [],
    ],
];