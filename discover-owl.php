<?php
require_once 'Net/URL.php';
require_once 'HTTP/Client.php';

if (!extension_loaded('json')) {
    die("You need the JSON extension :(");
}

class MetawebAPI_Client extends HTTP_Client {
    public function buildQuery(stdclass $query) {
        $queries = new stdclass();
        $queries->qname = array("query" => $query);

        $url = new FreebaseURL('http://www.freebase.com/api/service/mqlread');
        $url->querystring['queries'] = json_encode($queries);

        return $url;
    }
}

class MQL extends stdclass {}
class FreebaseURL extends Net_URL {
    public function __toString() {
        return $this->getURL();
    }
}

class FreebaseDomain {
    protected $name;
    protected $client;

    public function __construct($name) {
        $this->name = $name;
        $this->client = new MetawebAPI_Client();
    }

    public function listTypes() {


        $query = new mql();
        $query->type = '/type/domain';
        $query->id = $this->name;
        $query->types = array();

        $url = $this->client->buildQuery($query);

        $this->client->get((string)$url);

        $response = $this->client->currentResponse();

        $data = json_decode($response['body']);

        return $data->qname->result->types;
    }
}

class OWLDocument extends DOMDocument {

    const XMLNS_RDF = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';
    const XMLNS_OWL = 'http://www.w3.org/2002/07/owl#';
    const XMLNS_RDFS = 'http://www.w3.org/2000/01/rdf-schema#';

    protected function urlize($resource_prefix, $value) {
        if (empty($value)) {
            return "";
        }

        return $resource_prefix . $value;
    }

    public function aProperty($property, $resource_prefix, $schema) {
        $class_uri = $resource_prefix . $schema->id;

        $node = $this->createElementNS(self::XMLNS_OWL, 'owl:ObjectProperty');
        $node->setAttributeNS(self::XMLNS_RDF, 'rdf:about', $this->urlize($class_uri, $property->key[0]));

        $titleNode = $this->createElementNS(self::XMLNS_RDFS, 'rdfs:comment', $property->name);
        $node->appendChild($titleNode);

        $propertyType = empty($property->unique) ? 'FunctionalProperty' : 'InverseFunctionalProperty';

        $propertyTypeNode = $this->createElementNS(self::XMLNS_RDF, 'rdf:type');
        $propertyTypeNode->setAttributeNS(self::XMLNS_RDF, 'rdf:resource', self::XMLNS_OWL . $propertyType);
        $node->appendChild($propertyTypeNode);

        if (!empty($property->expected_type)) {
            $rangeNode = $this->createElementNS(self::XMLNS_RDFS, 'rdfs:range');
            $rangeNode->setAttributeNS(self::XMLNS_RDF, 'rdf:resource', $this->urlize($resource_prefix, $property->expected_type->id));

            $node->appendChild($rangeNode);
        }

        $domainNode = $this->createElementNS(self::XMLNS_RDFS, 'rdfs:domain');
        $domainNode->setAttributeNS(self::XMLNS_RDF, 'rdf:resource', $class_uri);

        $node->appendChild($domainNode);

        return $node;
    }

    public function aClass($schema, $resource_prefix) {
        $class = $this->createElementNS(self::XMLNS_OWL, 'owl:Class');
        $class->setAttributeNS(self::XMLNS_RDF, 'rdf:about', $this->urlize($resource_prefix, $schema->id));

        return $class;
    }
}

class FreebaseType {
    protected $name;
    protected $client;

    public function __construct($name) {
        $this->name = $name;
        $this->client = new MetawebAPI_Client();
    }

    public function describe() {
        $query = new mql();
        $query->type = '/type/type';
        $query->id = $this->name;
        $query->name = null;

        $query->properties = array();
        $query->properties[0] = new mql();
        $query->properties[0]->optional = true;
        $query->properties[0]->name = null;
        $query->properties[0]->key = array();
        $query->properties[0]->expected_type = new mql();
        $query->properties[0]->expected_type->name = null;
        $query->properties[0]->expected_type->id = null;
        $query->properties[0]->unique = null;

        /** @todo think about this later */
/*
        $query->expected_by = array();
        $query->expected_by[0] = new mql();
        $query->expected_by[0]->optional = true;
        $query->expected_by[0]->name = null;
        $query->expected_by[0]->key = array();
        $query->expected_by[0]->schema = new mql();
        $query->expected_by[0]->schema->name = null;
        $query->expected_by[0]->schema->id = null;
*/
        $url = $this->client->buildQuery($query);

        $this->client->get((string)$url);

        $response = $this->client->currentResponse();

        $data = json_decode($response['body']);

        return $data->qname->result;
    }

    /**
     * @param string    $resource_prefix    An optional URI you want to prefix all rdf:about and rdf:resource with. This will typically be the URI of your service.
     */
    public function toOWL($resource_prefix = null) {
        $schema = $this->describe();

        $dom = new OWLDocument();
        $dom->formatOutput = true;


        $rdf = $dom->createElementNS(OWLDocument::XMLNS_RDF, 'rdf:RDF');
        $dom->appendChild($rdf);

        $ontology = $dom->createElementNS(OWLDocument::XMLNS_OWL, 'owl:Ontology');
        $ontology->appendChild($dom->createAttributeNS(OWLDocument::XMLNS_RDF, 'rdf:about'));
        $ontology->appendChild($dom->createElementNS(OWLDocument::XMLNS_RDFS, 'rdfs:comment', "An automatically generated ontology for " . $schema->name . ", based on its entry in Freebase (http://www.freebase.com/). Licensed as Creative Commons, By Attribution - see http://www.freebase.com/signin/licensing and http://www.freebase.com/view/common/license/cc_attribution_25 for more detail."));

        $rdf->appendChild($ontology);


        $rdf->appendChild($dom->aClass($schema, $resource_prefix));
        foreach ($schema->properties as $property) {
            $rdf->appendChild($dom->aProperty($property, $resource_prefix, $schema));
        }

        return $dom->saveXML();
    }
}


$domain = new FreebaseDomain('/user/doconnor/mortgage_industry');
$types = $domain->listTypes();

foreach ($types as $key) {
    $type = new FreebaseType($key);

    print $key . ":\n";
    print $type->toOWL('?lookup=') . "\n\n";
}
