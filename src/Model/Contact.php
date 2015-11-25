<?php
namespace In2it\Phpunit\Model;

class Contact implements ModelInterface
{
    /**
     * @var int The contact ID
     */
    protected $contactId;
    /**
     * @var string The contact name
     */
    protected $name;
    /**
     * @var string The contact address
     */
    protected $address;
    /**
     * @var string The contact zip
     */
    protected $zip;
    /**
     * @var string The contact city
     */
    protected $city;
    /**
     * @var string The contact country
     */
    protected $country;
    /**
     * @var string The contact email
     */
    protected $email;
    /**
     * @var string The contact phone
     */
    protected $phone;
    /**
     * @var string The contact mobile
     */
    protected $mobile;

    /**
     * @inheritDoc
     */
    public function __construct(\stdClass $data = null)
    {
        if (null !== $data) {
            $this->populate($data);
        }
    }

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @param int $contactId
     * @return Contact
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Contact
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return Contact
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Contact
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Contact
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     * @return Contact
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function populate(\stdClass $row)
    {
        $this->setContactId($row->contact_id)
            ->setName($row->name)
            ->setAddress($row->address)
            ->setZip($row->zip)
            ->setCity($row->city)
            ->setCountry($row->country)
            ->setEmail($row->email)
            ->setPhone($row->phone)
            ->setMobile($row->mobile);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array (
            'contact_id' => $this->getContactId(),
            'name'       => $this->getName(),
            'address'    => $this->getAddress(),
            'zip'        => $this->getZip(),
            'city'       => $this->getCity(),
            'country'    => $this->getCountry(),
            'email'      => $this->getEmail(),
            'phone'      => $this->getPhone(),
            'mobile'     => $this->getMobile(),
        );
    }

}