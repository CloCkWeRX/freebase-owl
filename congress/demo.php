<?php
require_once 'HTML/TagCloud.php';
require_once 'HTTP/Request2.php';

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
        );

        $url = new Net_URL2('http://api.zemanta.com/services/rest/0.0/');


        $this->request->setURL($url);
        $this->request->setMethod('POST');
        $this->request->addPostParameter($params);

        $response = $this->request->send();
        // Check if 403/404
        $json = $response->getBody();

        $data = json_decode($json);

        return $data->keywords;
    }

	public function extractTopics2($text) {
        $topics = array();
        $topic = new ZemantaTopic();
        $topic->name = "Cats";
        $topic->occurences = 10;
        $topic->links[] = 'http://cats.com/';

        $topics[] = $topic;

        $topic = new ZemantaTopic();
        $topic->name = "Fish";
        $topic->occurences = 99;
        $topic->links[] = 'http://fish.com/';

        $topics[] = $topic;



        $topic = new ZemantaTopic();
        $topic->name = "FishyForests";
        $topic->occurences = 14;
        $topic->links[] = 'http://fish.com/';

        $topics[] = $topic;




        $topic = new ZemantaTopic();
        $topic->name = "Rainforests";
        $topic->occurences = 19;
        $topic->links[] = 'http://fish.com/';

        $topics[] = $topic;

        return $topics;
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

        return array($bill);
    }
}
$reader = new BillReader();
$bills = $reader->fetch();

include_once 'config.php'; // defines $api_key
$client = new ZemantaClient($api_key, new HTTP_Request2());

$topics = array();
foreach ($bills as $bill) {
    $topics = array_merge($topics,  $client->extractTopics($bill->text) );
}


$tags = new HTML_TagCloud();

foreach ($topics as $topic) {
    $tags->addElement($topic->name, "", $topic->confidence);
}

//Render tagcloud
print $tags->buildALL();

print '<pre>' . $bill->text . '</pre>';