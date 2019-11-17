<?PHP

/**
 * xmlParser Class
 *
 * Simplex Webmail Hosting XML Parser Class
 *
 * @author gakeum Lee <gklee@simplexi.com>, daeyoun Lee <dylee@simplexi.com>
 * @version 0.1 2007-04-13
 * @package xmlParser
 */
class xmlParser
{

    /**
     * init vals
     */
    var $parser;

    var $errorCode;

    var $errorString;

    var $currentLine;

    var $currentColumn;

    var $outCharset;

    var $insideTag;

    var $activeTag;

    var $headerTags = array(
        'code',
        'time',
        'totalCnt'
    );

    var $parentTags = array(
        'API',
        'record'
    );

    var $headers = array();

    var $structure = array();

    var $last;

    var $data = array();

    /**
     * xml Parser
     *
     * @param string $outCharset            
     */
    public function __construct($encoding, $data = null)
    {
        $this->path = "\$this->result";
        $this->index = 0;
        
        $xml_parser = xml_parser_create($encoding);
        xml_set_object($xml_parser, $this);
        xml_set_element_handler($xml_parser, 'startElement', 'endElement');
        xml_set_character_data_handler($xml_parser, 'characterData');
        
        xml_parse($xml_parser, $data, true);
        xml_parser_free($xml_parser);
    }

    /**
     * create the XML parser resource
     * 
     * @access private
     * @return boolean|object true on success, error otherwise
     *        
     * @see xml_parser_create
     */
    function startElement($parser, $tag, $attributeList)
    {
        eval("\$vars = get_object_vars(" . $this->path . ");");
        $this->path .= "->" . $tag;
        if ($vars and array_key_exists($tag, $vars)) {
            eval("\$data = " . $this->path . ";");
            if (is_array($data)) {
                $index = sizeof($data);
                $this->path .= "[" . $index . "]";
            } else 
                if (is_object($data)) {
                    eval($this->path . " = array(" . $this->path . ");");
                    $this->path .= "[1]";
                }
        }
        eval($this->path . " = null;");
        
        foreach ($attributeList as $name => $value)
            eval($this->path . "->" . $name . " = '" . XMLParser::cleanString($value) . "';");
    }

    function endElement($parser, $tag)
    {
        $this->path = substr($this->path, 0, strrpos($this->path, "->"));
    }

    function characterData($parser, $data)
    {
        eval($this->path . " = '" . trim($data) . "';");
    }

    function _create()
    {
        $this->parser = xml_parser_create();
        if (is_resource($this->parser)) {
            xml_set_object($this->parser, $this);
            // if(!empty($this->outCharset)) xml_parser_set_option($this->parser, XML_OPTION_TARGET_ENCODING, $this->outCharset);
            xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, FALSE);
            xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
            xml_set_element_handler($this->parser, 'startHandler', 'endHandler');
            xml_set_character_data_handler($this->parser, 'cdataHandler');
        } else {
            return FALSE;
        }
    }

    /**
     * XML_Parser::free()
     *
     * Free the internal resources associated with the parser
     *
     * @return null
     */
    function free()
    {
        if (is_resource($this->parser)) {
            xml_parser_free($this->parser);
            unset($this->parser);
            $this->last = NULL;
        }
        return NULL;
    }

    /**
     * set Start Handler
     *
     * @param
     *            $parser
     * @param
     *            $element
     * @param
     *            $attr
     */
    function startHandler($parser, $element, $attr)
    {
        switch ($element) {
            case 'data':
                $this->headers['dataCnt'] = $attr['cnt'];
                break;
            case 'API':
            case 'record':
                $this->insideTag = $element;
                break;
            default:
                $this->activeTag = $element;
        }
    }

    /**
     * end Handler
     *
     * @param
     *            $parser
     * @param
     *            $element
     */
    function endHandler($parser, $element)
    {
        if ($element == $this->insideTag) {
            $this->insideTag = '';
            $this->structure[] = $this->last;
            $this->last = '';
            $this->data = '';
        }
        if (in_array($element, $this->headerTags)) {
            if (! isset($this->headers[$element]))
                $this->headers[$element] = '';
            $this->headers[$element] = $this->data[$this->insideTag][$element];
            $this->data[$this->insideTag] = '';
        }
        $this->activeTag = '';
    }

    /**
     */
    function cdataHandler($parser, $cdata)
    {
        if (in_array($this->insideTag, $this->parentTags)) {
            $this->_add($this->insideTag, $this->activeTag, $cdata);
        }
    }

    /**
     *
     * @param
     *            $type
     * @param
     *            $field
     * @param
     *            $value
     */
    function _add($type, $field, $value)
    {
        if (! isset($this->data[$type]))
            $this->data[$type] = '';
            // if(trim($value) != '' || trim($value) != '\n' ) $this->data[$type][$field] .= !empty($this->outCharset) ? iconv('utf-8', $this->outCharset, $value) : $value;
        if (trim($value) != '')
            $this->data[$type][$field] .= ! empty($this->outCharset) ? iconv('utf-8', $this->outCharset, $value) : $value;
        $this->last = $this->data[$type];
    }

    /**
     * parse Data
     *
     * @param xml $data            
     */
    function parse($data)
    {
        if (! xml_parse($this->parser, $data)) {
            $this->errorCode = xml_get_error_code($this->parser);
            $this->errorString = xml_error_string($this->errorCode);
            $this->currentLine = xml_get_current_line_number($this->parser);
            $this->currentColumn = xml_get_current_column_number($this->parser);
        }
        $this->free();
    }

    /**
     * get Structure
     */
    function getStructure()
    {
        return array_merge($this->headers, array(
            'data' => $this->structure
        ));
    }
}