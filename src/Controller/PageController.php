<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() 
    {
        return $this->render('page/home.html.twig');
    }

    /**
     * @Route("/{page}",
     *      name="display_page",
     *      requirements={"page": "about|contact"},
     *      methods={"HEAD", "GET"}
     * )
     */
    public function display($page) 
    {
        return $this->render('page/' . $page . '.html.twig');
    }

    // /**
    //  * @Route ("/phpinfo", name="phpinfo")
    //  * @return void
    //  */
    // public function phpInformation() 
    // {
    //     ob_start();
    //     phpinfo();
    //     $phpinfo = ob_get_contents();
    //     ob_end_clean();
    //     return $this->render('page/phpinfo.html.twig', array(
    //         'phpinfo'=> $phpinfo,
    //     ));
    // }
}
