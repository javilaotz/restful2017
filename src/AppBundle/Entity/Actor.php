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
     * @ORM\Column(name="nombre", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_nacimiento", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $anio_nacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="n", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $n;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Pelicula", mappedBy="actors")
     */
    private $peliculas;

    /**
     * @var \AppBundle\Entity\Pais
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pais", inversedBy="actors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="paises_id", referencedColumnName="id")
     * })
     */
    private $paises;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->peliculas = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * Add pelicula
     *
     * @param \AppBundle\Entity\Pelicula $pelicula
     *
     * @return Actor
     */
    public function addPelicula(\AppBundle\Entity\Pelicula $pelicula)
    {
        $this->peliculas[] = $pelicula;

        return $this;
    }

    /**
     * Remove pelicula
     *
     * @param \AppBundle\Entity\Pelicula $pelicula
     */
    public function removePelicula(\AppBundle\Entity\Pelicula $pelicula)
    {
        $this->peliculas->removeElement($pelicula);
    }

    /**
     * Get peliculas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeliculas()
    {
        return $this->peliculas;
    }

    /**
     * Set paises
     *
     * @param \AppBundle\Entity\Pais $paises
     *
     * @return Actor
     */
    public function setPaises(\AppBundle\Entity\Pais $paises = null)
    {
        $this->paises = $paises;

        return $this;
    }

    /**
     * Get paises
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPaises()
    {
        return $this->paises;
    }
}

