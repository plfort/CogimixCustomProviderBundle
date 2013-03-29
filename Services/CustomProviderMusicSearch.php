<?php
namespace Cogipix\CogimixCustomProviderBundle\Services;
use Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderInfo;

use Cogipix\CogimixBundle\Entity\TrackResult;
use Cogipix\CogimixBundle\Services\AbstractMusicSearch;

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
            );

    public function __construct()
    {

    }

    protected function parseResponse($output)
    {

        $tracks = array();
      //  try{
            $tracks=$this->serializer->deserialize($output, 'ArrayCollection<Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderResult>', 'json');
       foreach($tracks as $track){
           $track->setUrl('http://localhost/music/web/index.php/get/'.$track->getId());
           $track->setTag('stream');
           $track->setThumbnails('bundles/cogimixcustomprovider/images/cogimix.png');
           $track->setIcon($this->getDefaultIcon());
           $track->setEntryId($track->getId());
       }
       /* }catch(\Exception $ex){
            $this->logger->debug($ex->getMessage());
        }*/
        return $tracks;
    }

    protected function executeQuery()
    {
        $c = curl_init($this->customProviderInfo->getEndPointUrl());
        /* On indique à curl quelle url on souhaite télécharger */
       //echo $this->serializer->serialize($this->searchQuery);die();

        curl_setopt_array($c, $this->CURL_OPTS);

        /* On execute la requete */
        $output = curl_exec($c);

        //echo $output;die();
        /* On a une erreur alors on la lève */
        if ($output === false) {
            trigger_error('Erreur curl : ' . curl_error($c), E_USER_WARNING);
            return array();
        }

        return $this->parseResponse($output);

    }

    protected function buildQuery()
    {
        $this->logger->info($this->searchQuery);

        $this->CURL_OPTS[CURLOPT_POSTFIELDS]=$this->serializer->serialize($this->searchQuery,'json');

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
        return 'custom';
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