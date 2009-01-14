<?php
require_once 'HTML/TagCloud.php';
require_once 'HTTP/Request2.php';
require_once 'HTTP/Request2/Adapter/Mock.php';

class ZemantaTopic {
    public $name;
    public $occurences = 0;
    public $links = array();
}

class ZemantaClient {
    protected $api_key;
    protected $request;

    public function __construct($api_key, $request) {
        $this->api_key = $api_key;
        $this->request = $request;
    }

	public function extractTopics($text) {


        $params = array(
              'method' => 'zemanta.suggest',
              'api_key' => $this->api_key,
              'text' => $text,
              'format' => 'json',
              'return_categories' => 'dmoz',
              'return_images' => 0,
              'return_rdf_links' => 1
        );

        $url = new Net_URL2('http://api.zemanta.com/services/rest/0.0/');


        $this->request->setURL($url);
        $this->request->setMethod('POST');
        $this->request->addPostParameter($params);

        $response = $this->request->send();
        // Check if 403/404
        $json = $response->getBody();

        $data = json_decode($json);

        return $data->markup->links;
    }

}

class Bill {
    public $title;
    public $text;
}

class BillReader {
    public function fetch() {
        $bill = new Bill();
        $bill->title = "Desexing cats and eating fish";
        $bill->text = "SEC. 15101. LABORATORY AND SUPPORT SPACE, EDGEWATER, MARYLAND.

      (a) Authority To Design and Construct- The Board of Regents of the Smithsonian Institution is authorized to design and construct laboratory and support space to accommodate the Mathias Laboratory at the Smithsonian Environmental Research Center in Edgewater, Maryland.

      (b) Authorization of Appropriations- There is authorized to be appropriated to carry out this section a total of $41,000,000 for fiscal years 2009 through 2011. Such sums shall remain available until expended.

SEC. 15102. LABORATORY SPACE, GAMBOA, PANAMA.

      (a) Authority To Construct- The Board of Regents of the Smithsonian Institution is authorized to construct laboratory space to accommodate the terrestrial research program of the Smithsonian tropical research institute in Gamboa, Panama.

      (b) Authorization of Appropriations- There is authorized to be appropriated to carry out this section a total of $14,000,000 for fiscal years 2009 and 2010. Such sums shall remain available until expended.

SEC. 15103. CONSTRUCTION OF GREENHOUSE FACILITY.

      (a) In General- The Board of Regents of the Smithsonian Institution is authorized to construct a greenhouse facility at its museum support facility in Suitland, Maryland, to maintain the horticultural operations of, and preserve the orchid collection held in trust by, the Smithsonian Institution.

      (b) Authorization of Appropriations- There is authorized to be appropriated $12,000,000 to carry out this section. Such sums shall remain available until expended.";

        return array($bill, $bill, $bill, $bill, $bill, $bill, $bill, $bill, $bill, $bill);
    }
}
$reader = new BillReader();
$bills = $reader->fetch();

include_once 'config.php'; // defines $api_key

//Mock!
$data = file_get_contents(dirname(__FILE__).  '/test_data.json');


$mock = new HTTP_Request2_Adapter_Mock();

for ($i = 0; $i < 10; $i++) {
    $response = new HTTP_Request2_Response('HTTP/1.1 400 Success');
    $response->appendBody($data);

    $mock->addResponse($response);
}

$request  = new HTTP_Request2();
$request->setAdapter($mock);

$client = new ZemantaClient($api_key, $request);

$topics = array();
foreach ($bills as $bill) {
    $topics = array_merge($topics,  $client->extractTopics($bill->text));
}

$stats = array();
foreach ($topics as $topic) {
    $title = $topic->target[0]->title;

    if (!isset($stats[$title])) {
        $stats[$title] = 0;
    }

    $stats[$title] += $topic->confidence * 10;
}



$tags = new HTML_TagCloud();

foreach ($topics as $topic) {
    $title = $topic->target[0]->title;

    if (isset($stats[$title])) {
        $tags->addElement($title, $topic->target[0]->url, $stats[$title]);
        unset($stats[$title]);
    }
}

?>
<html>
<head>
</head>
<body>
<?php
//Render tagcloud
print $tags->buildALL();
?>
<pre><?php print_r($stats); ?></pre>
</body>
</html>