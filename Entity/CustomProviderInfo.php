<?php
namespace Cogipix\CogimixCustomProviderBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @author plfort - Cogipix
 * @ORM\Entity
 */
class CustomProviderInfo
{

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $alias;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $endPointUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Cogipix\CogimixBundle\Entity\User")
     * @var unknown_type
     */
    protected $user;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function getEndPointUrl()
    {
        return $this->endPointUrl;
    }

    public function setEndPointUrl($endPointUrl)
    {
        $this->endPointUrl = $endPointUrl;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

}
