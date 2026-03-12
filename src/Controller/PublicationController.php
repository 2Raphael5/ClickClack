<?php
namespace ClickClack\ClickClack\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ClickClack\ClickClack\Model\User;
use DateTime;
use Slim\Views\PhpRenderer;

class PublicationController
{
    //Affiche l'accueil
    public function afficherPageAjoutPublication(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        return $renderer->render($response, 'publication.php', []);

    }
    public function verifierPageAjoutPublication(Request $request, Response $response, array $args): Response
    {
        $renderer = new PhpRenderer("../view");
        $renderer->setLayout("layout.php");
        var_dump($_FILES);
        die;
        $allow = ["jpg", "png"];
        $randomName = null;
        $errors = [];
        if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
            $info = explode('.', strtolower($_FILES['img']['name']));
            $extension = end($info);

            if ($_FILES['img']['error'] !== 0 && $_FILES['img']['error'] !== null) {
                array_push($errors, "Erreur lors de l'upload : " . $_FILES['img']['error']);
            } elseif (in_array($extension, $allow)) {

                do {
                    $randomName = uniqid() . "_" . urlencode(basename($_FILES['img']['name']));
                    $imgPath = __DIR__ . "/../../public/img/" . $randomName;
                } while (file_exists($imgPath));

                if (!move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
                    array_push($errors, "Erreur lors du déplacement du fichier.");
                } else {
                    
                    $oldImg = $article['img'] ?? null;
                    if ($oldImg && $oldImg !== 'default.jpg') {
                        $oldPath = __DIR__ . "/../../public/img/" . $oldImg;
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }
            }
        }
       var_dump(isset($_FILES['img']));
        return $renderer->render($response, 'publication.php', []);

    }
}