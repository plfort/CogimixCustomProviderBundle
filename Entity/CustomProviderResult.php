<?php
namespace Cogipix\CogimixCustomProviderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
/**
  * @JMSSerializer\AccessType("public_method")
 * @ORM\MappedSuperclass()
 * @author plfort - Cogipix
 */
class CustomProviderResult extends Song
{

    protected $shareable=false;

    public function __construct(){
        parent::__construct();
        // $this->pluginProperties=array('test'=>array('url'=>'','test'=>'hello'));
    }


    public function setUrl($url)
    {
        $this->pluginProperties['url'] =$url;
    }



    public function getEntryId(){
        return $this->getId();
    }

}
