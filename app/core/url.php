<?php
namespace App\Core;

class Url
{

    /**
     * The current full url
     * 
     * @var string
     */
    protected $url;



    /**
     * The current url as a key to value array
     * 
     * @var array
     */
    protected $urlArray = array();


    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Url();
        }
        return $inst;
    }


    /**
     * Constructor
     */
    private function __construct()
    {
        // Initialise properties
        $this->setUrl();
        $this->setUrlArray();
    }



    /**
     * Set the url
     */
    private function setUrl()
    {
        $this->url  = ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ) ? 'https' : 'http';
        $this->url .= '://' . $_SERVER['SERVER_NAME'];
        $this->url .= in_array( $_SERVER['SERVER_PORT'], array( '80', '443' ) ) ? '' : ":" . $_SERVER['SERVER_PORT'];
        $this->url .= $_SERVER['REQUEST_URI'];
    }



    /**
     * Set the url array
     */
    private function setUrlArray()
    {
        $this->urlArray = parse_url($this->url);
        if (isset($this->urlArray['query'])) {
            parse_str(html_entity_decode($this->urlArray['query']), $this->urlArray['query']);
        }
        $this->urlArray['method'] = $_SERVER['REQUEST_METHOD'];
    }



    /**
     * Get the Url as a string
     * 
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }



    /**
     * Get the Url as an array
     * 
     * @return array
     */
    public function geturlArray() : array
    {
        return $this->urlArray;
    }



    /**
     * Get the scheme
     * 
     * @return string
     */
    public function getScheme() : string
    {
        return $this->urlArray['scheme'];
    }



    /**
     * Get the host
     * 
     * @return string
     */
    public function getHost() : string
    {
        return $this->urlArray['host'];
    }



    /**
     * Get the paths as an array
     * 
     * @return array
     */
    public function getPaths() : array
    {
        return explode('/', trim($this->urlArray['path'],'/'));
    }



    /**
     * Get the query string as an array
     * If it doesn't exist, return null
     * 
     * @return array|null
     */
    public function getQuery() : ?array
    {
        return $this->urlArray['query'] ?? null;
    }



    /**
     * Get the request method
     * 
     * @return string
     */
    public function getMethod() : string
    {
        return $this->urlArray['method'];
    }
}
