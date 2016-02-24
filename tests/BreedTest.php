<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Breed.php";
    require_once "src/Pet.php";

    $server = 'mysql:host=localhost;dbname=animal_shelter_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BreedTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Breed::deleteAll();
          Pet::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Dogs";
            $test_Breed = new Breed($name);

            //Act
            $result = $test_Breed->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Dogs";
            $id = 1;
            $test_Breed = new Breed($name, $id);

            //Act
            $result = $test_Breed->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Dogs";
            $test_Breed = new Breed($name);
            $test_Breed->save();

            //Act
            $result = Breed::getAll();

            //Assert
            $this->assertEquals($test_Breed, $result[0]);
        }

        function testGetPets()
        {
            //Arrange
            $name = "Dogs";
            $id = null;
            $test_breed = new Breed($name, $id);
            $test_breed->save();

            $test_breed_id = $test_breed->getId();

            $description = "Fido";
            $test_pet = new Pet($description, $id, $test_breed_id);
            $test_pet->save();

            $description2 = "Spot";
            $test_pet2 = new Pet($description2, $id, $test_breed_id);
            $test_pet2->save();

            //Act
            $result = $test_breed->getPets();

            //Assert
            $this->assertEquals([$test_pet, $test_pet2], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Dogs";
            $name2 = "Cats";
            $test_Breed = new Breed($name);
            $test_Breed->save();
            $test_Breed2 = new Breed($name2);
            $test_Breed2->save();

            //Act
            $result = Breed::getAll();

            //Assert
            $this->assertEquals([$test_Breed, $test_Breed2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Felix";
            $name2 = "Cats";
            $test_Breed = new Breed($name);
            $test_Breed->save();
            $test_Breed2 = new Breed($name2);
            $test_Breed2->save();

            //Act
            Breed::deleteAll();
            $result = Breed::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Felix";
            $name2 = "Cats";
            $test_Breed = new Breed($name);
            $test_Breed->save();
            $test_Breed2 = new Breed($name2);
            $test_Breed2->save();

            //Act
            $result = Breed::find($test_Breed->getId());

            //Assert
            $this->assertEquals($test_Breed, $result);
        }
    }

?>
