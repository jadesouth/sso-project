# SSO
SSO实验项目

[TOC]

## 项目功能介绍
项目实现一套实验性质的跨域SSO登录服务.

SSO服务为C/S架构,Server端和Client端可以分别部署在相同物理机或不同物理机上,Client一般作为具体项目的类库使用.
sso/server: 为SSO用户认证授权中心项目,也是整个单点登录的核心SSO系统,一般会独立部署.
sso/client: 为SSO客户端服务,一般同具体项目部署.
system_1/system_2/system_3: 分别为各个应用子项目.
各个应用子项目比如可分别为主站/论坛/博客等.
子项目可以是独立不想关的域名,可分别部署不同的物理机上,也可部署同一台物理机的不同虚拟主机.

源码Clone后配置Nginx服务器后可直接测试查看效果 [nginx配置](#nginx和host配置说明).
- 运行环境
    - PHP7 >= PHP7.0
    - Nginx/Apache等WEB服务器
- 测试账号(也可自己编辑sso/user/create_user_info.php自己生成测试账号或实现自己的账号体系):
```php
$user_info[] = [
    'id'       => 1,
    'username' => 'foo',
    'password' => 'bar',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'zhangsan',
    'password' => '111111',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'lisi',
    'password' => '111111',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'wangwu',
    'password' => '111111',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'zhaoliu',
    'password' => '111111',
];
```

## 项目目录文件结构
```
├── README.md ----------------------------------------------- 项目描述文件
├── sso --------------------------------------------- SSO服务相关代码跟目录
│   ├── client -------------------- SSO客户端目录,此目录一般部署在具体项目机器
│   │   └── SSOClient.class.php -------------------------- SSO客户端类文件
│   ├── lib ---------------------------- SSO服务端和客户端共同使用到的类库目录
│   │   └── CURL.class.php ------------------------------ CURL请求封装类库
│   ├── server -------------------------------------------- SSO服务端目录
│   │   ├── lib ----------------------------------- SSO服务端用到的类库目录
│   │   │   ├── SSOServer.class.php -------------------------- SSO服务类
│   │   │   ├── Token.class.php ------------------------- Token相关处理类
│   │   │   └── User.class.php ---------------------------- 用户相关处理类
│   │   ├── login.php -------------------------------- SSO登录逻辑处理文件
│   │   ├── logout.php ------------------------------- SSO登出逻辑处理文件
│   │   └── passive_login.php --------------------- SSO被动登录逻辑处理文件
│   └── user ------------------- 模拟用户数据目录,实际项目使用自己的用户数据模块
│       ├── create_user_info.php --------------------- 生成模拟用户数据文件
│       └── user_info.json -------------------------- 用户数据记录JSON文件
├── system_1 --------------------------------------------- 系统1项目根目录
│   ├── config.inc.php -------------------------------------- 项目配置文件
│   ├── index.php ----------------------------------------------- 项目首页
│   ├── login.php ------------------------------------------- 项目登录页面
│   ├── logout.php --------------------------------------- 项目登出处理文件
│   ├── sso_login.php ------------------------------ 项目SSO被动登录处理文件
│   └── sso_logout.php ----------------------------- 项目SSO被动登出处理文件
├── system_2  --------------------------------------------- 系统2项目根目录
│   ├── config.inc.php -------------------------------------- 项目配置文件
│   ├── index.php ----------------------------------------------- 项目首页
│   ├── login.php ------------------------------------------- 项目登录页面
│   ├── logout.php --------------------------------------- 项目登出处理文件
│   ├── sso_login.php ------------------------------ 项目SSO被动登录处理文件
│   └── sso_logout.php ----------------------------- 项目SSO被动登出处理文件
└── system_3  --------------------------------------------- 系统3项目根目录
    ├── config.inc.php -------------------------------------- 项目配置文件
    ├── index.php ----------------------------------------------- 项目首页
    ├── login.php ------------------------------------------- 项目登录页面
    ├── logout.php --------------------------------------- 项目登出处理文件
    ├── sso_login.php ------------------------------ 项目SSO被动登录处理文件
    └── sso_logout.php ----------------------------- 项目SSO被动登出处理文件
```

## Nginx和Host配置说明

在不同的虚拟机中分别配置了3个独立域名的系统和SSO服务端

```nginx
# SSO-server
server {
    listen       80;
    root   /data/wwwroot/sso-project/sso/server;
    server_name  sso.com www.sso.com;
    location / {
        index  index.php index.html index.htm;
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        index index.php index.html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}

# SSO-System 1
server {
    listen       80;
    root   /data/wwwroot/sso-project/system_1;
    server_name  s1.com www.s1.com;
    location / {
        index  index.php index.html index.htm;
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        index index.php index.html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}

# SSO-System 2
server {
    listen       80;
    root   /data/wwwroot/sso-project/system_2;
    server_name  s2.com www.s2.com;
    location / {
        index  index.php index.html index.htm;
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        index index.php index.html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}
```

host配置
```host
127.0.0.1   sso.com www.sso.com
127.0.0.1   s1.com www.s1.com
127.0.0.1   s2.com www.s2.com
127.0.0.1   s3.com www.s3.com
```

## 项目问题
1. 项目结构不够清晰规范,这块只能慢慢写慢慢改了
2. SSO对具体项目侵入太多,计划完善SSO Client,更多的采用配置的形式实现和具体项目的尽可能解耦
3. 服务端SESSION为PHP默认单机文件实现机制不能分布式部署SSO服务器,计划改为Redis+MySQL方式