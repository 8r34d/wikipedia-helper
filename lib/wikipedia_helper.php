<?php
/**
 * Bread Wikipedia API Helper Class
 *
 * This class contains functions that connect to the Wikipedia API
 *
 * @package     Bread
 * @subpackage  Helpers
 * @category    Helpers
 * @author      8r34d (Dean Spencer)
 * @link        https://github.com/8r34d/wikipedia_helper
 */
class Wikipedia_helper {

    private $email_address = "your@email.address";

   /**
     * Constructor
     *
     * Create a new object and set the email address
     *
     * @access  public
     * @param   string  $email_address, email address
     *                  - used in creating a unique CURL user-agent value
     *
     */
    public function __construct($email_address) {
        $this->email_address = $email_address;
    }

    // -------------------------------------------------------------------------

    /**
     * _OpensearchXmlToArray
     *
     * Converts Opensearch results from XML to an array
     *
     * @access  private
     * @param   XML     $xml, the Opensearch results as XML
     * @return  array   the Opensearch results as an array
     *
     */
    private function _OpensearchXmlToArray($xml) {

        $element = new SimpleXMLElement($xml);
        $results_array = array();
        foreach ($element->Section->Item as $item) {
            $text = (string)$item->Text;
            $description = (string)$item->Description;
            $url = (string)$item->Url;
            $results_array[$text] = array();
            $results_array[$text]['description'] = $description;
    	    $results_array[$text]['url'] = $url;
	    }
        return $results_array;
    }

    // -------------------------------------------------------------------------

    /**
     * getOpensearchResults
     *
     * Gets Opensearch results for given search terms
     *
     * @access  public
     * @param   array   $search_terms, the search term(s)
     * @param   int     $search_results_limit, number of results to return from search
     *                  - default:  10
     *                  - maximum:  100 (API limit)
     * @return  array   the Opensearch results as an array
     *
     */
    public function getOpensearchResults($search_terms, $search_results_limit = 10) {

        if(is_int($search_results_limit) && $search_results_limit > 0 && $search_results_limit <= 100) {
            $limit = $search_results_limit;
        } else {
            $limit = 10;
        }

        $endpoint   = "http://en.wikipedia.org/w/api.php";
        $format     = "xml";
        $action     = "opensearch";
        $email      = $this->email_address;
        $cv         = curl_version();
        $user_agent = "curl ${cv['version']} (${cv['host']}) ".
                      "libcurl/${cv['version']} ${cv['ssl_version']} ".
                      "zlib/${cv['libz_version']} ".
                      "[${email}]";

        $results = array();
        foreach ($search_terms as $search) {

            $url = "$endpoint?format=$format&action=$action&search=$search&limit=$limit";
    		$ch = curl_init();	
    		$options = array(
                        CURLOPT_USERAGENT       => $user_agent,
                   		CURLOPT_COOKIEFILE      => "cookies.txt",
                    	CURLOPT_COOKIEJAR       => "cookies.txt",
                    	CURLOPT_ENCODING        => "",
                    	CURLOPT_HEADER          => FALSE,
                    	CURLOPT_RETURNTRANSFER  => TRUE,
                    	CURLOPT_HTTPGET         => TRUE,
                    	CURLOPT_URL             => $url
                        );
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            curl_exec($ch);
    		$xml = curl_exec($ch);
            $results[$search] = $this->_OpensearchXmlToArray($xml);
            curl_close($ch);
        }
        return $results;	
    }
}
/* End Of File: lib/wikipedia_helper.php
------------------------------------------------------------------------------*/
