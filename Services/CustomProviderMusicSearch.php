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

    private $CURL_OPTS = array(CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20);

    public function __construct()
    {

    }

    protected function parseResponse($output)
    {

        $track = array();
      //  try{
            $track=$this->serializer->deserialize($output, 'ArrayCollection<Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderResult>', 'json');
       /* }catch(\Exception $ex){
            $this->logger->debug($ex->getMessage());
        }*/
        return $track;
    }

    protected function executeQuery()
    {
        $c = curl_init($this->customProviderInfo->getEndPointUrl());
        /* On indique à curl quelle url on souhaite télécharger */
        curl_setopt_array($c, $this->CURL_OPTS);

        /* On execute la requete */
        $output = curl_exec($c);
        /* On a une erreur alors on la lève */
        if ($output === false) {
            trigger_error('Erreur curl : ' . curl_error($c), E_USER_WARNING);
            return array();
        }

        return $this->parseResponse($output);

    }

    protected function buildQuery()
    {


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