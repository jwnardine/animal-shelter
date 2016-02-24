<?php

/**
   * @backupGlobals disabled
   * @backupStaticAttributes disabled
   */

   require_once "src/Pet.php";
   require_once "src/Breed.php";

   $server = 'mysql:host=localhost;dbname=animal_shelter_test';
   $username = 'root';
   $password = 'root';
   $DB = new PDO($server, $username, $password);


   class PetTest extends PHPUnit_Framework_TestCase
   {
       protected function tearDown()
        {
            Pet::deleteAll();
            Breed::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Cats";
            $id = null;
            $test_breed = new Breed($name, $id);
            $test_breed->save();

            $description = "Felix";
            $breed_id = $test_breed->getId();
            $test_pet = new Pet($description, $id, $breed_id);
            $test_pet->save();

            //Act
            $result = $test_pet->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getBreedId()
        {
          //Arrange
            $name = "Cats";
            $id = null;
            $test_breed = new Breed($name, $id);
            $test_breed->save();

            $description = "Felix";
            $breed_id = $test_breed->getId();
            $test_pet = new Pet($description, $id, $breed_id);
            $test_pet->save();

            //Act
            $result = $test_pet->getBreedId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

       function test_save()
       {
           //Arrange
           $name = "Cats";
           $id = null;
           $test_breed = new Breed($name, $id);
           $test_breed->save();

           $description = "Felix";
           $breed_id = $test_breed->getId();
           $test_pet = new Pet($description, $id, $breed_id);

           //Act
           $test_pet->save();

           //Assert
           $result = Pet::getAll();
           $this->assertEquals($test_pet, $result[0]);
       }

       function test_getAll()
        {
            //Arrange
            $name = "Cats";
            $id = null;
            $test_breed = new Breed($name, $id);
            $test_breed->save();

            $description = "Felix";
            $breed_id = $test_breed->getId();
            $test_pet = new Pet($description, $id, $breed_id);
            $test_pet->save();

            $description2 = "Fluffy";
            $test_pet2 = new Pet($description2, $id, $breed_id);
            $test_pet2->save();

            //Act
            $result = Pet::getAll();

            //Assert
            $this->assertEquals([$test_pet, $test_pet2], $result);
        }

        function test_deleteAll()
       {
           //Arrange
           $name = "Cats";
           $id = null;
           $test_breed = new Breed($name, $id);
           $test_breed->save();

           $description = "Felix";
           $breed_id = $test_breed->getId();
           $test_pet = new Pet($description, $id, $breed_id);
           $test_pet->save();

           $description2 = "Fluffy";
           $test_pet2 = new Pet($description2, $id, $breed_id);
           $test_pet2->save();

           //Act
           Pet::deleteAll();

           //Assert
           $result = Pet::getAll();
           $this->assertEquals([], $result);
       }

       function test_find()
       {
           //Arrange
           $name = "Cats";
           $id = null;
           $test_breed = new Breed($name, $id);
           $test_breed->save();

           $description = "Felix";
           $breed_id = $test_breed->getId();
           $test_pet = new Pet($description, $id, $breed_id);
           $test_pet->save();

           $description2 = "Fluffy";
           $test_pet2 = new Pet($description2, $id, $breed_id);
           $test_pet2->save();

           //Act
           $result = Pet::find($test_pet->getId());

           //Assert
           $this->assertEquals($test_pet, $result);
       }
   }

?>
