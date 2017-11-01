<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actor
 *
 * @ORM\Table(name="actor")
 * @ORM\Entity
 */
class Actor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false, unique=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_nacimiento", type="integer", nullable=false, unique=false)
     */
    private $anio_nacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="n", type="string", length=255, nullable=false, unique=false)
     */
    private $n;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Actor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set anioNacimiento
     *
     * @param integer $anioNacimiento
     *
     * @return Actor
     */
    public function setAnioNacimiento($anioNacimiento)
    {
        $this->anio_nacimiento = $anioNacimiento;

        return $this;
    }

    /**
     * Get anioNacimiento
     *
     * @return integer
     */
    public function getAnioNacimiento()
    {
        return $this->anio_nacimiento;
    }

    /**
     * Set n
     *
     * @param string $n
     *
     * @return Actor
     */
    public function setN($n)
    {
        $this->n = $n;

        return $this;
    }

    /**
     * Get n
     *
     * @return string
     */
    public function getN()
    {
        return $this->n;
    }
}

