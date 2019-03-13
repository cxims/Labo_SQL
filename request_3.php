<?php

require('_classes/database.php');
require('assets/head.php');

$showResult = false;

if(isset($_POST['run']))
{
    $chenil = $_POST['chenil'];
    $showResult = true;
    $db = Database::connect();
    $request = $db->prepare('SELECT r.raceName, cat.categoryName, a.IdAnimal, a.animalName, c.chenilName, d.donatorName, d.GivenAt FROM animals a JOIN donators d ON d.IdDonator = a.IdDonator JOIN chenil c ON c.IdChenil = a.IdChenil JOIN categories cat ON cat.IdCategory = a.IdCategory JOIN races r ON r.IdRace = a.IdRace WHERE c.chenilName = ?');
    $request->execute(array($chenil));
    $rows = $request->fetchAll();
}

?>

<div class="container">

    <h1>Request 3</h1>

    <a class="btn btn-dark" href="index.php">Forward</a>

    <h2>See animals informations</h2>

    <form action="" method="POST">
        <label for="chenil">Chenil:</label>
            <select id="chenil" name="chenil">
                <option value="PetHeaven - Bordeaux">PetHeaven - Bordeaux</option>
                <option value="PetHeaven - Marseille">PetHeaven - Marseille</option>
                <option value="PetHeaven - Paris">PetHeaven - Paris</option>
            </select>

        <input class="btn btn-info" type="submit" name="run" value="Run"/>
    </form>


    <?php
        if($showResult)
        {
    ?>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Race</th>
                        <th>Arrival date</th>
                        <th>Donator</th>
                        <th>Chenil</th>
                    </tr>
                </thead>
                <tbody>
    <?php   
            foreach($rows as $row)
            {
    ?>
                <tr>
                    <td><?= $row['IdAnimal']; ?></td>
                    <td><?= $row['animalName']; ?></td>
                    <td><?= $row['categoryName']; ?></td>
                    <td><?= $row['raceName']; ?></td>
                    <td><?= $row['GivenAt']; ?></td>
                    <td><?= $row['donatorName']; ?></td>
                    <td><?= $row['chenilName']; ?></td>
                </tr>

    <?php
            }  
        }
        else
        {
            ?>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Race</th>
                        <th>Arrival date</th>
                        <th>Donator</th>
                        <th>Chenil</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                $db = Database::connect();
                $request = $db->prepare('SELECT r.raceName, cat.categoryName, a.IdAnimal, a.animalName, c.chenilName, d.donatorName, d.GivenAt 
                FROM animals a 
           
                JOIN donators d 
                ON d.IdDonator = a.IdDonator 
                JOIN chenil c 
                ON c.IdChenil = a.IdChenil 
                JOIN categories cat 
                ON cat.IdCategory = a.IdCategory 
                JOIN races r 
                ON r.IdRace = a.IdRace 
                WHERE a.IdDonator IS NOT NULL
                ORDER BY a.IdAnimal
                                            
                                            ');
                $request->execute();
                $rows = $request->fetchAll();

                        foreach($rows as $row)
                        {
                ?>
                            <tr>
                                <td><?= $row['IdAnimal']; ?></td>
                                <td><?= $row['animalName']; ?></td>
                                <td><?= $row['categoryName']; ?></td>
                                <td><?= $row['raceName']; ?></td>
                                <td><?= $row['GivenAt']; ?></td>
                                <td><?= $row['donatorName']; ?></td>
                                <td><?= $row['chenilName']; ?></td>
                            </tr>
            
                <?php
                        }  
        }
    ?>
            </table>

</div>