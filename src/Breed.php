<?php
    class Breed
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO breeds (name) VALUES ('{$this->getName()}')");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_breeds = $GLOBALS['DB']->query("SELECT * FROM breeds;");
            // var_dump($returned_breeds);
            $breeds = array();
            foreach($returned_breeds as $breed) {
                $name = $breed['name'];
                $id = $breed['id'];
                $new_breed = new Breed($name, $id);
                array_push($breeds, $new_breed);
            }
            return $breeds;
        }

        function getPets()
        {
            $pets = Array();
            $returned_pets = $GLOBALS['DB']->query("SELECT * FROM pets WHERE breed_id = {$this->getId()};");
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
          $GLOBALS['DB']->exec("DELETE FROM breeds;");
        }

        static function find($search_id)
        {
            $found_breed = null;
            $breeds = Breed::getAll();
            foreach($breeds as $breed) {
                $breed_id = $breed->getId();
                if ($breed_id == $search_id) {
                  $found_breed = $breed;
                }
            }
            return $found_breed;
        }
    }
?>
