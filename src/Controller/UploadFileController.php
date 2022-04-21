<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Entity\Photo;
use App\Entity\Validation;
use App\Form\FolderType;
use App\Form\PhotoType;
use App\Repository\FolderRepository;
use App\Repository\PhotoRepository;
use App\Repository\ValidationRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFileController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    #[Route('/upload/file', name: 'app_upload_file')]
    public function uploadFile(Request $request, SluggerInterface $slugger, PhotoRepository $photoRepository, ValidationRepository $validationRepository): Response
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form->get('uploadFile')->getData();


            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                // Move the file to the directory where files are stored
                try {
                    $photoFile->move(
                        $this->getParameter('file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'Filename' property to store the file name
                // instead of its contents
                $photo->setFileName($newFilename);
            }

            $validation = new Validation();

            $user = $this->security->getUser();

            $photo->setFolder(null);
            $photo->setUser($user);

            $validation->setPhoto($photo);
            $validation->setUser($user);
            $validation->setIsValidated(false);

            $photoRepository->add($photo);
            $validationRepository->add($validation);

            return $this->redirectToRoute('app_upload_folder_register', ['id' => $photo->getId()]);
        }

        return $this->renderForm('upload_file/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/upload/folderRegister', name: "app_upload_folder_register")]
    public function detail(Request $request, PhotoRepository $photoRepository, FolderRepository $folderRepository)
    {
        $photo = new Photo();
        $photo = $photoRepository->findOneById($request->get('id'));

        $path = "uploads/files/".$photo->getFileName();
        
        $folder = new Folder();
        
        $form = $this->createForm(FolderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $folderName = $form->get('folderName')->getData();

            $form->get('sideFolder')->getData();

            // si le dossier existe
            if ($folderRepository->findOneByfolderName($folderName)) {
                $destPath = "uploads/".$folderName."/".$photo->getFileName();
                rename($path,$destPath);
            }
            // si le dossier existe pas
            // le creer
            else {
                mkdir("./uploads/".$folderName, 0777);
                $destPath = "uploads/".$folderName."/".$photo->getFileName();
                rename($path,$destPath);
                $folder->setFolderName($folderName);
                $folderRepository->add($folder);
                $photo->setFolder($folder);
                $photoRepository->add($photo);
            }
            
            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('upload_file/detail.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }
}
