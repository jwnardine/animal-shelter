<?php
class Pet
{
    private $description;
    private $breed_id;
    private $id;

    function __construct($description, $id = null, $breed_id)
    {
        $this->description = $description;
        $this->id = $id;
        $this->breed_id = $breed_id;
    }

    function SetDescription($new_description)
    {
        $this->description = (string) $new_description;
    }

    function GetDescription()
    {
        return $this->description;
    }

    function getId()
    {
        return $this->id;
    }

    function getBreedId()
    {
      return $this->breed_id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO pets (description, breed_id) VALUES ('{$this->GetDescription()}', {$this->getBreedId()})");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_pets = $GLOBALS['DB']->query("SELECT * FROM pets;");
        $pets = array();
        foreach($returned_pets as $pet) {
            $description = $pet['description'];
            $id = $pet['id'];
            $breed_id = $pet['breed_id'];
            $new_pet = new Pet($description, $id, $breed_id);
            array_push($pets, $new_pet);
        }
        return $pets;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM pets;");
    }

    static function find($search_id)
    {
        $found_pet = null;
        $pets = Pet::getAll();
        foreach($pets as $pet) {
           $pet_id = $pet->getId();
           if ($pet_id == $search_id) {
               $found_pet = $pet;
           }
       }
        return $found_pet;
    }
}
?>
