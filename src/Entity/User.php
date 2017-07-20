<?php

namespace Catalyst\Entity;

/**
 * @Entity
 * @Table(name="user")
 */
class User
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(length=250, unique=true)
     */
    private $email;

    /**
     * @Column(length=250)
     */
    private $name;

    /**
     * @Column(length=250)
     */
    private $surname;
}