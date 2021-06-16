<?php foreach($dados as $dado):?>
        <h2>Eu me chamo <strong><?= $dado['nome']?></strong> tenho <strong><?= $dado['idade']?></strong> anos!</h2>
        <h3>Este é um modelo de padrão MVC, tenha um ótimo trabalho!</h3>
<?php endforeach; ?>