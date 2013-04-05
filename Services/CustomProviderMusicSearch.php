<?php
namespace Cogipix\CogimixCustomProviderBundle\Services;
use Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderInfo;
use Cogipix\CogimixCommonBundle\MusicSearch\AbstractMusicSearch;

class CustomProviderMusicSearch extends AbstractMusicSearch
{

    /**
     *
     * @var CustomProviderInfo $customProviderInfo
     */
    private $customProviderInfo;
    private $serializer;

    private $CURL_OPTS = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_POST=>1,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_SSL_VERIFYPEER => false,
            );

    public function __construct()
    {

    }

    protected function parseResponse($output)
    {

        $tracks = array();
       try{
       $tracks=$this->serializer->deserialize($output, 'ArrayCollection<Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderResult>', 'json');
       foreach($tracks as $track){
           $url=$this->getCustomProviderInfo()->getEndPointUrl().'/get/'.$track->getId();
           $track->setUrl($url);
           $track->setTag($this->getResultTag());
           $track->setThumbnails($this->getDefaultIcon());
           $track->setIcon($this->getDefaultIcon());

       }
        }catch(\Exception $ex){
            $this->logger->info($ex->getMessage());
            return array();
        }
        return $tracks;
    }

    public function testRemote(){
     $c = curl_init($this->customProviderInfo->getEndPointUrl().'/ping');
        /* On indique à curl quelle url on souhaite télécharger */
       //echo $this->serializer->serialize($this->searchQuery);die();
         $CURL_OPTS = array(
                 CURLOPT_CONNECTTIMEOUT => 10,
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_TIMEOUT => 20,
                 CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                 CURLOPT_SSL_VERIFYPEER => false,
         );
        curl_setopt_array($c, $CURL_OPTS);

        /* On execute la requete */
        $output = curl_exec($c);

        //echo $output;die();
        /* On a une erreur alors on la lève */
        if ($output === false) {
            $this->logger->err(curl_error($c));

            return false;
        }
        $response = json_decode($output,true);

        if(isset($response['count'])){

            return $response;
        }
        return false;

    }

    protected function executeQuery()
    {
        $c = curl_init($this->customProviderInfo->getEndPointUrl().'/search');
        /* On indique à curl quelle url on souhaite télécharger */
       //echo $this->serializer->serialize($this->searchQuery);die();

        curl_setopt_array($c, $this->CURL_OPTS);

        /* On execute la requete */
        $output = curl_exec($c);

        //echo $output;die();
        /* On a une erreur alors on la lève */
        if ($output === false) {
            $this->logger->err(curl_error($c));

            return array();
        }

        return $this->parseResponse($output);

    }

    protected function buildQuery()
    {
        $this->logger->info($this->searchQuery);
        if($this->customProviderInfo->getAuthType() == 'basic'){
            $this->CURL_OPTS[CURLOPT_HTTPAUTH]=CURLAUTH_BASIC;
            $this->CURL_OPTS[CURLOPT_USERPWD]=$this->customProviderInfo->getUsername() . ":" . $this->customProviderInfo->getPassword();
        }
        if($this->customProviderInfo->getAuthType() == 'digest'){
            $this->CURL_OPTS[CURLOPT_HTTPAUTH]=CURLAUTH_DIGEST;
            $this->CURL_OPTS[CURLOPT_USERPWD]=$this->customProviderInfo->getUsername() . ":" . $this->customProviderInfo->getPassword();
        }
        if($this->searchQuery){
            $this->CURL_OPTS[CURLOPT_POSTFIELDS]=$this->serializer->serialize($this->searchQuery,'json');
        }

    }

    public function getName()
    {
        return $this->customProviderInfo->getName();
    }

    public function getAlias()
    {
        return $this->customProviderInfo->getAlias();
    }

    public function getResultTag()
    {
        return 'stream';
    }

    public function getDefaultIcon(){
        return 'bundles/cogimixcustomprovider/images/cogimix.png';
    }

    public function getCustomProviderInfo()
    {
        return $this->customProviderInfo;
    }

    public function setCustomProviderInfo(
            CustomProviderInfo $customProviderInfo)
    {
        $this->customProviderInfo = $customProviderInfo;
    }

    public function getSerializer()
    {
        return $this->serializer;
    }

    public function setSerializer($serializer)
    {
        $this->serializer = $serializer;
    }

}

?>