<?php
namespace Cogipix\CogimixCustomProviderBundle\Entity;
use Cogipix\CogimixBundle\Entity\TrackResult;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
/**
 *
 * @author plfort - Cogipix
 *
 */
class CustomProviderResult extends TrackResult
{

  /**
     * @ORM\Column(type="string")
     * @JMSSerializer\Type("string")
     * @var unknown_type
     */

    protected $url;

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

}
