<?php

namespace FinquesFarnos\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactMessage class
 *
 * @category Entity
 * @package  FinquesFarnos\AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Entity(repositoryClass="FinquesFarnos\AppBundle\Repository\ContactMessageRepository")
 * @ORM\Table(name="contact_message")
 */
class ContactMessage extends Base
{
    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="messages")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="contact_id", referencedColumnName="id")})
     * @var Contact
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="Property", inversedBy="messages")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="property_id", referencedColumnName="id", nullable=true)})
     * @var Property
     */
    private $property;

    /**
     * @ORM\Column(type="text", length=4000, name="text", nullable=false)
     * @var string
     */
    private $text;

    /**
     * Set Text
     *
     * @param string $text text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get Text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set Contact
     *
     * @param Contact $contact
     *
     * @return $this
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get Contact
     *
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set Property
     *
     * @param Property $property
     *
     * @return $this
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get Property
     *
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->text ? $this->text : '---';
    }
}
