<?php
$action = filter_input(INPUT_GET, 'action');

switch ($action) {
    case 'show':
        include "vues/formPost.php";
        break;

    case 'validate':
        // récupéraion de la description
        $desc = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
        // récupération des fichiers
        $fichiersArray = $_FILES["files"];

        // verification si les champs ont été remplis
        if ($desc != "" && $fichiersArray['name'][0] != "") {

            $totalMo = 0;

            // récupérer les fichiers
            $newImagesArray = [];
            for ($i = 0; $i < count($fichiersArray['name']); $i++) {

                // vérifier si le fichier est une image , video ou audio
                if (explode("/", $fichiersArray['type'][$i])[0] != "image" && explode("/", $fichiersArray['type'][$i])[0] != "video" && explode("/", $fichiersArray['type'][$i])[0] != "audio") {
                    $_SESSION['message'] = [
                        'type' => "danger",
                        'content' => "Les fichiers ne peuvent être que des images, vidéos ou audio !"
                    ];
                    header('Location: index.php?uc=post&action=show');
                }


                $fileMo = Media::ConvertOToMO($fichiersArray['size'][$i]);
                // si la taille de chaque image afin de ne pas dépacer 3 Mo
                if ($fileMo > 3) {
                    $_SESSION['message'] = [
                        'type' => "danger",
                        'content' => "Chaque image doit faire moins de 3 Mo !"
                    ];
                    header('Location: index.php?uc=post&action=show');
                } else {
                    $totalMo .= $fileMo;
                }

                // si la taille totale de tous les fichiers afin de ne pas dépacer 70 Mo
                if ($totalMo > 70) {
                    $_SESSION['message'] = [
                        'type' => "danger",
                        'content' => "Le total des fichiers doit faire moins de 70 Mo !"
                    ];
                    header('Location: index.php?uc=post&action=show');
                }

                $newImagesArray[$i] = [
                    "name" => $fichiersArray['name'][$i],
                    "type" => $fichiersArray['type'][$i],
                    "tmp_name" => $fichiersArray['tmp_name'][$i],
                    "size" => $fichiersArray['size'][$i]
                ];
            }

            $currentDate = date("Y/m/d/H/i/s");

            // Début de la transaction
            MonPdo::getInstance()->beginTransaction();

            // on crée le post dans la base de données
            $post = new Post();
            $post->setCommentaire($desc)
                ->setCreationDate($currentDate)
                ->setModificationDate($currentDate);
            $idPost = Post::AddPost($post);

            // on crée les médias dans la base de données
            $dirFile = "./assets/uploads/";
            foreach ($newImagesArray as $imageArray) {
                $randomName = Media::GenerateRandomName() . "." . explode("/", $imageArray['type'])[1];

                while (file_exists($dirFile . $randomName)) {
                    $randomName = Media::GenerateRandomName() . "." . explode("/", $imageArray['type'])[1];
                }

                $filepath = $dirFile . $randomName;

                if (move_uploaded_file($imageArray['tmp_name'], $filepath)) {
                    $media = new Media();
                    $media->setTypeMedia($imageArray['type'])
                        ->setNomMedia($randomName)
                        ->setCreationDate($currentDate)
                        ->setModificationDate($currentDate)
                        ->setIdPost($idPost);
                    Media::AddMedia($media);
                } else {
                    // si il y a un fichier qui ne se push pas rollback et cancel les requêtes
                    MonPdo::getInstance()->rollBack();
                    $_SESSION['message'] = [
                        'type' => "danger",
                        'content' => "Une image n'a pas pu être publié !"
                    ];
                    header('Location: index.php?uc=post&action=show');
                }
            }

            // on push les infos dans base de donnée avec le commit
            MonPdo::getInstance()->commit();

            // message de success de création du post et des médias
            $_SESSION['message'] = [
                'type' => "success",
                'content' => "Le post à bien été crée et tous les fichiers ont été importés"
            ];
            header('Location: index.php?uc=post&action=show');
        } else {
            // retourne un message d'erreur si les champs ne sonts pas remplis
            $_SESSION['message'] = [
                'type' => "danger",
                'content' => "Merci de remplir tous les champs !"
            ];
            header('Location: index.php?uc=post&action=show');
        }
        break;
        case 'delete':
          // recup du post
          $idPost = filter_input(INPUT_GET, 'idPost', FILTER_SANITIZE_NUMBER_INT);
  
          // sup des images
          $medias = Media::getAllMediasByPostId($idPost);
  
          // debut de la transaction
          MonPdo::getInstance()->beginTransaction();
  
          // suppression de tous les fichiers
          foreach ($medias as $media) {
              if (unlink("./assets/uploads/" . $media->getNomMedia())) {
                  Media::DeleteMedia($media->getIdMedia());
              } else {
                  // on arrete la transaction
                  MonPdo::getInstance()->rollBack();
                  // retourne un message d'erreur
                  $_SESSION['message'] = [
                      'type' => "danger",
                      'content' => "Un fichier n'a pas pu être supprimé. Merci de ressayer."
                  ];
                  header('Location: index.php');
              }
          }
          Post::DeletePost($idPost);
          MonPdo::getInstance()->commit();
          $_SESSION['message'] = [
              'type' => "success",
              'content' => "Le post a bien été supprimé."
          ];
          header('Location: index.php');
          break;
}