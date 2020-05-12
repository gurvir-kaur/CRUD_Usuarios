<?php

namespace App\Controller;

use App\Entity\Usuarios;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsuariosController extends AbstractController
{
    /**
     * @Route("/usuarios", name="usuarios")
     */
    public function index()
    {
        return $this->mostrar_usuario();
       // return $this->render('usuarios/index.html.twig');
    }

    /**
     * @Route ("add_new_usuario", name="add_new_usuario")
     *
     */
    public function add_new_usuario()
    {
        $action = $this->generateUrl('add_new_usuario');
        return $this->render('usuarios/index.html.twig', ['action' => $action]);
    }

    /**
     * @Route ("add_usuario", name="add_usuario")
     *
     */
    public function add_usuario(Request $request)
    {

        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $fecha_de_creacion = $request->request->get('fecha_de_creacion');

        // creates an object of product and initializes some data for this example
        $usuario = new Usuarios();
        $usuario->setEmail($email);
        $usuario->setPassword($password);
        $usuario->setFechaDeCreacion(\DateTime::createFromFormat('Ymd', '20170101'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($usuario);
        $entityManager->flush();


        return $this->render('usuarios/added.html.twig');
    }

    /**
     * @Route ("mostrar_usuario", name="mostrar_usuario")
     */
    public function mostrar_usuario()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $respository = $entityManager->getRepository(Usuarios::class);
        $usuario = $respository->findAll();
        return $this->render('usuarios/index.html.twig',
            [
                'usuario' => $usuario,
            ]
        );
    }


    /**
     * @Route ("delete_usuario/{id}", name="delete_usuario")
     */
    public function delete_usuario($id)
    {
        $usuario = $this->getDoctrine()->getRepository(Usuarios::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($usuario);
        $entityManager->flush();

        return $this->render('usuarios/deleted.html.twig');
    }

    /**
     * @Route ("modify_usuario/{id}", name="modify_usuario")
     */
    public function modify_usuario($id)
    {

        $usuario = $this->getDoctrine()->getRepository(Usuarios::class)->find($id);
        return $this->render('usuarios/modify.html.twig',
            [
                'usuario' => $usuario,
            ]
        );
    }

    /**
     * @Route ("modified_usuario/{id}", name="modified_usuario")
     */
    public function modified_usuario(Request $request, $id)
    {

        $usuario = $this->getDoctrine()->getRepository(Usuarios::class)->find($id);

        $email = $request->request->get('email');
        $password = $request->request->get('password');
        //$fecha_de_creacion = $request->request->get('fecha_de_creacion');

        $usuario->setEmail($email);
        $usuario->setPassword($password);
        $usuario->setFechaDeCreacion(\DateTime::createFromFormat('Ymd', '20170101'));

        $entityManager = $this->getDoctrine()->getManager();
        //$entityManager->persist($item);
        $entityManager->flush();

        //this return shows the new item added
        return $this->render('usuarios/index.html.twig');

    }

}
