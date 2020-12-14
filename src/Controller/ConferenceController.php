<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use App\SpamChecker;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;


class ConferenceController extends AbstractController
{
    private $twig;
    private $entityManager;

    /**
     * ConferenceController constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }


    /**
     * Index
     *
     * @param ConferenceRepository $conferenceRepository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return new Response($this->twig->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll()
        ]));
    }


    /**
     * @param Request $request
     * @param Conference $conference
     * @param CommentRepository $commentRepository
     * @param SpamChecker $spamChecker
     * @param string $photoDir
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function showOne(
        Request $request,
        Conference $conference,
        CommentRepository $commentRepository,
        SpamChecker $spamChecker,
        string $photoDir)
    {
        /* init form */
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        /* if form submit */
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setConference($conference);
            if ($photo = $form['photo']->getData()) {
                $fileName = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                try {
                    $photo->move($photoDir, $fileName);
                } catch (FileException $e) {
                    // unable to upload the photo, give up
                }
                $comment->setPhoto($fileName);
            }
            /* persist */
            $this->entityManager->persist($comment);
            /* check Spam */
            $context = [
                'user_ip' => $request->getClientIp(),
                'user_agent' => $request->headers->get('user-agent'),
                'referrer' => $request->headers->get('referer'),
                'permalink' => $request->getUri(),
            ];
            if (2 === $spamChecker->getSpamScore($comment, $context)) {
                throw new \RuntimeException('Spam, go away!');
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('conference/show-one', ['slug' => $conference->getSlug()]);
        }

        /* pagination */
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        return new Response($this->twig->render('conference/show-one.html.twig', [
            'comment_form' => $form->createView(),
            'conference' => $conference,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            ])
        );
    }





}
