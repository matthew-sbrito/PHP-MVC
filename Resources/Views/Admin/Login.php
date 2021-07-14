<div class="d-flex justify-content-center">
  <div class="card mt-3 text-dark text-center" style="width: 500px">
    <div class="card-header">
      <h1>Login</h1>
    </div>
    <div class="card-body">
      {{message}}
      <form method="post">
        <div class="form-group">
          <label>Email</label>
          <input class="form-control" type="email" name="email" required autofocus>
        </div>
        <div class="form-group my-3">
          <label>Senha</label>
          <input class="form-control" type="password" name="senha">
        </div>
        <button class="btn ntm-lg btn-dark">Logar</button>
      </form>
    </div>
  </div>
</div>
<script>
  setTimeout(() => {
    const msg = document.querySelector('.alert')
    console.log(msg)
    msg.className = '';
    msg.setAttribute("hidden", true);
  }, 5000)
</script>