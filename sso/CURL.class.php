<?php
namespace sso/lib

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
     * @var CURL设置选项
     */
    private $opt = [
        'CURLOPT_RETURNTRANSFER' => true,
        'CURLOPT_TIMEOUT'        => 6,
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
     */
    public function post(array $post_data): string
    {
        $this->opt['CURLOPT_POST']       = true;
        $this->opt['CURLOPT_POSTFIELDS'] = $post_data;
        curl_setopt_array($this->curl, $this->opt);
        return curl_exec($this->curl);
    }

    /**
     * get GET请求数据
     */
    public function get(array $get_data): string
    {
        curl_setopt_array($this->curl, $this->opt);
        return curl_exec($this->curl)
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

    /**
     * CURL destruct.
     */
    public function __destruct()
    {
        empty($this->curl) || curl_exec($this->curl);
    }
}
