
        <h3>This is an MVC design pattern with routes, have a great job!</h3>


        <form method="get">
                NOME<input type="text" name="nome">
        SEXO<input type="text" name="sexo">
        <button>Filtrar</button>
</form>
<table class="table table-dark table-striped">
        <thead>
                <th>CÓDIGO</th>
                <th>NOME</th>
                <th>EMAIL</th>
                <th>SEXO</th>
                <th>NASCIMENTO</th>
        </thead>
        <tbody>
                {{items}}
        </tbody>
</table>
<div>
        {{pagination}}
</div>

<div>
        <a href='{{URL}}/about'>About</a>
</div>
