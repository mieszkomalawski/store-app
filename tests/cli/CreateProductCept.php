<?php 
$I = new CliTester($scenario);
$I->runShellCommand('php bin/console.php app:create-product kombajn 100');
$I->seeInShellOutput('Product create with id');