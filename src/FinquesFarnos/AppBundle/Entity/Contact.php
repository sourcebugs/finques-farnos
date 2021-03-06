<?php

namespace FinquesFarnos\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact class
 *
 * @category Entity
 * @package  FinquesFarnos\AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Entity(repositoryClass="FinquesFarnos\AppBundle\Repository\ContactRepository")
 * @ORM\Table(name="contact")
 */
class Contact extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="ContactMessage", mappedBy="contact", cascade={"persist", "remove"})
     * @ORM\OrderBy({"createdAt" = "ASC"})
     * @var ArrayCollection
     */
    private $messages;

    /**
     * @ORM\Column(type="string", length=255, name="name", nullable=false, unique=false)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, name="phone", nullable=false, unique=false)
     * @var string
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, name="email", nullable=false, unique=true)
     * @Assert\Email(
     *     strict = true,
     *     checkMX = true
     * )
     * @var string
     */
    private $email;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name ? $this->name : '---';
    }

    /**
     * Set Email
     *
     * @param string $email email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add message
     *
     * @param ContactMessage $message
     *
     * @return $this
     */
    public function addMessage(ContactMessage $message)
    {
        $message->setContact($this);
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param ContactMessage $message
     *
     * @return $this
     */
    public function removeMessage(ContactMessage $message)
    {
        $this->messages->removeElement($message);

        return $this;
    }

    /**
     * Set Messages
     *
     * @param ArrayCollection $messages messages
     *
     * @return $this
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get Messages
     *
     * @return ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set Name
     *
     * @param string $name name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Phone
     *
     * @param string $phone phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get Phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
