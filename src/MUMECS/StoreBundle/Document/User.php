<?php

/*
 * The MIT License
 *
 * Copyright 2013 darkstar.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace MUMECS\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Description of User
 *
 * @author Federico Moro del Álamo <femodela@alumni.uv.es>
 */

/**
 * @MongoDB\Document
 * @MongoDBUnique(fields="email")
 */
class User implements UserInterface, EquatableInterface {
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     * @MongoDB\Index(unique=true, order="asc")
     */
    protected $email;
    
    /**
     * @MongoDB\String
     */
    protected $token;
    
    /**
     * @MongoDB\String
     */
    protected $password;
    
    /**
     * @MongoDB\String
     */
    protected $salt;
    
    /**
     * @MongoDB\String
     */
    protected $sex;
    
    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @MongoDB\String
     */
    protected $surname;
    
    /**
     * @MongoDB\String
     */
    protected $region;
    
    /**
     * @MongoDB\String
     */
    protected $status;
    
    /**
     * @MongoDB\Date
     */
    protected $registrationDate;
    
    /**
     * @MongoDB\Boolean
     */
    protected $deleted;
    
    public function __construct() {
        $this->status = "notvalidated";
        $this->registrationDate = new \DateTime();
        $this->token = md5((string) $this->registrationDate->format('Y-m-d H:i:s:u'));
        $this->deleted = false;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get token
     *
     * @return string $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    
    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return self
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Get salt
     *
     * @return string $salt
     */
    public function getSalt() {
        return $this->salt;
    }
    
    /**
     * Set sex
     *
     * @param string $sex
     * @return self
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * Get sex
     *
     * @return string $sex
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return self
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * Get surname
     *
     * @return string $surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return self
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get region
     *
     * @return string $region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set registrationDate
     *
     * @param date $registrationDate
     * @return self
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;
        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return date $registrationDate
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return self
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * Is deleted
     *
     * @return boolean $deleted
     */
    public function isDeleted()
    {
        return $this->deleted;
    }
    
    public function eraseCredentials() {
        
    }
    
    public function getRoles() {
        $rol = 'ROLE_'.strtoupper($this->getType());
        if ($this->isDeleted())
            $rol .= '_DELETED';
        elseif (!is_null($this->getStatus()))
            $rol .= '_'.strtoupper($this->getEstado());

        return array($rol);
    }

    public function getUsername() {
        $this->getEmail();
    }

    public function isEqualTo(UserInterface $user) {
        return $this->getEmail() == $user->getEmail();
    }
    
    public function __toString() {
        if (!is_null($this->getSurname()))
            return $this->getName()." ".$this->getSurname();
        return $this->getName();
    }

    public function getType() {
        $className = ($this instanceof \Doctrine\ORM\Proxy\Proxy) ? get_parent_class($this) : get_class($this);
        $partes = explode('\\', $className);
        return strtolower($partes[count($partes)-1]);
    }
}
