<?php
namespace Cogipix\CogimixCustomProviderBundle\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @author plfort - Cogipix
 * @ORM\Entity
 * @UniqueEntity(fields="alias",message="Alias already used",groups={"Create"})
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
     * @Assert\NotBlank(message="This value should not be blank",groups={"Create"})
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message="This value should not be blank",groups={"Create"})
     */
    protected $alias;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message="This value should not be blank",groups={"Create"})
     */
    protected $endPointUrl;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="This value should not be blank",groups={"CreateWithAuth"})
     */
    protected $authType;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="This value should not be blank",groups={"CreateWithAuth"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $password;

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

    public function getAuthType()
    {
        return $this->authType;
    }

    public function setAuthType($authType)
    {
        $this->authType = $authType;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

}
