<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class ConferenceController extends AbstractController
{

    /**
     * Index
     *
     * @param Environment $twig
     * @param ConferenceRepository $conferenceRepository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
        return new Response($twig->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll()
        ]));
    }

    /**
     * Show one
     *
     * @param Environment $twig
     * @param Conference $conference
     * @param ConferenceRepository $conferenceRepository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function showOne(Conference $conference, Environment $twig, CommentRepository $commentRepository): Response
    {
        return new Response($twig->render('conference/show-one.html.twig', [
            'conference' => $conference,
            'comments' => $commentRepository->findBy(
                ['conference' => $conference],
                ['createdAt' => "DESC"]
            )])
        );
    }


}
