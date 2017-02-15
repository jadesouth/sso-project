<?php
namespace sso\lib;

class CURL
{
    /**
     * @var string URL
     */
    private $url = '';
    /**
     * @var resource CURL句柄
     */
    private $curl = null;
    /**
     * @var array CURL设置选项
     */
    private $opt = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 6,
    ];


    /**
     * CURL construct.
     */
    public function __construct(string $url, array $opt = [])
    {
        $this->opt = $opt + $this->opt;
        $this->curl = curl_init($url);
    }

    /**
     * post POST请求数据
     *
     * @param array $post_data POST请求的数据
     *
     * @return string curl请求的数据
     */
    public function post(array $post_data): string
    {
        $this->opt[CURLOPT_POST]       = true;
        $this->opt[CURLOPT_POSTFIELDS] = $post_data;
        curl_setopt_array($this->curl, $this->opt);
        return curl_exec($this->curl);
    }

    /**
     * get GET请求数据
     *
     * @return string curl请求返回的数据
     */
    public function get(): string
    {
        curl_setopt_array($this->curl, $this->opt);
        return curl_exec($this->curl);
    }

    /**
     * setCookies 设置请求的Cookies
     *
     * @param array $cookies 键为 cookie name 值为 cookie value 的数组
     *
     * @return void
     */
    public function setCookies(array $cookies): void
    {
        foreach ($cookies as $cookie_name => $cookie_value) {
            $format_cookies[] = "{$cookie_name}={$cookie_value}";
        }
        $format_cookies = implode($format_cookies, '; ');

        curl_setopt($this->curl, CURLOPT_COOKIE, $format_cookies);
    }

    /**
     * setUrl url setter.
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * setOpt opt setter.
     */
    public function setOpt(array $opt)
    {
        $this->opt = $opt;
    }
}
