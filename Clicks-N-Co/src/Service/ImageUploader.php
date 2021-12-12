<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Shop;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
  public function createFileName(UploadedFile $uploadedFile): string
  {
    return uniqid() . '.' . $uploadedFile->guessExtension();
  }

  /**
   * On a fait en sorte que cette méthode soit utilisable avec un formulaire quelconque
   * Quand on l'utilise, on précise le nom du champs où se trouve l'image et le dosier cible où la placer
   * 
   * @param Form $form L'objet formulaire duquel extraire le champs 'file' pour déplacer le fichier dans /public
   * @param string $fieldName Le nom du champs duquel extraire l'objet UploadedFile
   * @param string $targetDirectory Le dossier cible où on souhaite envoyer l'image
   * @return string Le nom du fichier tout juste créé dans /public
   */
  public function uploadImage(Form $form, string $fieldName, string $targetDirectory): string
  {
    // Un fichier uploadé est représenté avec Symfony par un objet UploadedFile
    // On lé récupère depuis le champs file
    $uploadedFile = $form->get($fieldName)->getData();

    // Pour éviter d'écraser nos fichiers, on doit s'assurer que leurs noms sont uniques
    // On adopte une stratégie comme on veut pour choisir un nouveau nom
    // Ici on utilise unidiq() pour le nom et guessExtension() pour l'extension
    $newFilename = $this->createFileName($uploadedFile);

    // Tous les fichiers reçus par PHP sont placés temporairement dans /tmp (ou C:\windows\temp)
    // Il faut demander à PHP de déplacer le fichier là où ça nous arrange
    // En PHP pur, on utilise move_uploaded_file(). Avec Symfony on utilise la méthode move()
    /**
     * @param $directory Le dossier où on veut envoyer le fichier
     * @param $filename Le nom qu'on veut donner au fichier
     */
    // $uploadedFilemove('question_images', $newFilename);
    // Le dossier cible est ici écrit en dur, on pourrait le rendre paramètrable
    // Il est possible d'utiliser des paramètres dans servics.yaml
    // $uploadedFile->move($this->getParameter('dossier_images'), $newFilename);
    // Ou alors on utilise les variables des fichiers .env
    $uploadedFile->move($targetDirectory, $newFilename);

    // On retourne le nouveau nom du fichier
    return $newFilename;
  }

  public function uploadCategoryImage(Form $form)
  {
    // On récupère l'objet Question grace à $form
    $category = $form->getData();

    // $form est l'objet Form utilisé dans le controleur
    // 'picture' est le nom du champs dans QuestionType
    // $_ENV['IMAGES_CATEGORY'] est le dossier où on stocke nos images pour les questions
    $newFilename = $this->uploadImage($form, 'picture', $_ENV['IMAGES_CATEGORY']);

    // On affecte le nouveau du fichier dans $question
    $category->setImage($newFilename);
  }

  public function uploadProductImage(Form $form)
  {
    $product = $form->getData();

    $newFilename = $this->uploadImage($form, 'picture', $_ENV['IMAGES_PRODUCT']);

    $product->setImage($newFilename);
  }

  public function uploadShopImage(Form $form)
  {
    $shop = $form->getData();

    $newFilename = $this->uploadImage($form, 'picture', $_ENV['IMAGES_SHOP']);

    $shop->setImage($newFilename);
  }
}
