<?php foreach($dados as $dado):?>
        <h2>My name is <strong><?= $dado['nome']?></strong> I'm <strong><?= $dado['idade']?></strong> years old!</h2>
        <p>This repository is intended to help you start a PHP project!</p>
<?php endforeach; ?>

<a href="<?=$url?>/home">Home</a>