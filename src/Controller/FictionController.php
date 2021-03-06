<?php

namespace App\Controller;

use App\Entity\Fiction;
use App\Repository\FictionCategoryRepository;
use App\Repository\FictionChapterRepository;
use App\Repository\FictionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FictionController extends BaseController
{
    /**
     * @Route("/fictions/{page<[1-9]\d*>}", name="fiction.index", defaults={"page": "1"}, methods={"GET"})
     */
    public function index(Request $request,
                          FictionRepository $fictionRepository,
                          FictionCategoryRepository $fictionCategoryRepository,
                          int $page): Response
    {
        $latest = $fictionRepository->searchLatest($request->query->all(), $page);
        $categories = $fictionCategoryRepository->findAll();

        return $this->render('fiction/index.html.twig', [
            'fictions' => $latest,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/fiction/{slug}/{page<[1-9]\d*>}", name="fiction.show", defaults={"page": "1"}, methods={"GET"})
     */
    public function show(Fiction $fiction, int $page, FictionChapterRepository $fictionChapterRepository): Response
    {
        $chapter = $fiction->getChapter($page);
        $chapters = $fictionChapterRepository->findLatestForFiction($fiction, $page, 'ASC');

        if (!$chapter) {
            throw new NotFoundHttpException('fiction.chapter_not_found');
        }

        return $this->render('fiction/show.html.twig', [
            'fiction' => $fiction,
            'chapter' => $chapter,
            'chapters' => $chapters
        ]);
    }
}
