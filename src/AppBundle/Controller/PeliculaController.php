<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Pelicula;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Pais;

class PeliculaController extends FOSRestController
{
    /**
     * @Rest\Get("/peliculas")
     */
    public function peliculasAction(Request $request)
    {
        #Administrador de entidades
        $em = $this->getDoctrine()->getManager();

        #cargamos repositorio de peliculas
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');
        $output = array();

        #Traemos peliculas
        $peliculas = $repoPeliculas->findAll();

        #validamos existencia de peliculas
        if ($peliculas) {
          # cargamos la vista con las peliculas
          return new View($peliculas, Response::HTTP_OK);
        }else{
          #cargamos mensaje de peliculas inexistentes
          return new View('En este momento no podemos mostrar peliculas.', Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Rest\Post("/peliculas")
     */
    public function postPeliculaAction(Request $request)
    {
        #administrador de entidades
        $em = $this->getDoctrine()->getManager();

        #manejador de mensajes
        $mensajes = array();

        #parametros de entrada
        #--Para pelicula--
          $nombre = $request->request->get('nombre');
          $resumen = $request->request->get('resumen');
          $trailer = $request->request->get('trailer');
        #--Para categoria--
          $categoria = $request->request->get('categoria');
        #--Para pais--
          $pais = $request->request->get('pais');

        #validamos que el nombre exista
        if ($nombre==="") {
          # no hay nada, mostramos mensaje de error de variable vacía
          return new View('Por favor ingrese un nombre para la pelicula', Response::HTTP_INTERNAL_SERVER_ERROR);
        }else{
          #datos válidos, procedemos a guardar
          #definimos Pelicula
            $pelicula = new Pelicula();
            $pelicula->setNombre($nombre);
            $pelicula->setResumen($resumen);
            $pelicula->setUrlTrailer($trailer);

          # -> Categorias
          #Consultamos Categorias
            $repoCategorias = $em->getRepository('AppBundle:Categoria');
            $categorias = $repoCategorias->findOneBy(array('nombre' => $categoria));

            if ($categorias) {
              #si existe una con el mimso nombre, cargamos el id a la pelicula que vamos a crear
              #asignamos el id de la categoria a la pelicula que acabamos de crear
                $pelicula->setCategoria($categorias);

            } else {
              #de lo contrario, creamos categoria y cargamos el id a la pelicula que vamos a crear
              $nueva_categoria = new Categoria();
              $nueva_categoria->setNombre($categoria);

              try {
                  $em->persist($nueva_categoria);
                  $em->flush();
                  $mensajes[] = 'La Categoria "'.$categoria.'" fue creada satisfactoriamente.';
              } catch (exception $e) {
                  $mensajes[] = 'Se presentó un error creando la categoria "'.$categoria.'".';
              }
              $pelicula->setCategoria($nueva_categoria);
            }

            # -> Paises
            #Consultamos paises
              $repoPaises = $em->getRepository('AppBundle:Pais');
              $paises = $repoPaises->findOneBy(array('nombre' => $pais));

              if ($paises) {
                #si existe uno con el mimso nombre, cargamos el id a la pelicula que vamos a crear
                #asignamos el id de la categoria a la pelicula que acabamos de crear
                  $pelicula->setPais($paises);

              } else {
                #de lo contrario, creamos un pais y cargamos el id a la pelicula que vamos a crear
                $nuevo_pais = new Pais();
                $nuevo_pais->setNombre($pais);

                try {
                    $em->persist($nuevo_pais);
                    $em->flush();
                    $mensajes[] = 'el Pais "'.$pais.'" fue creado satisfactoriamente.';
                } catch (exception $e) {
                    $mensajes[] = 'Se presentó un error creando el Pais "'.$pais.'".';
                }
                $pelicula->setPais($nuevo_pais);
              }

          #creamos Pelicula
            try {
                $em->persist($pelicula);
                $em->flush();
                $mensajes[] = 'La pelicula "'.$nombre.'" fue creada satisfactoriamente.';
                return new View($mensajes, Response::HTTP_CREATED);
            } catch (exception $e) {
                $mensajes[] = 'Se presentó un error creando la pelicula "'.$nombre.'".';
                return new View($mensajes, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @Rest\Put("/peliculas/{id}")
     */
    public function putPeliculaAction(Request $request, $id)
    {
        #administrador de entidades
        $em = $this->getDoctrine()->getManager();
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');

        #parametros de la petición
        $nombre = $request->request->get('nombre');
        $resumen = $request->request->get('resumen');
        $trailer = $request->request->get('trailer');

        #entidad
        $pelicula = $repoPeliculas->find($id);
        $nombre_viejo = $pelicula->getNombre();
        $pelicula->setNombre($nombre);
        $pelicula->setResumen($resumen);
        $pelicula->setUrlTrailer($trailer);

        // persistencia
        try {
            $em->persist($pelicula);
            $em->flush();
            return new View('Actualizacion satisfactoria. La pelicula: '.$nombre_viejo.' fue actualizada por: '.$nombre.' junto con todos sus otros valores.', Response::HTTP_CREATED);
        } catch (exception $e) {
            return new View('Se presentó un error realizando la actualizacion.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
