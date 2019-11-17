<?PHP

/**
 * apiRequest CALL function ( Using this For Test )
 *
 * @param string $key            
 * @param string $url            
 * @return string response
 */
function apiRequest($key, $url, $inputCharset = 'euc-kr')
{
    $params = array(
        'key' => $key,
        'url' => $url,
        'inputCharset' => $inputCharset
    );
    $api = new ApiClient($params);
    $api->request();
    return $api->response;
}

/**
 * ApiClient Class
 *
 * Simplex Webmail Hosting API Client Class
 *
 * @author gakeum Lee <gklee@simplexi.com>, daeyoun Lee <dylee@simplexi.com>
 * @version 0.1 2007-04-13
 * @package API
 */
class ApiClient
{

    /**
     * Create Initial Valuables
     */
    /**
     * Authentication Key
     *
     * @var string
     */
    var $key;

    /**
     * Initialization Vector
     *
     * @var string
     */
    var $iv;

    /**
     * Initialization XML
     *
     * @var string
     */
    var $xml = '';

    /**
     * connection var
     *
     * @var string
     */
    var $conn;

    /**
     * errorCode
     *
     * @var string
     */
    var $errcode;

    /**
     * comm Method
     *
     * @var string
     */
    var $method;

    /**
     * URL val
     *
     * @var string
     */
    var $url;

    /**
     * comm Body post
     *
     * @var string
     */
    var $postBody;

    /**
     * _header
     *
     * @var string
     */
    var $_header;

    /**
     * _body
     *
     * @var string
     */
    var $_body;

    /**
     * Input character set val
     *
     * @var string
     */
    var $inputCharset;

    /**
     * response var
     *
     * @var string
     */
    var $response;

    /**
     * Contructor
     *
     * @param array $params            
     */
    function __construct($params)
    {
        $this->key = (empty($params['key']) === FALSE) ? $params['key'] : NULL;
        $this->method = (empty($params['method']) === FALSE) ? strtoupper($params['method']) : 'POST';
        $this->url = (empty($params['url']) === FALSE) ? $params['url'] : NULL;
        $this->postBody = (empty($params['postBody']) === FALSE) ? $params['postBody'] : NULL;
        $this->inputCharset = (empty($params['inputCharset']) === FALSE) ? $params['inputCharset'] : 'utf-8';
    }

    /**
     * request
     * communicating for Server Using _ fwrite & fputs
     */
    function request()
    {
        $data = $this->getParsedData();
        if ($data === FALSE)
            return FALSE;
        $this->setBody($data['body']);
        $this->setHeader($data['path'], $data['host']);
        
        $message = '';
        $message .= $this->_header;
        $message .= "\r\n";
        $message .= $this->_body;
        $message .= "\r\n";
        
        /*
         * $this->connect($data['host']);
         * if(is_resource($this->conn) == FALSE || get_resource_type($this->conn) != 'stream') return FALSE;
         * fwrite($this->conn, $message);
         *
         * #$status = stream_get_meta_data($this->conn);
         * #if ((int)$status['unread_bytes'] <= 0) return FALSE;
         *
         * $buffer = '';
         * while(feof($this->conn) === FALSE) {
         * #$status = stream_get_meta_data($this->conn);
         * #if ((int)$status['unread_bytes'] <= 0) {
         * # break;
         * #}
         * $buffer .= fgets($this->conn, 4096);
         * #$size = hexdec(trim(fgets($this->conn, 128)));
         * #$buffer .= fread($this->conn, $size);
         * #fgets($this->conn, 128);
         * }
         * fclose($this->conn);
         * list($header, $body) = $this->_splitBodyHeader(trim($buffer));
         */
        $ch = curl_init('http://' . $data['host'] . '/' . $data['path'] . '?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_body);
        $body = curl_exec($ch);
        curl_close($ch);
        $this->response = trim($body);
    }

    /**
     * Split Body Header
     *
     * check Header Syntax
     *
     * @param string $input            
     * @return boolean
     */
    function _splitBodyHeader($input)
    {
        if (preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $input, $match)) {
            return array(
                $match[1],
                $match[2]
            );
        }
        return FALSE;
    }

    /**
     * connect
     *
     * fsock connection function
     *
     * @param string $host            
     * @param integer $port            
     * @param integer $timeout
     *            = 30
     */
    function connect($host, $port = 80, $timeout = 30)
    {
        $this->conn = fsockopen($host, $port, $errno, $errstr, $timeout);
        if (is_resource($this->conn) === FALSE || get_resource_type($this->conn) != 'stream')
            $this->errcode = 2001;
    }

    /**
     * get the Parsed Data
     *
     * @return array $data
     */
    function getParsedData()
    {
        $argNum = func_num_args();
        $url = ($argNum >= 2) ? func_get_arg(1) : $this->url;
        $postBody = ($argNum >= 3) ? func_get_arg(2) : $this->postBody;
        
        $data = array();
        $parsedUrl = @parse_url($url);
        if ($parsedUrl === FALSE)
            return FALSE;
        
        $data['scheme'] = (empty($parsedUrl['scheme']) === FALSE) ? $parsedUrl['scheme'] : NULL;
        $data['host'] = (empty($parsedUrl['host']) === FALSE) ? $parsedUrl['host'] : NULL;
        $data['path'] = (empty($parsedUrl['path']) === FALSE) ? $parsedUrl['path'] : NULL;
        
        $postBody1 = array();
        $postBody2 = array();
        if (empty($parsedUrl['query']) === FALSE)
            parse_str($parsedUrl['query'], $postBody1);
        if (empty($postBody) === FALSE) {
            if (is_array($postBody) === FALSE)
                parse_str($postBody, $postBody2);
            else
                $postBody2 = $postBody;
        }
        $data['body'] = array_merge($postBody1, $postBody2);
        
        unset($parsedUrl);
        unset($postBody1);
        unset($postBody2);
        return $data;
    }

    /**
     * Set Header
     *
     * @param string $path            
     */
    function setHeader($path, $host = NULL)
    {
        $method = (func_num_args() == 4) ? strtoupper(func_get_arg(3)) : $this->method;
        if (($method != 'POST') && ($method != 'GET') && ($method != 'PUT'))
            $this->errcode = 3001;
        
        $this->_header = '';
        $len = strlen($this->_body);
        $params = '';
        switch ($method) {
            case 'PUT':
                $this->_header .= "PUT " . $path . " HTTP/1.0\r\n";
                $this->_header .= "Content-type: text/xml\r\n";
                $this->_header .= "Content-length: " . $len . "\r\n";
                break;
            default:
                /*
                    $this->_header .= $method." ".$path." HTTP/1.0\r\n";
                    $this->_header .= "Host: ".$host."\r\n";
                    $this->_header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                    $this->_header .= "Content-Length: ".$len."\r\n";
                    $this->_header .= "Connection: Keep-Alive\r\n";
                */
                $this->_header = array(
                    $method . " " . $path . " HTTP/1.1\r\n",
                    "Host: " . $host . "\r\n",
                    // "Content-Type: application/x-www-form-urlencoded\r\n",
                    "Content-Length: " . $len . "\r\n",
                    "Connection: Keep-Alive\r\n"
                );
        }
        unset($params);
    }

    /**
     * set The Body
     *
     * @param array $body            
     * @return array $xml
     */
    function setBody($body)
    {
        $xml = '';
        $xml .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
        $xml .= "<API>\n";
        $xml .= "<time>" . strval(time()) . "</time>\n";
        
        if (is_array($body) && count($body) > 0) {
            $this->_buildXML($body);
        }
        $xml .= $this->xml;
        $xml .= "</API>";
        
        $body = $this->encryptXML($xml);
        
        if ($this->method == 'PUT') {
            $this->_body = $this->iv . "\r\n" . $body;
        } else {
            $this->_body = "iv=" . urlencode($this->iv) . "&xml=" . urlencode($body);
        }
        
        return $xml;
    }

    /**
     * build XML Data
     *
     * @param
     *            array or else $xml
     */
    function _buildXML($xml)
    {
        foreach ($xml as $key => $value) {
            if (is_int($key))
                $key = 'SUBNODE';
            $this->xml .= "<" . $key . ">";
            if (is_array($value)) {
                $this->xml .= "\n";
                $this->_buildXML($value);
                $this->xml .= "</" . $key . ">\n";
            } else {
                if ($this->inputCharset != 'utf-8')
                    $value = iconv($this->inputCharset, 'utf-8', $value);
                $this->xml .= $value . "</" . $key . ">\n";
            }
        }
    }

    /**
     * parsed XML Data
     *
     * @param xml $xml            
     */
    function parseXML($xml)
    {
        $xp = xml_parser_create();
        xml_parser_set_option($xp, XML_OPTION_CASE_FOLDING, FALSE);
        xml_parse_into_struct($xp, $xml, $vals, $tags);
        // $this->dumpView($tags);
        // $this->dumpView($vals);
        $data = array();
        $tmp = '';
        foreach ($vals as $val) {
            // if ($val['type'] == 'open') { }
            if ($val['type'] == 'complete')
                $data = array_merge($data, array(
                    $val['tag'] => $val['value']
                ));
        }
    }

    /**
     * encrypt XML Data
     *
     * 3DES encrypt function
     *
     * @param xml $xml            
     * @return string hexFromBin($xml)
     */
    function encryptXML($xml = '')
    {
        if (empty($xml))
            $xml = $this->xml;
        
        $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_CFB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $xml = mcrypt_encrypt(MCRYPT_3DES, $this->key, $xml, MCRYPT_MODE_CFB, $iv);
        
        $this->iv = $this->hexFromBin($iv);
        unset($iv_size);
        unset($iv);
        
        return $this->hexFromBin($xml);
    }

    /**
     * decryption 3DES XML Data
     *
     * @param string $xml            
     * @return string $xml
     */
    function decryptXML($xml = '')
    {
        if (empty($xml))
            $xml = $this->xml;
        $xml = mcrypt_decrypt(MCRYPT_3DES, $this->key, $this->binFromHex($xml), MCRYPT_MODE_CFB, $this->binFromHex($this->iv));
        return $xml;
    }

    /**
     * hex From bin
     *
     * @param string $data            
     * @return strinf bin2hex($data)
     */
    function hexFromBin($data)
    {
        return bin2hex($data);
    }

    /**
     * bin From hex
     *
     * @param string $data            
     * @return string
     */
    function binFromHex($data)
    {
        $len = strlen($data);
        return pack('H' . $len, $data);
    }

    /**
     * HTTP Build Query
     *
     * @param array $data            
     * @param string $sep            
     * @param string $prefix            
     * @param string $keys            
     */
    function buildQueryString($data, $sep = NULL, $prefix = NULL, $keys = NULL)
    {
        if (! function_exists('http_build_query')) {
            $returnValue = array();
            
            foreach ((array) $data as $key => $value) {
                $key = urlencode($key);
                if (is_int($key) && $prefix != NULL) {
                    $key = $prefix . $key;
                }
                if (empty($keys) === FALSE)
                    $key = $keys . '[' . $key . ']';
                
                if (is_array($value) || is_object($value)) {
                    array_push($returnValue, Util::buildQueryString($value, $sep, NULL, $key));
                } else {
                    array_push($returnValue, $key . '=' . urlencode($value));
                }
            }
            
            $sep = ! empty($sep) ? $sep : ini_get('arg_separator.output');
            
            return @implode($sep, $returnValue);
        } else {
            return http_build_query($data, $prefix);
        }
    }
}