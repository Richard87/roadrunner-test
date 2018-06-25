<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 25.06.18
 * Time: 14:26
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestController
 * @package App\Controller
 */
class TestController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction() {
        return new Response("Hello world!");
    }
    /**
     * @Route("/admin")
     */
    public function adminAction() {
        return new Response("Hello Admin!");
    }
}