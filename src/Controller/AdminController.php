<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

class AdminController extends AbstractController
{
    #[Route('/admin/article', name: 'admin_article')]
    #[Route('/admin', name: 'admin')]
    public function administrationArticle(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();

        return $this->render('admin/admin-article.html.twig', [
            'listeArticle' => $articles,
        ]);
    }

    #[Route('/admin/creation-article', name: 'creation_article')]
    #[Route('/admin/modifier-article/{id}', name: 'modifier_article')]
    public function modifierArticle(Article $article = null, Request $request, EntityManagerInterface $manager): Response
    {
        if ($article == null) {
            $article = new Article();
        }

        $formulaire = $this->createFormBuilder($article)
            ->add('titre', TextType::class, [
                'label' => 'Titre de l\'article',
                'attr' => [
                    'placeholder' => 'Titre de l\'article',
                    'class' => 'form-control',
                ]
            ])

            ->add('auteur', EntityType::class, [
                'class' => User::class,
                'choice_label' => function ($auteur) {
                    return $auteur->getPrenom() . ' ' . $auteur->getNom();
                },
                'attr' => [
                    'placeholder' => 'Nom de l\'auteur',
                    'class' => 'form-control',
                ]
            ])

            ->add('date', DateType::class, [
                'label' => 'Date',
                'attr' => [
                    'placeholder' => 'Date',
                    'class' => 'form-control',
                ]
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Contenu de l\'article',
                'attr' => [
                    'placeholder' => 'Contenu de l\'article',
                    'class' => 'form-control',
                ]
            ])

            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/png', 'image/jpeg'],
                        'mimeTypesMessage' => 'Format jpg ou png uniquement'
                    ])
                ]
            ])

            ->add('Save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-success'
                ],
            ])
            ->getForm();

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {

            $image = $formulaire->get('image')->getData();

            // si l'utilisateur a sélectionné un fichier
            if ($image) {
                $nomOriginal = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $nomUnique = $nomOriginal . '-' . uniqid() . '.' . $image->guessExtension();
                $image->move("uploads", $nomUnique);

                $article->setImage($nomUnique);
            }

            $manager->persist($article);
            $manager->flush();
            return $this->redirect('/admin');
        }

        $vueFormulaire = $formulaire->createView();

        return $this->render('admin/modifier-article.html.twig', [
            'article' => $article,
            'vueFormulaire' => $vueFormulaire,
        ]);
    }

    #[Route('/users', name: 'users')]
    public function usersList(UserRepository $users)
    {
        $listeUsers = $users->findAll();

        return $this->render('admin/users.html.twig', [
            'listeUsers' => $listeUsers,
        ]);
    }

    #[Route('/admin/modifier-user/{id}', name: 'modifier_user')]
    public function modifierUser(User $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("users", [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm("admin/modifier-user.html.twig", [
            "user" => $user,
            "form" => $form,
        ]);
    }
}
