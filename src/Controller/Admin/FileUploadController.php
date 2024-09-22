<?php

namespace App\Controller\Admin;

use App\Form\FileUploadType;
use App\Form\Models\FileUploadModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage files uploads in the backend.
 *
 * @Route("/admin/file-upload")
 * @IsGranted("ROLE_ADMIN")
 *
 * @author GerMdz <gerardo.montivero@gmail.com>
 */
class FileUploadController extends AbstractController
{
    /**
     * @Route("/", name="app_file_upload")
     */
    public function index(): Response
    {
        return $this->render('admin/file_upload/index.html.twig', [
            'controller_name' => 'FileUploadController',
        ]);
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/new", methods="GET|POST", name="app_admin_file-upload_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function new(Request $request): Response
    {
        $file = new FileUploadModel();

        $form = $this->createForm(FileUploadType::class, $file)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'post.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('app_admin_file-upload_new');
            }

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/file_upload/new.html.twig', [
            'file' => $file,
            'form' => $form->createView(),
        ]);
    }
}
